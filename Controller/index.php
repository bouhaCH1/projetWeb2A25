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
    case 'front_apply':
        $controller->frontApply();
        break;
    case 'front_edit':
        $controller->frontEdit();
        break;
    case 'front_edit_candidature':
        $controller->frontEditCandidature();
        break;
    case 'front_missions':
        $controller->frontMissions();
        break;
    case 'front_candidatures':
        $controller->frontCandidatures();
        break;
    case 'missions':
    case 'home':
    default:
        $controller->frontIndex();
        break;
}
