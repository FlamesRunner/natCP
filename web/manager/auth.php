<?php
session_start();

if (empty($_SESSION['user_name'])){
header('Location: ../?logout');
die();
}

?>


