<?php
session_start();
include 'auth.php';
include 'db.php';
include 'header.php';
include 'functions.php';

if (empty($_GET['node'])){
$sqlstatement = 'SELECT * FROM nodes';
$result = $dbh->query($sqlstatement);
} else {
$nodeid = $_GET['node'];
$templates = getTemplates(trim($_GET['node']));
//$tl = explode("\n", $templates);

$err = 0;

if (!empty($_POST['template']) && !empty($_POST['ctid']) && !empty($_POST['owner']) && !empty($_POST['ipv4']) && !empty($_POST['ram']) && !empty($_POST['cpu']) && !empty($_POST['cpu_units']) && !empty($_POST['disk']) && !empty($_POST['swap'])){

if (!in_array($_POST['template'], $templates)){
$err = 1;
$msg = "Template does not exist.";
}

$checkowner = $dbh->prepare('SELECT * from users where user_name=:username');
$checkowner->bindParam(':username', $_POST['owner']);
$checkowner->execute();

$checkip = $dbh->prepare('SELECT * from virtualservers where v4address=:ipv4');
$checkip->bindParam(':ipv4', $_POST['ipv4']);
$checkip->execute();

if ($checkowner->rowCount() < 1){
$err = 1;
$msg = "Owner does not exist.";
}

if ($checkip->rowCount > 0) {
$err = 1;
$msg = "The IP is already in use by another container.";
}

/*
if (checkIP($_POST['ipv4'], $nodeid) == "false"){
$err = 1;
$msg = "This IP cannot be used, as it is an invalid block.";
}
*/

$precheck = status($_POST['ctid'], $nodeid);
if ($precheck == "Online." || $precheck == "Offline.") {
$err = 1;
$msg = "CTID already used.";
}

/*
if (!is_int($_POST['ctid'])){
$err = 1;
$msg = "CTID must be an integer.";
}
*/


if ($err == 0){

$output = createContainer($_POST['ctid'], $_POST['template'], $_POST['ipv4'], trim($_GET['node']));
$outputForsetResources = setResources($_POST['ctid'], trim($_GET['node']), $_POST['ram'], $_POST['cpu'], $_POST['cpu_units'], $_POST['disk'], $_POST['swap']);
$sql = 'INSERT INTO virtualservers (ctid, owner, status, nodeid, v4addresses) VALUES (:ctid, :owner, "active", :nodeid, :v4address)';
$addcontainer = $dbh->prepare($sql);
$addcontainer->bindParam(':ctid', $_POST['ctid']);
$addcontainer->bindParam(':owner', $_POST['owner']);
$addcontainer->bindParam(':nodeid', $_GET['node']);
$addcontainer->bindParam(':v4address', $_POST['ipv4']);
$addcontainer->execute();
$smsg = 'Container created!';

}
}
}
?>

<script type="text/javascript">
function loading() {
document.getElementById('controlarea').style.display = 'none';
document.getElementById('loadingarea').style.display = 'block';
}
</script>

<div class="container">
<h1>Add virtual server</h1>
<hr>
<div class="row">
<div class="col col-md-4">
<?php if (empty($_GET['node'])) { ?>
<form action="addvps.php" method="GET" id="nodeform">
<label>Please select a node</label>
<select name="node" class="form-control" form="nodeform">
<?php

   foreach($result as $row) {
	echo '<option value="'.$row["id"].'">'.$row["hostname"].'</option>';
    }

?>
</select>
<br />
<input type="submit" class="btn btn-success btn-block" value="Use this node">
</form>
<?php } else { ?>
<h3>Container details</h3>
<hr>
<div id="loadingarea" style="display: none;">
<center>
<br />
<img class="img-responsive" src="/assets/loading.gif" alt="Loading...">
<p>Processing...</p>
</center>
</div>
<div id="controlarea">
<?php
if (!empty($msg)){
echo '&nbsp;<div class="alert alert-danger"><b>Error: </b>'.$msg.'</div>&nbsp;';
}

if (!empty($smsg)){
echo '&nbsp;<div class="alert alert-success"><b>Success:</b> '.$smsg.'</div>&nbsp;';
}
?>
<form action="addvps.php?node=<?php echo $_GET['node']; ?>" method="POST" id="addform" onsubmit="loading();">
<label>Container ID</label>
<input name="ctid" class="form-control" placeholder="Container ID" type="number">
<br />
<label>Operating system template</label>
<select name="template" class="form-control" form="addform">
<?php
foreach ($templates as $row) {
echo '<option value="'.$row.'">'.$row.'</option>';
}
?>
</select>
<br />
<label>Container owner</label>
<input type="text" name="owner" class="form-control" placeholder="Container owner" required>
<br />
<label>IPv4 address</label>
<input type="text" name="ipv4" class="form-control" placeholder="IP address..." required>
<br />
<label>RAM (in MB)</label>
<input type="number" name="ram" class="form-control" placeholder="RAM in megabytes..." required>
<br />
<label>vSwap (in MB)</label>
<input type="number" name="swap" class="form-control" placeholder="vSwap in megabytes..." required>
<br />
<label>CPU Cores</label>
<input type="number" name="cpu" class="form-control" placeholder="CPU Cores..." required>
<br />
<label>CPU Units</label>
<input type="number" name="cpu_units" class="form-control" placeholder="CPU Units..." required>
<br />
<label>Disk space (in GB)</label>
<input type="text" name="disk" class="form-control" placeholder="Disk space in GB..." required>
<br />
<input type="submit" class="btn btn-success btn-block" value="Create container">
</form>
</div>
<?php } ?>
</div>
<div class="col col-md-1">
<!-- blank space again, sigh -->
</div>
<div class="col col-md-4">
<h3>Help</h3>
<hr>
<p>This utility allows you to create a virtual server and assign it to a user.</p>
<p>Please note that you must enter a unique container ID, and a valid container owner.</p>
<p>Operating system templates are automatically fetched from the slave node.</p>
</div>
</div>

