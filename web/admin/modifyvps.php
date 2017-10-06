<?php
session_start();
include 'auth.php';
include 'db.php';
include 'header.php';
include 'functions.php';

$nodeid = $_GET['vserver'];
$equery = 'SELECT * from virtualservers where ctid = :ctid';
$e = $dbh->prepare($equery);
$e->bindParam(':ctid', $nodeid);
$e->execute();
if ($e->rowCount() == 0) {
header("Location: " . dirname(1));
}

$ctInfo = $e->fetch();

$nodeid = $ctInfo["nodeid"];
$ctOwner = $ctInfo["owner"];
$ctIPv4 = $ctInfo["v4addresses"];

//function updateResources($ctid, $nodeid, $ram, $cpu, $cpu_units, $disk, $swap)

if ($_POST['act'] == "modifyvps") {

if (empty($_POST['ram'])) {
	$ram = NULL;
} else {
	$ram = $_POST['ram'];
}

if (empty($_POST['swap'])) {
        $swap = NULL;
} else {
        $swap = $_POST['swap'];
}

if (empty($_POST['cpu'])) {
        $cpu = NULL;
} else {
        $cpu = $_POST['cpu'];
}

if (empty($_POST['cpu_units'])) {
        $cpu_units = NULL;
} else {
        $cpu_units = $_POST['cpu_units'];
}

if (empty($_POST['disk'])) {
        $disk = NULL;
} else {
        $disk = $_POST['disk'];
}

$ret = updateResources(trim($_GET['vserver']), $nodeid, $ram, $cpu, $cpu_units, $disk, $swap);
$msg = "Resource values updated successfully for container " . trim($_GET['vserver']) . ".";

}


?>

<script type="text/javascript">
function loading() {
document.getElementById('controlarea').style.display = 'none';
document.getElementById('loadingarea').style.display = 'block';
}
</script>

<div class="container">
<h1>Modify virtual server <span style='font-size: 12px;'><a href="manage.php?vserver=<?php echo $_GET['vserver']; ?>">Back</a></span></h1>
<hr>
<div class="row">
<div class="col col-md-4">
<h3>Container Settings</h3>
<hr>
<div id="loadingarea" style="display: none;">
<center>
<br />
<img class="img-responsive" src="/assets/loading.gif" alt="Loading...">
<p>Processing...</p>
</center>
</div>
<div id="controlarea">
<?php if (isset($msg)) echo '<div class="alert alert-success">'.$msg.'</div><br />'; ?>
<form action="modifyvps.php?vserver=<?php echo $_GET['vserver']; ?>" method="POST" id="modifyform" onsubmit="loading();">
<input type="hidden" name="act" value="modifyvps">
<label>Container ID</label>
<input name="ctid" class="form-control" placeholder="Container ID" type="number" value="<?php echo $_GET['vserver']; ?>" disabled>
<br />
<label>Container owner</label>
<input type="text" name="owner" class="form-control" placeholder="Container owner" value="<?php echo $ctOwner; ?>" disabled>
<br />
<label>IPv4 address</label>
<input type="text" name="ipv4" class="form-control" placeholder="IP address..." value="<?php echo $ctIPv4; ?>" disabled>
<br />
<label>New RAM allocation (in MB)</label>
<input type="number" name="ram" class="form-control" placeholder="RAM in megabytes...">
<br />
<label>New vSwap allocation (in MB)</label>
<input type="number" name="swap" class="form-control" placeholder="vSwap in megabytes...">
<br />
<label>New CPU Core Allocation</label>
<input type="number" name="cpu" class="form-control" placeholder="CPU Cores...">
<br />
<label>New CPU Unit Allocation</label>
<input type="number" name="cpu_units" class="form-control" placeholder="CPU Units...">
<br />
<label>New disk space (in GB) allocation</label>
<input type="text" name="disk" class="form-control" placeholder="Disk space in GB...">
<br />
<input type="submit" class="btn btn-success btn-block" value="Modify container">
</form>
</div>
</div>
<div class="col col-md-1">
<!-- blank space again, sigh -->
</div>
<div class="col col-md-4">
<h3>Help</h3>
<hr>
<p>This utility allows you to modify a virtual server's settings.</p>
<p>Fill in any fields that should be changed. Any blank fields will be ignored.</p>
</div>
</div>

