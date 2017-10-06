<?php
session_start();
include 'auth.php';
include 'db.php';
include 'header.php';
include 'functions.php';

$gu = $dbh->prepare('SELECT * from users where user_id=:rid');
$gu->bindParam(":rid", $_GET['id']);
$gu->execute();
$rowdata = $gu->fetch();

$user = $rowdata["user_name"];

if ($_GET['id'] == 1){
header('Location: /vpscp/admin/usermanager.php');
die('Invalid user.');
}

if (!$gu->rowCount() > 0) {
header('Location: /vpscp/admin/usermanager.php');
die('Invalid user.');
}

if ($_GET['act'] == "delete"){

$err = 0;

$checkvps = $dbh->prepare('SELECT * from virtualservers where owner=:owner');
$checkvps->bindParam(':owner', $user);
$checkvps->execute();

if ($checkvps->rowCount() > 0){
$err = 1;
$msg = "This user currently owns ".$checkvps->rowCount()." virtual server(s). To remove this user, please remove their virtual servers then try again.";
}

if ($_GET['id'] == 1){
$err = 1;
$msg = "This user cannot be removed.";
}

if ($err == 0){
$delete = $dbh->prepare('DELETE FROM users where user_id=:userid');
$delete->bindParam(':userid', $_GET['id']);
$delete->execute();
header('Location: /vpscp/admin/usermanager.php');
die();
}
}
?>

<div class="container">
<h1>Editing <?php echo htmlspecialchars($rowdata["user_name"]); ?></h1>
<hr>
<div class="row">
<div class="col col-md-4">
<?php
if (!empty($_POST['new_password']) && !empty($_POST['confirm_password'])){

if ($_POST['new_password'] !== $_POST['confirm_password']){
$pass_error = "The passwords you entered did not match. Please try again.";
} else {

$newpassword = $_POST['new_password'];
$hashedpassword = password_hash($newpassword, PASSWORD_DEFAULT);
$user = $_GET['id'];
try {
$sq = $dbh->prepare('UPDATE users SET user_password_hash=:npass where user_id=:nuser');
$sq->bindParam(':npass', $hashedpassword);
$sq->bindParam(':nuser', $user);
$sq->execute();
$chpwd = 'yes';
} catch (PDOException $e) {
$pass_error = 'PDO error: '.$e->getMessage();
}
}

}
?>

<h3>Modify password</h3>
<div class="well well-lg">
<?php
if (!empty($pass_error)){
echo '<div class="alert alert-danger">'.$pass_error.'</div>';
}
if ($chpwd == "yes"){
echo '<div class="alert alert-success">Your password has been updated.</div>';
}
?>
<label>Input your new password</label>
<form action="edituser.php?id=<?php echo $_GET['id']; ?>" method="POST">
<input class="form-control" name="new_password" type="password" placeholder="Your new password">
<br />
<label>Re-type your new password</label>
<input class="form-control" name="confirm_password" type="password" placeholder="Confirm your new password">
<br />
<input type="submit" class="btn btn-success btn-block" value="Change password">
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
<a href="edituser.php?id=<?php echo $_GET['id']; ?>&act=delete" class="btn btn-danger btn-block">Remove user</a>
</div>
</div>
</div>

