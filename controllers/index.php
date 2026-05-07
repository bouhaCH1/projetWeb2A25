<?php
// controllers/index.php
require_once __DIR__ . '/../models/Database.php';
require_once __DIR__ . '/../models/Event.php';
require_once __DIR__ . '/../models/Resource.php';
require_once __DIR__ . '/../models/Payment.php';
require_once __DIR__ . '/EventController.php';
require_once __DIR__ . '/ResourceController.php';

$database = new Database();
$db = $database->getConnection();

$eventController    = new EventController($db);
$resourceController = new ResourceController($db);

$action = isset($_GET['action']) ? $_GET['action'] : 'user';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($action == 'save_event') {
        if (!empty($_POST['id'])) $eventController->updateEvent($_POST['id'], $_POST);
        else $eventController->createEvent($_POST);
        header("Location: index.php?action=admin"); exit;
    }
    if ($action == 'save_resource') {
        if (!empty($_POST['id'])) $resourceController->updateResource($_POST['id'], $_POST);
        else $resourceController->createResource($_POST);
        header("Location: index.php?action=admin"); exit;
    }
    if ($action == 'save_payment') {
        $payment = new Payment($db);
        $payment->create($_POST);
        echo "success"; exit;
    }
    if ($action == 'api_config' && isset($_GET['service'])) {
        include __DIR__ . '/../views/admin/api_config.php'; exit;
    }
    if ($action == 'inbox') {
        include __DIR__ . '/../views/admin/inbox.php'; exit;
    }
    if ($action == 'send_email') {
        require_once __DIR__ . '/../models/ApiService.php';
        require_once __DIR__ . '/../models/Event.php';
        require_once __DIR__ . '/../models/Notification.php';
        require_once __DIR__ . '/../config_api.php';
        $api = new ApiService();
        $eventModel = new Event($db);
        $notifModel = new Notification($db);
        
        $key = $_POST['key'];
        if(empty($key) || $key === 'admin') $key = SENDGRID_API_KEY; 
        
        $message = $_POST['message'] ?? "";
        
        if(isset($_POST['type']) && $_POST['type'] == 'event_report') {
            $events = $eventModel->getAll(); 
            $list = "<h2>Rapport de vos événements :</h2><ul>";
            foreach($events as $e) {
                $list .= "<li><strong>" . htmlspecialchars($e['title']) . "</strong> - " . date('d/m/Y H:i', strtotime($e['date'])) . " (" . htmlspecialchars($e['location']) . ")</li>";
            }
            $list .= "</ul>";
            $message = $list;
        }

        // Sauvegarde interne (Pour que l'utilisateur voit le mail dans son dashboard)
        $notifModel->save($_POST['from'], $_POST['to'], $_POST['subject'], $message);

        // --- GESTION DE L'ENVOI ---
        if($key === 'SG.METTEZ_VOTRE_CLE_ICI' || $key === 'admin' || empty($key)) {
            echo "success"; exit;
        }
        
        $res = $api->sendRealEmail($key, $_POST['from'], $_POST['to'], $_POST['subject'], $message);
        echo $res ? "success" : "error"; exit;
    }
}

if ($action == 'delete_event' && isset($_GET['id'])) {
    $eventController->deleteEvent($_GET['id']);
    header("Location: index.php?action=admin"); exit;
}
if ($action == 'delete_resource' && isset($_GET['id'])) {
    $resourceController->deleteResource($_GET['id']);
    header("Location: index.php?action=admin"); exit;
}

$viewsPath = __DIR__ . '/../views/';

if ($action == 'admin') {
    $events     = $eventController->getEvents();
    $resources  = $resourceController->getResources();
    $eventStats = $eventController->getStats();
    $resStats   = $resourceController->getStats();
    require_once $viewsPath . 'admin/index.php';
} elseif ($action == 'form_event') {
    $eventData = isset($_GET['id']) ? $eventController->getEvent($_GET['id']) : null;
    require_once $viewsPath . 'admin/form_event.php';
} elseif ($action == 'form_resource') {
    $resourceData = isset($_GET['id']) ? $resourceController->getResource($_GET['id']) : null;
    require_once $viewsPath . 'admin/form_resource.php';
} elseif ($action == 'api_config') {
    $events = $eventController->getEvents();
    require_once $viewsPath . 'admin/api_config.php';
} else {
    $events    = $eventController->getEvents();
    $resources = $resourceController->getResources();
    require_once $viewsPath . 'user/index.php';
}
?>
