<?php
session_start();
include 'auth.php';
include 'db.php';
include 'header.php';
include 'functions.php';

if (!empty($_POST['username']) && !empty($_POST['email']) && !empty($_POST['password'])){

$err = 0;

if (strlen($_POST['username']) > 64){
$err = 1;
$msg = "Username too long (greater than 64 characters).";
}

if (strlen($_POST['password']) <= 6){
$err = 1;
$msg = "Password too short (shorter than 6 characters).";
}

if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
$err = 1;
$msg = "Email invalid.";
}

$check = $dbh->prepare('SELECT * from users where user_name=:user');
$check->bindParam(':user', $_POST['username']);
$check->execute();

if ($check->rowCount() > 0){
$err = 1;
$msg = "Username taken.";
}

$checke = $dbh->prepare('SELECT * from users where user_email=:email');
$checke->bindParam(':email', $_POST['email']);
$checke->execute();

if ($checke->rowCount() > 0){
$err = 1;
$msg = "Email taken.";
}

if ($err == 0){
$sql = 'INSERT INTO users (user_name, user_password_hash, user_email) VALUES (:username, :password, :email)';
$adduser = $dbh->prepare($sql);
$adduser->bindParam(':username', $_POST['username']);
$adduser->bindParam(':password', password_hash($_POST['password'], PASSWORD_DEFAULT));
$adduser->bindParam(':email', $_POST['email']);
$adduser->execute();
$smsg = "User added!";

}

}

?>

<div class="container">
<h1>Add user</h1>
<hr>
<div class="row">
<div class="col col-md-4">
<h3>User details</h3>
<hr>
<?php
if (!empty($msg)){
echo '&nbsp;<div class="alert alert-danger"><b>Error:</b> '.$msg.'</div>&nbsp;';
} 
if (!empty($smsg)){
echo '&nbsp;<div class="alert alert-success"><b>Success:</b> '.$smsg.'</div>&nbsp;';
}
?>
<form action="adduser.php" method="POST" id="addform">
<label>Username</label>
<input name="username" class="form-control" placeholder="Username" type="text" required>
<br />
<label>Email</label>
<input name="email" class="form-control" placeholder="Email address" type="email" required>
<br />
<label>Password</label>
<input name="password" class="form-control" placeholder="Password" type="password" required>
<br />
<input type="submit" class="btn btn-success btn-block" value="Create user">
</form>
</div>
<div class="col col-md-1">
<!-- blank space again, sigh -->
</div>
<div class="col col-md-4">
<h3>Help</h3>
<hr>
<p>This utility allows you to add additional users as needed.</p>
<p>There is a maximum limit of 64 alphanumeric characters for the username.</p>
<p>Also, valid notification email is required and a minimum length of 6 characters is required for the password.</p>
</div>
</div>

