<?php
session_start();
include 'auth.php';
include 'db.php';
include 'header.php';
include 'functions.php';

$templates = getTemplates();
$tl = explode("\n", $templates);

$err = 0;

if (!empty($_POST['template']) && !empty($_POST['ctid']) && !empty($_POST['owner'])){

if (!in_array($_POST['template'], $tl)){
$err = 1;
$msg = "Template does not exist.";
}

$checkowner = $dbh->prepare('SELECT * from users where user_name=:username');
$checkowner->bindParam(':username', $_POST['owner']);
$checkowner->execute();
if ($checkowner->rowCount() < 1){
$err = 1;
$msg = "Owner does not exist.";
}

$precheck = checkCTID($_POST['ctid']);
if ($precheck == "Online." || $precheck == "Offline.") {
$err = 1;
$msg = "CTID already used.";
}

if ($err == 0){

$output = createContainer($_POST['ctid'], $_POST['template']);
$sql = 'INSERT INTO virtualservers (ctid, owner, status) VALUES (:ctid, :owner, "active")';
$addcontainer = $dbh->prepare($sql);
$addcontainer->bindParam(':ctid', $_POST['ctid']);
$addcontainer->bindParam(':owner', $_POST['owner']);
$addcontainer->execute();
$smsg = 'Container created!';

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
<form action="addvps.php" method="POST" id="addform" onsubmit="loading();">
<label>Container ID</label>
<input name="ctid" class="form-control" placeholder="Container ID" type="number">
<br />
<label>Operating system template</label>
<select name="template" class="form-control" form="addform">
<?php
foreach ($tl as $row) {
echo '<option value="'.$row.'">'.$row.'</option>';
}
?>
</select>
<br />
<label>Container owner</label>
<input type="text" name="owner" class="form-control" placeholder="Container owner">
<br />
<input type="submit" class="btn btn-success btn-block" value="Create container">
</form>
</div>
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

