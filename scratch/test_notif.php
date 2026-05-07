<?php
require_once 'models/Database.php';
require_once 'models/Notification.php';
$db = (new Database())->getConnection();
$notif = new Notification($db);
$res = $notif->save('test@from.com', 'test@to.com', 'Test Subject', 'Test Message');
echo $res ? "Save Success" : "Save Failed";
?>
