<?php
/**
 * FRONT CONTROLLER - MVC ROUTER
 * This is the single entry point for the application.
 */

// 1. Enable error reporting for development
error_reporting(E_ALL);
ini_set('display_errors', 1);

// 2. Start session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// 3. Load Core Configurations & Controllers
require_once __DIR__ . '/Model/Database.php';
require_once __DIR__ . '/Controller/missionController.php';

// 4. Initialize the main Controller
$controller = new MissionController();

// 5. Routing Logic
$action = isset($_GET['action']) ? $_GET['action'] : 'home';

switch ($action) {
    // --- BACKOFFICE ACTIONS ---
    case 'index': $controller->index(); break;
    case 'create': $controller->create(); break;
    case 'edit': $controller->edit(); break;
    case 'delete': $controller->delete(); break;
    case 'candidatures': $controller->candidatures(); break;
    case 'update_candidature_statut': $controller->updateCandidatureStatut(); break;
    case 'delete_candidature': $controller->deleteCandidature(); break;
    case 'ai_classify': $controller->aiClassify(); break;

    // --- FRONTOFFICE ACTIONS ---
    case 'missions':
    case 'home': $controller->frontIndex(); break;
    case 'front_create': $controller->frontCreate(); break;
    case 'front_missions': $controller->frontMissions(); break;
    case 'front_edit': $controller->frontEdit(); break;
    case 'front_delete': $controller->frontDelete(); break;
    case 'front_apply': $controller->frontApply(); break;
    case 'front_candidatures': $controller->frontCandidatures(); break;
    case 'front_edit_candidature': $controller->frontEditCandidature(); break;
    case 'front_delete_candidature': $controller->frontDeleteCandidature(); break;

    default: $controller->frontIndex(); break;
}
?>