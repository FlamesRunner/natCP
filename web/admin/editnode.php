<?php
session_start();
include 'auth.php';
include 'db.php';
include 'functions.php';

$gu = $dbh->prepare('SELECT * from nodes where id=:rid');
$gu->bindParam(":rid", $_GET['id']);
$gu->execute();
$rowdata = $gu->fetch();

$hostname = $rowdata["hostname"];

if (!$gu->rowCount() > 0) {
header('Location: '.dirname(1).'/nodemanager.php');
die('Invalid node ID.');
}

if ($_GET['act'] == "delete"){

$err = 0;

$checkvps = $dbh->prepare('SELECT * from virtualservers where nodeid=:mid');
$checkvps->bindParam(':mid', $_GET['id']);
$checkvps->execute();

if ($checkvps->rowCount() > 0){
$err = 1;
$msg = "This node currently hosts ".$checkvps->rowCount()." virtual server(s). To remove this node, please remove the node's virtual servers then try again.";
}

if ($err == 0){
$delete = $dbh->prepare('DELETE FROM nodes where id=:nodeid');
$delete->bindParam(':nodeid', $_GET['id']);
$delete->execute();
header('Location: '.dirname(1).'/nodemanager.php');
die();
}
}

include 'header.php';
?>

<div class="container">
<h1>Editing <?php echo $rowdata["hostname"]; ?></h1>
<hr>
<div class="row">
<div class="col col-md-4">
<?php
if (!empty($_POST['new_password']) && !empty($_POST['confirm_password'])){

if ($_POST['new_password'] !== $_POST['confirm_password']){
$pass_error = "The access keys you entered did not match. Please try again.";
} else {

$newpassword = $_POST['new_password'];
$user = $_GET['id'];
try {
$sq = $dbh->prepare('UPDATE nodes SET accesskey=:accesskey where id=:nodeid');
$sq->bindParam(':accesskey', $_POST['new_password']);
$sq->bindParam(':nodeid', $_GET['id']);
$sq->execute();
$chpwd = 'yes';
} catch (PDOException $e) {
$pass_error = 'PDO error: '.$e->getMessage();
}
}

}
?>

<h3>Modify access key</h3>
<div class="well well-lg">
<?php
if (!empty($pass_error)){
echo '<div class="alert alert-danger">'.$pass_error.'</div>';
}
if ($chpwd == "yes"){
echo '<div class="alert alert-success">Access key has been updated.</div>';
}
?>
<label>Input your new access key</label>
<form action="editnode.php?id=<?php echo $_GET['id']; ?>" method="POST">
<input class="form-control" name="new_password" type="password" placeholder="New access key">
<br />
<label>Re-type your new access key</label>
<input class="form-control" name="confirm_password" type="password" placeholder="Confirm your new access key">
<br />
<input type="submit" class="btn btn-success btn-block" value="Update">
</form>
</div>
</div>
<div class="col col-md-1">
<!-- blank space -->
</div>
<div class="col col-md-4">
<h3>Danger zone</h3>
<div class="well well-lg">
<?php
if (!empty($msg)){
echo '<div class="alert alert-danger"><b>Error:</b> '.$msg.'</div>';
}
?>
<a href="editnode.php?id=<?php echo $_GET['id']; ?>&act=delete" class="btn btn-danger btn-block">Remove node</a>
</div>
</div>
</div>

