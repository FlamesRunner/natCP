<?php
session_start();
include 'db.php';
include 'auth.php';
include 'header.php';

?>

<div class="container">
   <h1>My account</h1>
   <div class="panel panel-default">
      <div class="panel-body">
<?php
if($_POST['submitted'] == 1) {
if(empty($_POST['new_password']) or empty($_POST['confirm_password'])) {
$emptyfields = 1;
}
}
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
<?php
if (!empty($pass_error)){
echo '<div class="alert alert-danger" style="margin-bottom: 15px;">'.$pass_error.'</div>';
}
if ($emptyfields==1) {
echo '<div class="alert alert-danger" style="margin-bottom: 15px;">One or more fields were empty.</div>';
}
if ($chpwd == "yes"){
echo '<div class="alert alert-success" style="margin-bottom: 15px;">Your password has been updated.</div>';
}
?>
         <small>NEW PASSWORD</small>
         <form action="myaccount.php" method="POST">
            <input type="hidden" name="submitted" value="1">
            <input class="form-control" name="new_password" type="password" placeholder="Your new password">
            <div style="padding-top: 15px;"></div>
            <small>CONFIRM NEW PASSWORD</small>
            <input class="form-control" name="confirm_password" type="password" placeholder="Confirm your new password">
            <div style="padding-top: 15px;"></div>
            <input type="submit" class="btn btn-success btn-block" value="Change password">
         </form>
      </div>
   </div>
</div>
