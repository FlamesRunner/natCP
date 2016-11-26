<?php
session_start();
include 'auth.php';
include 'db.php';
include 'header.php';

?>

<div class="container">
<h1>My account</h1>
<hr>
<p>This is where you can change your password and various other settings.</p>
<br />
<div class="row">
<div class="col col-md-4">
<h3>Change password</h3>
<?php
if (!empty($_POST['new_password']) && !empty($_POST['confirm_password'])){

if ($_POST['new_password'] !== $_POST['confirm_password']){
$pass_error = "The passwords you entered did not match. Please try again.";
} else {

$newpassword = $_POST['new_password'];
$hashedpassword = password_hash($newpassword, PASSWORD_DEFAULT);
$user = $_SESSION['user_name'];
try {
$sq = $dbh->prepare('UPDATE users SET user_password_hash=:npass where user_name=:nuser');
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
<hr>
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
<form action="myaccount.php" method="POST">
<input class="form-control" name="new_password" type="password" placeholder="Your new password">
<br />
<label>Re-type your new password</label>
<input class="form-control" name="confirm_password" type="password" placeholder="Confirm your new password">
<br />
<input type="submit" class="btn btn-success btn-block" value="Change password">
</form>
</div>
</div>
