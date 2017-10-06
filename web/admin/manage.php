<?php
session_start();
include 'auth.php';
include 'db.php';
if ($_GET['act'] !== "destroy"){
if (empty($_POST['newos'])){
include 'header.php';
} else {
include 'headerReinstall.php';
}
}
include 'functions.php';

$ath = $dbh->prepare('SELECT * from virtualservers where ctid=:ctid');
$ath->bindParam(":ctid", $_GET['vserver']);
$ath->execute();

$ctdata = $ath->fetch();
$container_owner = $ctdata["owner"];

$getvpsnode = $dbh->prepare('SELECT * from virtualservers where ctid=:vserverid');
$getvpsnode->bindParam(':vserverid', $_GET['vserver']);
$getvpsnode->execute();
$nodeinformation = $getvpsnode->fetch();
$status = $nodeinformation['status'];
$nodeid = $nodeinformation['nodeid'];

?>

<div class="container">

<?php
if (!$ath->rowCount() > 0) {
die('<h1>Manage</h1><div class="panel panel-default"><div class="panel-body">Fatal Error: this server does not exist.</div></div>');
} else {

if ($_GET['act'] == "destroy") { 
$destroy = $dbh->prepare('DELETE from virtualservers where ctid=:ctid');
$destroy->bindParam(':ctid', $_GET['vserver']);
$destroy->execute();
destroy($_GET['vserver'], $nodeid);
header("Location: /vpscp/admin/listvps.php");
} elseif ($_GET['act'] == "togglesuspension"){

if ($status == "active"){ 

$suspend = suspend($_GET['vserver'], $nodeid);
$execquery = 'UPDATE virtualservers set status="inactive" where ctid=:ctid';
$status = "inactive";

} else {

$unsuspend = unsuspend($_GET['vserver'], $nodeid);
$execquery = 'UPDATE virtualservers set status="active" where ctid=:ctid';
$status = "active";

}

$execsql = $dbh->prepare($execquery);
$execsql->bindParam(':ctid', $_GET['vserver']);
$execsql->execute();

} else {
include 'header.php';
}

?>

<script src="nice.js" type="text/javascript"></script>
<script type="text/javascript">
$(document).ready(function(){function a(){var a;$.get("ajaxfunctions.php?a=control&vserver=<?php print($_GET['vserver']); ?>&act=memory",function(b){a=$.trim(b),$("#ram-bar").css("width",a+"%")})}function b(){var a;$.get("ajaxfunctions.php?a=control&vserver=<?php print($_GET['vserver']); ?>&act=disk",function(b){a=$.trim(b),$("#disk-bar").css("width",a+"%")})}function c(){$("#terminate").load("ajaxfunctions.php?a=control&act=terminatearea&vserver=<?php print($_GET['vserver']); ?>")}function d(){$("#os").load("ajaxfunctions.php?a=control&vserver=<?php print($_GET['vserver']); ?>&act=templates&vserver=<?php print($_GET['vserver']); ?>")}function e(){$("#ipv4").load("ajaxfunctions.php?a=control&vserver=<?php print($_GET['vserver']); ?>&act=ipv4")}function f(){$("#assignedips").load("ajaxfunctions.php?a=control&vserver=<?php print($_GET['vserver']); ?>&act=assignedips")}function g(){$("#port").load("ajaxfunctions.php?a=control&vserver=<?php print($_GET['vserver']); ?>&act=port")}function h(){$("#serverstatus").load("ajaxfunctions.php?a=serverstatus&vserver=<?php print($_GET['vserver']); ?>")}function i(){$("#netdetails").load("ajaxfunctions.php?a=control&act=netdetails&vserver=<?php print($_GET['vserver']); ?>")}function j(){$("#sshdetails").load("ajaxfunctions.php?a=control&act=sshdetails&vserver=<?php print($_GET['vserver']); ?>")}function k(){$("#serialdetails").load("ajaxfunctions.php?a=control&act=serialconsole&vserver=<?php print($_GET['vserver']); ?>")}function l(){$("#console").load("ajaxfunctions.php?a=control&act=retrieveconsole&vserver=<?php print($_GET['vserver']); ?>")}function m(){console.log("OS template refresh..."),$("#ostemplates").load("ajaxfunctions.php?a=availabletemplates&vserver=<?php print($_GET['vserver']); ?>")}function n(){console.log("TUN/TAP Update request..."),$("#hiddenres").load("ajaxfunctions.php?a=control&vserver=<?php print($_GET['vserver']); ?>&act=tun-status")}function o(){a(),n(),b(),d(),e(),f(),g(),h(),i(),j(),k(),l(),m()}function p(){console.log("Server reinstall request..."),$("#whichaction").html("Reinstalling Server..."),$("#loading").modal("show")}function q(c){$("#hiddenres").html(c),a(),n(),b(),d(),e(),f(),g(),h(),i(),j(),k(),l(),m()}function r(){$("#reinstallserver").submit(function(){return $(this).attr("action"),p(),$.ajax({url:"ajaxfunctions.php?a=control&act=reinstall&vserver=<?php print($_GET['vserver']); ?>",type:"POST",data:{os:$("select[name=newos]").val()},success:function(a){q(a)},error:function(a){q(a)}}),!1})}c(),console.log("Requesting data..."),a(),b(),d(),e(),f(),g(),h(),i(),j(),k(),l(),m(),n(),m(),$("#reload").click(function(){console.log("Data update request..."),$("#ostemplates").html('<img style="width: 2%;" src="load.png" alt="load">'),$("#os").html('<img style="width: 5%;" src="load.png" alt="load">'),$("#ipv4").html('<img style="width: 5%;" src="load.png" alt="load">'),$("#assignedips").html('<img style="width: 5%;" src="load.png" alt="load">'),$("#port").html('<img style="width: 5%;" src="load.png" alt="load">'),$("#serverstatus").html('<span class="status-light sl-grey"> </span> UNKNOWN'),$("#netdetails").html('<img style="width: 2%;" src="load.png" alt="load">'),$("#serialdetails").html('<img style="width: 2%;" src="load.png" alt="load">'),$("#sshdetails").html('<img style="width: 2%;" src="load.png" alt="load">'),o()}),$("#start").click(function(){console.log("Start server request..."),$("#whichaction").html("Starting..."),$("#loading").modal("show"),$("#hiddenres").load("ajaxfunctions.php?a=control&vserver=<?php print($_GET['vserver']); ?>&act=start"),o()}),$("#stop").click(function(){console.log("Stop server request..."),$("#whichaction").html("Shutting down..."),$("#loading").modal("show"),$("#hiddenres").load("ajaxfunctions.php?a=control&vserver=<?php print($_GET['vserver']); ?>&act=stop"),o()}),$("#restart").click(function(){console.log("Restart server request..."),$("#whichaction").html("Restarting..."),$("#loading").modal("show"),$("#hiddenres").load("ajaxfunctions.php?a=control&vserver=<?php print($_GET['vserver']); ?>&act=restart"),o()}),$("#enable-tun").click(function(){console.log("Disable TUN/TAP request..."),$("#whichaction").html("Enabling TUN/TAP..."),$("#loading").modal("show"),$("#hiddenres").load("ajaxfunctions.php?a=control&vserver=<?php print($_GET['vserver']); ?>&act=enable-tun")}),$("#reinstallvps").submit(function(a){console.log("Reinstalling virtual server..."),$("#ostemplate").css("display","none"),$("#ostemplatesmsg").html('<img width="2%" src="load.png" alt="Loading...">')}),$("#tuncontrol").on("click",function(){console.log("Toggle TUN/TAP request..."),$("#whichaction").html("Toggling TUN/TAP..."),event.preventDefault(),$("#loading").modal("show"),$("#hiddenres").load("ajaxfunctions.php?a=control&vserver=<?php print($_GET['vserver']); ?>&act=toggle-tun")}),$("#resetpw").on("click",function(){console.log("Password Reset request..."),$("#whichaction").html("Resetting password..."),$("#loading").modal("show"),$("#passmsg").load("ajaxfunctions.php?a=control&vserver=<?php print($_GET['vserver']); ?>&act=resetpass")}),r()});
</script>
<span style="display: none;" id="hiddenres"></span>
<h1>Container <?php print($_GET['vserver']); ?> <span style="font-size: 15px;"> <a id="reload"><span class="glyphicon glyphicon-repeat"></span></a></span><span style="font-size: 15px;">&nbsp&nbspManaged by <?php echo $container_owner; ?>. Click <a href="modifyvps.php?vserver=<?php echo $_GET['vserver']; ?>">here</a> to modify the virtual server.</span></h1>

    
<div class="panel panel-default">
<div class="panel-body">
<span id="serverstatus">
<span class="status-light sl-grey"> </span> UNKNOWN
</span>

</div>
</div>
<div class="row">
<div class="col-md-6">
  <table class="table table-bordered table-responsive">
    <tbody>
      <tr>
        <td class="col-xs-6" style="text-align: right; background-color: #f9f9f9;">RAM Usage</td>
        <td class="col-xs-6">
 <div class="progress">
                      <div id="ram-bar" style="width: 0%;" class="progress-bar progress-bar-info progress-bar-striped" role="progressbar"></div>
                    </div> 
</td>
      </tr>
      <tr>
        <td class="col-xs-6" style="text-align: right; background-color: #f9f9f9;">Disk Usage</td>
        <td class="col-xs-6">
 <div class="progress">
                      <div id="disk-bar" style="width: 0%;" class="progress-bar progress-bar-info progress-bar-striped" role="progressbar"></div>
                    </div>

</td>
      </tr>
      <tr>
        <td class="col-xs-6" style="text-align: right; background-color: #f9f9f9; border">Operating System</td>
        <td id="os" class="col-xs-6"><img style="width: 5%;" src="load.png" alt="load"></td>
      </tr>
    </tbody>
  </table>
</div>
<div class="col-md-6">
  <table class="table table-bordered table-responsive">
    <tbody>
      <tr>
        <td class="col-xs-6" style="text-align: right; background-color: #f9f9f9;">Node IP</td>
        <td id="ipv4" class="col-xs-6"><img style="width: 5%;" src="load.png" alt="load"></td>
      </tr>
      <tr>
        <td class="col-xs-6" style="text-align: right; background-color: #f9f9f9;">Assigned IPs</td>
        <td id="assignedips" class="col-xs-6"><img style="width: 5%;" src="load.png" alt="load"></td>
      </tr>
      <tr>
        <td class="col-xs-6" style="text-align: right; background-color: #f9f9f9; border">Virtualisation</td>
        <!--<td id="port" class="col-xs-6"><img style="width: 5%;" src="load.png" alt="load"></td>-->
	<td>OpenVZ</td>
      </tr>
    </tbody>
  </table>
</div>

<div class="container">
<div class="row">
   <div class="col-md-4">
      <div class="panel panel-default">
         <div class="panel-body" style="padding-left: 15px; padding-top: 5px; padding-bottom: 8px; cursor: pointer;" id="start">
            <center>
               <h1><span style="color: #67e580;" class="glyphicon glyphicon-play"></span></h1>
            </center>
         </div>
      </div>
   </div>
   <div class="col-md-4">
      <div class="panel panel-default">
         <div class="panel-body" style="padding-left: 15px; padding-top: 5px; padding-bottom: 8px; cursor: pointer;" id="stop">
            <center>
               <h1><span style="color: #ef3b32;" class="glyphicon glyphicon-stop"></span></h1>
            </center>
         </div>
      </div>
   </div>
   <div class="col-md-4">
      <div class="panel panel-default">
         <div class="panel-body" style="padding-left: 15px; padding-top: 5px; padding-bottom: 8px; cursor: pointer;" id="restart">
            <center>
               <h1><span style="color: #99d0db;" class="glyphicon glyphicon-repeat"></span></h1>
            </center>
         </div>
      </div>
   </div>
</div>

<ul class="nav nav-tabs">
  <li class="active"><a href="#tab_resetpw" data-toggle="tab">Reset Password</a></li>
  <li><a href="#tab_tuntap" data-toggle="tab">TUN/TAP</a></li>
  <li><a href="#tab_net" data-toggle="tab">Network</a></li>
  <li><a href="#tab_serial" data-toggle="tab">Serial Console</a></li>
  <li><a href="#tab_reimage" data-toggle="tab">Reimage virtual server</a></li>
  <li><a href="#tab_suspension" data-toggle="tab">Suspend/unsuspend virtual server</a></li>
  <li><a href="#tab_terminate" data-toggle="tab">Destroy virtual server</a></li>
</ul>
<div class="tab-content">
        <div class="tab-pane active" id="tab_resetpw">
          <div class="panel panel-default" style="border-top-left-radius: 0px; border-top-right-radius: 0px;"><div class="panel-body">
        <h4 style="margin-top: 0px;">Forgot your password? Locked yourself out? It happens. <small>Reset your password with the button below!</small></h4>

<span id="passmsg"></span>
<span id="pass-reset"><a id="resetpw" href="#" class="btn btn-success">Reset root password</a></span>         

</div></div>

        </div>
        
        <div class="tab-pane" id="tab_tuntap">
        
        <div class="panel panel-default" style="border-top-left-radius: 0px; border-top-right-radius: 0px;"><div class="panel-body">
        <h4 style="margin-top: 0px;">You can enable or disable TUN/TAP below. <small>Hit the switch accordingly ;)</small></h4>
        <span id="tuncontrol"><img style="width: 2%;" src="load.png" alt="load"></span>
         </div></div></div>
        <div class="tab-pane" id="tab_net">
  <div class="panel panel-default" style="border-top-left-radius: 0px; border-top-right-radius: 0px;"><div class="panel-body">
        <h4 style="margin-top: 0px;">Your server network details are below.</h4>
        <span id="netdetails"><img style="width: 2%;" src="load.png" alt="load"></span>
         </div></div></div>
    
