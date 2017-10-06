<?php
include 'functions.php';
include 'db.php';
//$arr = getNodeData('4');
//var_dump($arr);
//echo $arr["hostname"];


$getvpsnode = $dbh->prepare('SELECT * from virtualservers where ctid=:vserverid');
$getvpsnode->bindParam(':vserverid', $_GET['vserver']);
$getvpsnode->execute();
$nodeinformation = $getvpsnode->fetch();
$nodeid = $nodeinformation['nodeid'];

echo $nodeid;
?>
