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
<!--<table class="table table-hover tbl-header">
    <thead>
      <tr>
        <th>Container ID</th>
        <th>Status</th>
        <th>Management</th>
      </tr>
    </thead> -->
<tbody class="tbl-content">
<?php
if ($ath->rowCount() > 0) {

echo '<br />';

foreach ($ath as $row){
echo '<div class="panel panel-default"><div class="panel-body">';
$status = getPowerLevel($row["ctid"]);
echo ''. $status .' (CONTAINER ID: '. $row["ctid"] .')</a>';
echo '<div class="grouped">';
echo '<a href="manage.php?vserver='.$row["ctid"].'" class="btn btn-primary">Manage</a>';
echo '</div></div></div>';
}

} else {
echo '<div class="panel panel-danger"><div class="panel-body">';
echo 'No virtual servers found.';
echo '</div>';
}
?>
<!-- </tbody>
</table> -->
