<?php
require_once 'config/database.php';
require_once 'models/mission.php';
require_once 'controllers/missionController.php';

$action = isset($_GET['action']) ? $_GET['action'] : 'home';
$controller = new MissionController();

switch ($action) {
    case 'create':
        $controller->frontCreate();
        break;
    case 'edit':
        $controller->frontEdit();
        break;
    case 'delete':
        $controller->frontDelete();
        break;
    case 'missions':
    case 'home':
    default:
        $controller->frontIndex();
        break;
}
?>