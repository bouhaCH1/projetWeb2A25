<?php
require_once __DIR__ . '/../Model/Event.php';
require_once __DIR__ . '/../Model/Resource.php';

class EventController {

    private function requireAdmin(): void {
        if (empty($_SESSION['user_id'])) {
            header('Location: /workwave/Controller/index.php?action=admin_login');
            exit;
        }
        if (($_SESSION['user_role'] ?? '') !== 'admin') {
            header('Location: /workwave/Controller/index.php');
            exit;
        }
    }

    private function requireAdminOrEmployer(): void {
        if (empty($_SESSION['user_id'])) {
            header('Location: /workwave/Controller/index.php?action=login');
            exit;
        }
        $role = $_SESSION['user_role'] ?? '';
        if ($role !== 'admin' && $role !== 'employer') {
            header('Location: /workwave/Controller/index.php');
            exit;
        }
    }

    private function getReturnUrl(): string {
        return (($_SESSION['user_role'] ?? '') === 'admin') 
            ? '/workwave/Controller/index.php?action=admin_events' 
            : '/workwave/Controller/index.php?action=user_events';
    }

    // ─── ADMIN DASHBOARD ───────────────────────────────────────────────────────
    public function adminEvents(): void {
        $this->requireAdmin();

        $eventModel    = new Event();
        $resourceModel = new Resource();

        $events    = $eventModel->read();
        $resources = $resourceModel->read();

        $eventStats = [
            'total'    => $eventModel->countTotal(),
            'upcoming' => $eventModel->countUpcoming(),
            'monthly'  => $eventModel->getMonthlyStats(),
            'location' => $eventModel->getLocationStats()
        ];

        $resStats = [
            'total'     => $resourceModel->sumQuantity(),
            'low_stock' => $resourceModel->countLowStock(),
            'types'     => $resourceModel->getTypeStats(),
            'ranges'    => $resourceModel->getQuantityRange()
        ];

        // Chart explicit variables required by the view JS
        $months      = array_column($eventStats['monthly'],  'month');
        $monthCounts = array_column($eventStats['monthly'],  'count');
        $resTypes    = array_column($resStats['types'],      'type');
        $resTypeCounts = array_column($resStats['types'],    'count');
        $locNames    = array_column($eventStats['location'], 'location');
        $locCounts   = array_column($eventStats['location'], 'count');
        $rangeLabels = array_column($resStats['ranges'],     'range_label');
        $rangeCounts = array_column($resStats['ranges'],     'count');

        // Payments placeholder array
        $payments = [];

        require_once __DIR__ . '/../View/admin/events.php';
    }

    // ─── EVENT CRUD ────────────────────────────────────────────────────────────
    public function formEvent(): void {
        $this->requireAdminOrEmployer();

        $eventData = null;
        $flash     = null;
        $returnUrl = $this->getReturnUrl();

        if (isset($_GET['id'])) {
            $eventModel = new Event();
            $eventData  = $eventModel->readOne((int)$_GET['id']);
            if (!$eventData) {
                header('Location: ' . $returnUrl);
                exit;
            }
        }

        require_once __DIR__ . '/../View/admin/form_event.php';
    }

    public function saveEvent(): void {
        $this->requireAdminOrEmployer();

        $data = [
            'title'       => trim($_POST['title'] ?? ''),
            'date'        => trim($_POST['date'] ?? ''),
            'location'    => trim($_POST['location'] ?? ''),
            'description' => trim($_POST['description'] ?? '')
        ];

        $eventModel = new Event();

        if (!empty($_POST['id'])) {
            $eventModel->update((int)$_POST['id'], $data);
            $msg = 'Événement mis à jour avec succès.';
        } else {
            $eventModel->create($data);
            $msg = 'Événement créé avec succès.';
        }

        $_SESSION['flash'] = ['type' => 'success', 'msg' => $msg];
        header('Location: ' . $this->getReturnUrl());
        exit;
    }

    public function deleteEvent(): void {
        $this->requireAdminOrEmployer();

        if (!empty($_GET['id'])) {
            (new Event())->delete((int)$_GET['id']);
            $_SESSION['flash'] = ['type' => 'warning', 'msg' => 'Événement supprimé.'];
        }

        header('Location: ' . $this->getReturnUrl());
        exit;
    }

    // ─── RESOURCE CRUD ─────────────────────────────────────────────────────────
    public function formResource(): void {
        $this->requireAdminOrEmployer();

        $resourceData = null;
        $flash        = null;
        $returnUrl    = $this->getReturnUrl();

        if (isset($_GET['id'])) {
            $resourceModel = new Resource();
            $resourceData  = $resourceModel->readOne((int)$_GET['id']);
            if (!$resourceData) {
                header('Location: ' . $returnUrl);
                exit;
            }
        }

        require_once __DIR__ . '/../View/admin/form_resource.php';
    }

    public function saveResource(): void {
        $this->requireAdminOrEmployer();

        $data = [
            'name'     => trim($_POST['name'] ?? ''),
            'type'     => trim($_POST['type'] ?? ''),
            'quantity' => (int)($_POST['quantity'] ?? 0)
        ];

        $resourceModel = new Resource();

        if (!empty($_POST['id'])) {
            $resourceModel->update((int)$_POST['id'], $data);
            $msg = 'Ressource mise à jour avec succès.';
        } else {
            $resourceModel->create($data);
            $msg = 'Ressource créée avec succès.';
        }

        $_SESSION['flash'] = ['type' => 'success', 'msg' => $msg];
        header('Location: ' . $this->getReturnUrl());
        exit;
    }

    public function deleteResource(): void {
        $this->requireAdminOrEmployer();

        if (!empty($_GET['id'])) {
            (new Resource())->delete((int)$_GET['id']);
            $_SESSION['flash'] = ['type' => 'warning', 'msg' => 'Ressource supprimée.'];
        }

        header('Location: ' . $this->getReturnUrl());
        exit;
    }

    // ─── USER SIDE ─────────────────────────────────────────────────────────────
    public function showUserEvents(): void {
        if (empty($_SESSION['user_id'])) {
            header('Location: /workwave/Controller/index.php?action=login');
            exit;
        }

        $events    = (new Event())->read();
        $resources = (new Resource())->read();

        require_once __DIR__ . '/../View/user/events.php';
    }

    // ─── PAYMENT SIMULATION ────────────────────────────────────────────────────
    public function savePayment(): void {
        if (empty($_SESSION['user_id'])) {
            exit('error');
        }
        echo 'success';
        exit;
    }
}
?>
