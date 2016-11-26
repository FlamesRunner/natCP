<?php
session_start();
include 'auth.php';
include 'db.php';
include 'header.php';
include 'functions.php';

$ath = $dbh->prepare('SELECT * from virtualservers where owner=:username');
$ath->bindParam(":username", $_SESSION['user_name']);
$ath->execute();

echo '<div class="container">';
echo '<h1>Virtual Servers</h1>';
?>
<table class="table table-hover">
    <thead>
      <tr>
        <th>Container ID</th>
	<th>Status</th>
        <th>Management</th>
      </tr>
    </thead>
<tbody>
<?php
if ($ath->rowCount() > 0) {

echo '<br />';

foreach ($ath as $row){
echo '<tr>';
echo '<td>CT'.$row["ctid"].'</td>';
echo getPowerLevel($row["ctid"]);
echo '<td><a href="manage.php?vserver='.$row["ctid"].'" class="btn btn-primary">Manage</a></td>';
echo '</tr>';
}

} else {
echo '<tr>';
echo '<td>No virtual servers found.</td>';
echo '</tr>';
}
?>
</tbody>
</table>

