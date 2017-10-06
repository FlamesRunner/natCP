<?php
session_start();
include 'auth.php';
include 'db.php';
include 'functions.php';

$getvpsnode = $dbh->prepare('SELECT * from virtualservers where ctid=:vserverid');
$getvpsnode->bindParam(':vserverid', $_GET['vserver']);
$getvpsnode->execute();
$nodeinformation = $getvpsnode->fetch();
$nodeid = $nodeinformation['nodeid'];
$ipv4address = $nodeinformation['v4addresses'];
$nodedetails = getNodeData($nodeid);

if ($_GET['a']==='availabletemplates'){
?>
<script>
$(document).ready(function(){$('select').niceSelect()})
</script>
        <select name="newos" class="nice-select small wide" class="display: none;">
        <?php
        $templates = getTemplates($nodeid);
        foreach($templates as $value) {
        echo '<option value="'.$value.'">'.$value.'</option>';
        }
        ?>
        </select>
        <input id="spbtn" type="submit" class="btn btn-danger" style="padding-top: 8px; margin-top: 15px;" value="Re-image virtual server">
<?php
}

if($_GET['a']==='serverstatus') {
$is_suspended = $nodeinformation['status'];

if ($is_suspended == 'inactive'){
echo '<span class="status-light sl-red"> </span> Suspended';
} else {
if(status($_GET['vserver'], $nodeid)=="false") {
echo '<span class="status-light sl-red"> </span> OFFLINE';
} else {
echo '<span class="status-light sl-green"> </span> ONLINE';
}
}
}

