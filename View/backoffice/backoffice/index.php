<?php
require_once '../controllers/missionController.php';

$controller = new MissionController();
$action = isset($_GET['action']) ? $_GET['action'] : 'index';

switch ($action) {
    case 'create': $controller->create(); break;
    case 'edit':   $controller->edit();   break;
    case 'delete': $controller->delete(); break;
    default:       $controller->index();  break;
}
?>