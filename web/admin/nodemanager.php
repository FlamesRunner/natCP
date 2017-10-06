<?php
session_start();
include 'auth.php';
include 'db.php';
include 'header.php';
include 'functions.php';

$userlist = $dbh->prepare('SELECT * from nodes');
$userlist->execute();

echo '<div class="container">';
echo '<h1>Node Manager <a href="addnode.php" class="btn btn-success">Add new node</a></h1>';
?>
<table class="table table-hover">
    <thead>
      <tr>
        <th>Server ID</th>
        <th>Hostname</th>
	<th>Access Key</th>
        <th>Management</th>
      </tr>
    </thead>
<tbody>
<?php
if ($userlist->rowCount() > 0) {

echo '<br />';

foreach ($userlist as $row){
echo '<tr>';
echo '<td>'.$row["id"].'</td>';
echo '<td>'.$row["hostname"].'</td>';
echo '<td>'.$row["accesskey"].'</td>';
echo '<td><a href="editnode.php?id='.$row["id"].'" class="btn btn-primary">Edit</a></td>';
echo '</tr>';
}

} else {
echo '<tr>';
echo '<td>No nodes can be managed.</td>';
echo '</tr>';
}
?>
</tbody>
</table>