if($_GET['a']==='listvps') {
$ath = $dbh->prepare('SELECT * from virtualservers where owner=:owner');
$ath->bindParam(':owner', $_SESSION['user_name']);
$ath->execute();

if ($ath->rowCount() > 0) {


foreach ($ath as $row){
echo '<div class="panel panel-default"><div class="panel-body">';

$status = getPowerLevel($row["ctid"], $row["nodeid"]);

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
}


if($_GET['a']==='control') {
$ath = $dbh->prepare('SELECT * from virtualservers where ctid=:ctid');
$ath->bindParam(":ctid", $_GET['vserver']);
$ath->execute();

if (!$ath->rowCount() > 0) {
header('Location: /manager/listvps.php');
die('Fatal Error');
}

if ($_GET['act'] == "retrieveconsole") {
if(checkConsole($_GET['vserver'], $nodeid) == "enabled"){

$getdetails = getConsoleDetails($_GET['vserver'], $nodeid);
echo '<br /><br /><pre class="code">Please note: You should connect to the node hostname specified in the section above. <br>'.$getdetails.'</pre>';

} else {

}
}

if ($_GET['act'] == "toggleserialconsole"){
if(checkConsole($_GET['vserver'], $nodeid) == "enabled"){
$sessiondata = toggleSession($_GET['vserver'], $nodeid);
echo "
<script type='text/javascript'>
$('#loading').modal('hide');
$('#message').html('<h1>Serial console disabled.</h1><h4>You may now close the dialog :)</h4>');
$('#messagemodal').modal('show');
</script>
";
} else {
$sessiondata = toggleSession($_GET['vserver'], $nodeid);
echo "
<script type='text/javascript'>
$('#loading').modal('hide');
$('#message').html('<h1>Serial console enabled.</h1><h4>You may now close the dialog :)</h4>');
$('#messagemodal').modal('show');
</script>
";

}
}

if ($_GET['act'] == "serialconsole"){
if(checkConsole($_GET['vserver'], $nodeid) == "enabled"){
?>
<a href="#" id="toggleconsole" class="btn btn-danger">Disable serial console</a>
<?php
} else {
?>
<a href="#" id="toggleconsole" class="btn btn-success">Enable serial console</a>
<?php
}
?>
<script>
$( "#toggleconsole" ).on( "click", function() {
console.log('Toggle serial request...');
$( "#whichaction" ).html( 'Toggling serial console...' );
$('#loading').modal('show');
$( "#hiddenres" ).load( "ajaxfunctions.php?a=control&vserver=<?php print($_GET['vserver']); ?>&act=toggleserialconsole" );
$( "#serialdetails" ).load("ajaxfunctions.php?a=control&vserver=<?php print($_GET['vserver']); ?>&act=serialconsole" );
$( "#console" ).load("ajaxfunctions.php?a=control&vserver=<?php print($_GET['vserver']); ?>&act=retrieveconsole" );

});
</script>
<?php
}

if ($_GET['act'] == "rammb"){
echo rammb($_GET['vserver'], $nodeid);
}

if ($_GET['act'] == "diskgb"){
$disk = number_format(diskgb($_GET['vserver'], $nodeid), 2, ".", ",");
echo '('.$disk.' GB used)';
}

if ($_GET['act'] == "start"){

if(status($_GET['vserver'], $nodeid)=="true") {
echo '

<script type="text/javascript">
$("#loading").modal("hide");
$("#message").html("<h1>Error!</h1><h4>The server has already been started.");

$("#messagemodal").modal("show");

</script>


';
} else {

$poweract = poweron($_GET['vserver'], $nodeid);
echo '
<script type="text/javascript">
$("#loading").modal("hide");
$("#message").html("<h1>Server Started.</h1><h4>You may now close the dialog :)");

$("#messagemodal").modal("show");

</script>

';
}

} elseif ($_GET['act'] == "stop"){

if(status($_GET['vserver'], $nodeid)=="false") {
echo '

<script type="text/javascript">
$("#loading").modal("hide");
$("#message").html("<h1>Error!</h1><h4>The server is already powered down.");

$("#messagemodal").modal("show");

</script>


';
} else {

$poweract = poweroff($_GET['vserver'], $nodeid);
echo '
<script type="text/javascript">
$("#loading").modal("hide");
$("#message").html("<h1>Server Shut Down.</h1><h4>You may now close the dialog :)");

$("#messagemodal").modal("show");

</script>

';
}

} elseif ($_GET['act'] == "restart") {
if(status($_GET['vserver'], $nodeid)=="false") {
exit('

<script type="text/javascript">
$("#loading").modal("hide");
$("#message").html("<h1>Error!</h1><h4>The server needs to be online to restart.");

$("#messagemodal").modal("show");

</script>


');
} else {
$poweract = reboot($_GET['vserver'], $nodeid);

exit('
<script type="text/javascript">
$("#loading").modal("hide");
$("#message").html("<h1>Server Restarted.</h1><h4>You may now close the dialog :)");

$("#messagemodal").modal("show");

</script>

');
}

} elseif ($_GET['act'] == "resetpass") {
$newpass = resetpass($_GET['vserver'], $nodeid);
/*
exit('<script type="text/javascript">
$("#loading").modal("hide");
$("#message").html("<h1>Your root password has been reset..</h1><h4>You may now close the dialog :)</h4>");
$("#pass-reset").html("<p>Your new root password: '.$newpass.'</p>");
$("#messagemodal").modal("show");
</script>
');
*/

echo "

<script type='text/javascript'>
$('#loading').modal('hide');
$('#message').html('<h1>Password has been reset.</h1><h4>Your new root password is: ". trim($newpass) ."</h4>');

$('#messagemodal').modal('show');

</script>

";

} elseif ($_GET['act'] == "reinstall" && !empty($_POST['os'])){
if(checkTemplate($_POST['os'], $nodeid)){
$err = 0;
} else {
$err = 1;
}


if($err==1) {
exit('
<script type="text/javascript">
$("#loading").modal("hide");
$("#message").html("<h1>Reinstall Failed.</h1><h4>You may now close the dialog :)</h4>");
$("#messagemodal").modal("show");
</script>

');

}

$os = $_POST['os'];
$dangeract = reinstall($_GET['vserver'], $os, $nodeid);
exit('
<script type="text/javascript">
$("#loading").modal("hide");
$("#message").html("<h1>Server Reinstalled.</h1><h4>You may now close the dialog :)</h4>");
$("#messagemodal").modal("show");

</script>

');

}

if($_GET['act']==='memory') {
echo memoryusage($_GET['vserver'], $nodeid);
}
if($_GET['act']==='templates') {
echo getos($_GET['vserver'], $nodeid);
}
if($_GET['act']==='disk') {
echo getDisk($_GET['vserver'], $nodeid);
}
if($_GET['act']==='ipv4') {
echo $nodedetails['hostname'];
}

if($_GET['act']==='assignedips') {
//echo '2001:470:c:d42:0:1:1:'. $_GET['vserver'] .'';
echo $nodeinformation['v4addresses'];

}

if($_GET['act']==='toggle-tun') {
if(checktun($_GET['vserver'], $nodeid) == 'off') {
$tunrun = enabletun($_GET['vserver'], $nodeid);
exit('
<script type="text/javascript">
$("#loading").modal("hide");
$("#message").html("<h1>TUN/TAP has been enabled.</h1><h4>You may now close the dialog :)</h4>");
$("#tunmsg").html("(TUN/TAP is enabled)");
$("#tunslider").prop("checked", true);
$("#messagemodal").modal("show");

</script>

');

} else {
$tunrun = disabletun($_GET['vserver'], $nodeid);
exit('
<script type="text/javascript">
$("#loading").modal("hide");
$("#message").html("<h1>TUN/TAP has been disabled.</h1><h4>You may now close the dialog :)</h4>");
$("#tunmsg").html("(TUN/TAP is disabled)");
$("#tunslider").prop("checked", false);
$("#messagemodal").modal("show");

</script>
');


}
}
if($_GET['act']==='netdetails') {
?>
<pre class="code">
Your IPv4 Address: <?php echo $nodeinformation['v4addresses']; ?>
</pre>

<?php
}
if($_GET['act']==='sshdetails') {
?>
<pre class="code">
ssh root@<?php echo $nodeinformation['v4addresses']; ?>
</pre>
<?php
}
if($_GET['act']==='tun-status') {
if(checktun($_GET['vserver'], $nodeid) === 'on') {
?>
<script type="text/javascript">
$("#tuncontrol").html('<div class="tuncontrol"><div class="checkbox checkbox-slider--b-flat checkbox-slider-md"><label><input id="tunslider" type="checkbox" checked=""><span id="tunmsg">(TUN/TAP is enabled)</label></div></div>');

</script>
<?php
exit();
} else {
?>
<script type="text/javascript">
$("#tuncontrol").html('<div class="checkbox checkbox-slider--b-flat checkbox-slider-md"><label><input id="tunslider" type="checkbox"><span id="tunmsg">(TUN/TAP is disabled)</label></div>');


</script>

<?php
exit();
}
}
}
?>

