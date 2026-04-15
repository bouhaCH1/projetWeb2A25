<?php
require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/missionController.php';

$action = isset($_GET['action']) ? $_GET['action'] : 'home';
$controller = new MissionController();

switch ($action) {
    case 'index':
        $controller->index();
        break;
    case 'create':
        // Backoffice create (same action name as before)
        $controller->create();
        break;
    case 'edit':
        $controller->edit();
        break;
    case 'delete':
        $controller->delete();
        break;
    case 'candidatures':
        $controller->candidatures();
        break;
    case 'update_candidature_statut':
        $controller->updateCandidatureStatut();
        break;
    case 'delete_candidature':
        $controller->deleteCandidature();
        break;
    case 'front_create':
        $controller->frontCreate();
        break;
    case 'front_edit':
        $controller->frontEdit();
        break;
    case 'front_delete':
        $controller->frontDelete();
        break;
    case 'front_apply':
        $controller->frontApply();
        break;
    case 'missions':
    case 'home':
    default:
        $controller->frontIndex();
        break;
}
?>