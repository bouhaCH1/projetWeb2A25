<?php
// controllers/index.php
require_once __DIR__ . '/../models/Database.php';
require_once __DIR__ . '/../models/Event.php';
require_once __DIR__ . '/../models/Resource.php';
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
    require_once $viewsPath . 'admin/api_config.php';
} else {
    $events    = $eventController->getEvents();
    $resources = $resourceController->getResources();
    require_once $viewsPath . 'user/index.php';
}
?>
