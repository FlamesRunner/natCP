<?php
session_start();
include 'auth.php';
include 'db.php';
include 'header.php';
include 'functions.php';

$ath = $dbh->prepare('SELECT * from virtualservers where owner=:username and ctid=:ctid');
$ath->bindParam(":username", $_SESSION['user_name']);
$ath->bindParam(":ctid", $_GET['vserver']);
$ath->execute();

if (!$ath->rowCount() > 0) {
header('Location: /manager/listvps.php');
die('Invalid virtual server.');
}

if ($_GET['act'] == "start"){
$poweract = poweron($_GET['vserver']);
} elseif ($_GET['act'] == "stop"){
$poweract = poweroff($_GET['vserver']);
} elseif ($_GET['act'] == "restart") {
$poweract = reboot($_GET['vserver']);
} elseif ($_GET['act'] == "resetpass") {
$newpass = resetpass($_GET['vserver']);
} elseif ($_GET['act'] == "toggletun") {

$status = checktun($_GET['vserver']);
if ($status == "on"){
$dangeract = disabletun($_GET['vserver']);
} else {
$dangeract = enabletun($_GET['vserver']);
}

} elseif ($_GET['act'] == "reinstall" && !empty($_POST['os'])){

$os = $_POST['os'];
if ($os == "debian") {
$dangeract = reinstall($_GET['vserver'], "debian-7");
} elseif ($os == "ubuntu") {
$dangeract = reinstall($_GET['vserver'], "ubuntu-15.04");
} elseif ($os == "centos") {
$dangeract = reinstall($_GET['vserver'], "centos-6");
} else {
$dangeract = 'fail';
}

}

$percentage = memoryusage($_GET['vserver']);
$ostemplate = getos($_GET['vserver']);
$diskpercentage = getDisk($_GET['vserver']);

?>

<script type="text/javascript">
function loading() {
document.getElementById('controlarea').style.display = 'none';
document.getElementById('loadingarea').style.display = 'block';
}
</script>

<div class="container">
<h1><?php getPowerLevel($_GET['vserver']); ?> Container management</h1>

<div class="row">
<div class="col col-md-4">
<h3>Container Information</h3>

<?php
if ($percentage == -100){

} else {
?>
<hr>
<p><b>RAM usage</b></p>
<div class="progress">
    <div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width:<?php echo round($percentage); ?>%">
    <?php echo round($percentage); ?>% used
   </div>
</div>
<p><b>Disk usage</b></p>
<div class="progress">
    <div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width:<?php echo round($diskpercentage); ?>%">
    <?php echo round($diskpercentage); ?>% used
   </div>
</div>
<?php } ?>
<p><b>Network details</b></p>
<pre>Public NATed IPv4 address: <?php echo NODE_IP; ?>&nbsp;
Public IPv6 address: <?php echo NODE_IPV6 . $_GET['vserver']; ?>&nbsp;
Your IPv4 NAT port: <?php echo NAT_PREFIX . $_GET['vserver']; ?> &nbsp;
Your private IP address: <?php echo PRIV_IP_BLOCK . $_GET['vserver']; ?></pre>
<br />
<p><b>Operating system template:</b> <?php echo $ostemplate; ?></p>
</div>
<div class="col col-md-2">
<!-- just blank space... oh yeah - congratulations for being so attentive -->
<!-- now that you mention it, because you got so far, why not contribute? https://github.com/FlamesRunner/natCP -->
</div>
<div class="col col-md-6">
<h3>Settings</h3>
<hr>
<div id="loadingarea" style="display: none;">
<center>
<br />
<img class="img-responsive" src="/assets/loading.gif" alt="Loading...">
<p>Processing...</p>
</center>
</div>
<div id="controlarea">
<?php if (!empty($poweract) || !empty($newpass) || !empty($dangeract)) { ?>
<br />
<div class="alert alert-success">The action was performed successfully!</div>
<br />
<?php } ?>
<p><b>Power cycle</b></p>
<div class="btn-group">
<a href="manage.php?vserver=<?php echo $_GET['vserver']; ?>&act=start" onclick="loading();" class="btn btn-success">Start</a>
<a href="manage.php?vserver=<?php echo $_GET['vserver']; ?>&act=stop" onclick="loading();" class="btn btn-danger">Stop</a>
<a href="manage.php?vserver=<?php echo $_GET['vserver']; ?>&act=restart" onclick="loading();" class="btn btn-warning">Restart</a>
</div>

<br /><br />

<p><b>Danger zone</b></p>
<form action="manage.php?vserver=<?php echo $_GET['vserver']; ?>&act=reinstall" method="POST" onsubmit="loading();">

<input type="radio" name="os" value="debian" class=""> Debian 7 x86<br>
<input type="radio" name="os" value="ubuntu" class=""> Ubuntu 15 x86_64<br>
<input type="radio" name="os" value="centos" class=""> CentOS 6 x86_64<br>
<br />
<input type="submit" class="btn btn-danger" value="Re-image server">
</form>
<br />
<?php if (!empty($newpass)){ ?>
<div class="input-group">
<span class="input-group-addon">New root password:</span>
<input class="form-control" value="<?php echo $newpass; ?>" type="text" readonly>
</div>
<?php } else { ?>
<a href="manage.php?vserver=<?php echo $_GET['vserver']; ?>&act=resetpass" class="btn btn-primary" onclick="loading();">Reset root password</a>
<?php } ?>
<br /><br />
<div class="btn-group">
<?php
if (checktun($_GET['vserver']) == "on") {
?>
<a href="#" class="btn btn-success" disabled="disabled">TUN enabled</a>
<a href="manage.php?vserver=<?php echo $_GET['vserver']; ?>&act=toggletun" class="btn btn-danger" onclick="loading();">Disable TUN/TAP</a>
<?php
} else {
?>
<a href="#" class="btn btn-danger" disabled="disabled">TUN disabled</a>
<a href="manage.php?vserver=<?php echo $_GET['vserver']; ?>&act=toggletun" class="btn btn-success" onclick="loading();">Enable TUN/TAP</a>
<?php
}
?>
</div>
</div>
</div>
</div>

<br />
