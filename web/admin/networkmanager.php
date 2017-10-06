<?php
session_start();
include 'auth.php';
include 'db.php';
include 'header.php';
include 'functions.php';

$userlist = $dbh->prepare('SELECT * from users');
$userlist->execute();

echo '<div class="container">';
echo '<h1>User Manager <a href="adduser.php" class="btn btn-success">Add user</a></h1>';
?>
<table class="table table-hover">
    <thead>
      <tr>
        <th>User ID</th>
        <th>Email</th>
	<th>Username</th>
        <th>Management</th>
      </tr>
    </thead>
<tbody>
<?php
if ($userlist->rowCount() > 0) {

echo '<br />';

foreach ($userlist as $row){
echo '<tr>';
echo '<td>'.$row["user_id"].'</td>';
echo '<td>'.$row["user_email"].'</td>';
echo '<td>'.htmlspecialchars($row["user_name"]).'</td>';
if ($row["permission_level"] == "admin"){
echo '<td><a href="#" class="btn btn-primary" disabled>Edit</a></td>';
} else {
echo '<td><a href="edituser.php?id='.$row["user_id"].'" class="btn btn-primary">Edit</a></td>';
}
echo '</tr>';
}

} else {
echo '<tr>';
echo '<td>No users can be managed.</td>';
echo '</tr>';
}
?>
</tbody>
</table>

