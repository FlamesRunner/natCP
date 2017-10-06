<?php
session_start();
include 'auth.php';
include 'db.php';
include 'header.php';
include 'functions.php';

$pl = $dbh->prepare("SELECT * from users where user_name=:user and permission_level='admin'");
$pl->bindParam(':user', $_SESSION['user_name']);
$pl->execute();
if ($pl->rowCount() > 0) {
$administrator = 'true';
}
?>

<div class="container">

<h1>Virtual Server Manager</h1>
<hr>
<?php
if (!empty($administrator)){
echo '<div class="alert alert-info"><b>Notice:</b> You are logged in as an administrator. Click <a href="/admin">here</a> to visit the administration panel.</div>';
}
?>
<p>Welcome to natCP. Click the 'Virtual Servers' tab to manage your virtual servers.</p>

</div>
</body>