<div class="tab-pane" id="tab_serial">
          <div class="panel panel-default" style="border-top-left-radius: 0px; border-top-right-radius: 0px;"><div class="panel-body">
        <h4 style="margin-top: 0px;">You really did it this time. Good job. <small>Access your server through the serial console (not a replacement for plain ol' SSH).</small></h4>
        <span id="serialdetails"><img style="width: 2%;" src="load.png" alt="load"></span>
	<span id ="console"></span>
         </div></div></div>	

<div class="tab-pane" id="tab_reimage">
        <div class="panel panel-default" style="border-top-left-radius: 0px; border-top-right-radius: 0px;"><div class="panel-body">
        <h4 style="margin-top: 0px;">Need a fresh start? Reimage your server here. <small>(note: all data will be wiped)</small></h4>
<form id="reinstallserver" method="POST">
	<span id="ostemplates"><img style="width: 2%;" src="load.png" alt="load"></span>
	</form>
	</div></div></div>

        <div class="tab-pane" id="tab_terminate">
                <div class="panel panel-default" style="border-top-left-radius: 0px; border-top-right-radius: 0px;"><div class="panel-body">
                <h4 style="margin-top: 0px;"><b>This action cannot be reversed.</b> Proceed at your own risk.</h4>
                <span id="terminate"><img style="width: 2%;" src="load.png" alt="load"></span>
        </div></div></div>

        <div class="tab-pane" id="tab_suspension">
                <div class="panel panel-default" style="border-top-left-radius: 0px; border-top-right-radius: 0px;"><div class="panel-body">
                <h4 style="margin-top: 0px;"><b>This allows you to manage the suspension of a virtual server.</h4>
		<?php
		if($status == "active"){
                echo '<a href="manage.php?vserver='.$_GET["vserver"].'&act=togglesuspension" class="btn btn-danger">Suspend</a>';
		} else {
		echo '<a href="manage.php?vserver='.$_GET["vserver"].'&act=togglesuspension" class="btn btn-success">Unsuspend</a>';
		}
		?>
        </div></div></div>

</div>


</div>
<?php } ?>

