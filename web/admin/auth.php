<?php
session_start();
include 'db.php';

if (empty($_SESSION['user_name'])){
header('Location: ../?logout');
die();
}

$checkrank = $dbh->prepare('SELECT permission_level from users where user_name=:userdata and permission_level="admin"');
$checkrank->bindParam(':userdata', $_SESSION['user_name']);
$checkrank->execute();

if (!$checkrank->rowCount() > 0){
header('Location: ../?logout');
}
?>


