<?php
session_start();
include 'auth.php';
include 'db.php';
include 'header.php';
include 'functions.php';

if (!empty($_POST['hostname']) && !empty($_POST['accesskey'])){

$err = 0;

$checke = $dbh->prepare('SELECT * from nodes where hostname=:hostname');
$checke->bindParam(':hostname', $_POST['hostname']);
$checke->execute();

if ($checke->rowCount() > 0){
$err = 1;
$msg = "Hostname taken.";
}

if (!checkNodeStatus($_POST['accesskey'], $_POST['hostname'])) {
$err = 1;
$msg = "Node cannot be added, because either the access key is invalid and/or the node does not have natCP installed.";
}

if ($err == 0){
$sql = 'INSERT INTO nodes (accesskey, hostname) VALUES (:accesskey, :hostname)';
$adduser = $dbh->prepare($sql);
$adduser->bindParam(':accesskey', $_POST['accesskey']);
$adduser->bindParam(':hostname', $_POST['hostname']);
$adduser->execute();
$smsg = "Node added!";

}

}

?>

<div class="container">
<h1>Add node</h1>
<hr>
<div class="row">
<div class="col col-md-4">
<h3>Node details</h3>
<hr>
<?php
if (!empty($msg)){
echo '&nbsp;<div class="alert alert-danger"><b>Error:</b> '.$msg.'</div>&nbsp;';
} 
if (!empty($smsg)){
echo '&nbsp;<div class="alert alert-success"><b>Success:</b> '.$smsg.'</div>&nbsp;';
}
?>
<form action="addnode.php" method="POST" id="addform">
<label>Hostname</label>
<input name="hostname" class="form-control" placeholder="Hostname" type="text" required>
<br />
<label>Access key</label>
<input name="accesskey" class="form-control" placeholder="Access key" type="text" required>
<br />
<input type="submit" class="btn btn-success btn-block" value="Add node">
</form>
</div>
<div class="col col-md-1">
<!-- blank space again, sigh -->
</div>
<div class="col col-md-4">
<h3>Help</h3>
<hr>
<p>This utility allows you to add additional nodes as required.</p>
<p>There is a maximum limit of 128 alphanumeric characters for the access key.</p>
<p>Also, the hostname should point to the target node IP.</p>
</div>
</div>

