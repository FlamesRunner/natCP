<?php
session_start();
include 'auth.php';
include 'db.php';
if (empty($_POST['newos'])){
include 'header.php';
} else {
include 'headerReinstall.php';
}
include 'functions.php';

$ath = $dbh->prepare('SELECT * from virtualservers where owner=:username and ctid=:ctid');
$ath->bindParam(":username", $_SESSION['user_name']);
$ath->bindParam(":ctid", $_GET['vserver']);
$ath->execute();

$getvpsnode = $dbh->prepare('SELECT * from virtualservers where ctid=:vserverid');
$getvpsnode->bindParam(':vserverid', $_GET['vserver']);
$getvpsnode->execute();
$nodeinformation = $getvpsnode->fetch();
$nodeid = $nodeinformation['nodeid'];

?>

<div class="container">



<?php
if (!$ath->rowCount() > 0) {
die('<h1>Manage</h1><div class="panel panel-default"><div class="panel-body">Fatal Error: this server does not exist.</div></div>');
} else {

?>

<script type="text/javascript">
$(document).ready(function(){function t(){var t;$.get("ajaxfunctions.php?a=control&vserver=<?php print($_GET['vserver']); ?>&act=memory",function(e){t=$.trim(e),$("#ram-bar").css("width",t+"%")})}function e(){var t;$.get("ajaxfunctions.php?a=control&vserver=<?php print($_GET['vserver']); ?>&act=disk",function(e){t=$.trim(e),$("#disk-bar").css("width",t+"%")})}function n(){$("#os").load("ajaxfunctions.php?a=control&vserver=<?php print($_GET['vserver']); ?>&act=templates&vserver=<?php print($_GET['vserver']); ?>")}function s(){$("#ipv4").load("ajaxfunctions.php?a=control&vserver=<?php print($_GET['vserver']); ?>&act=ipv4")}function a(){$("#assignedips").load("ajaxfunctions.php?a=control&vserver=<?php print($_GET['vserver']); ?>&act=assignedips")}function o(){$("#port").load("ajaxfunctions.php?a=control&vserver=<?php print($_GET['vserver']); ?>&act=port")}function r(){$("#serverstatus").load("ajaxfunctions.php?a=serverstatus&vserver=<?php print($_GET['vserver']); ?>")}function l(){$("#netdetails").load("ajaxfunctions.php?a=control&act=netdetails&vserver=<?php print($_GET['vserver']); ?>")}function i(){$("#sshdetails").load("ajaxfunctions.php?a=control&act=sshdetails&vserver=<?php print($_GET['vserver']); ?>")}function c(){$("#serialdetails").load("ajaxfunctions.php?a=control&act=serialconsole&vserver=<?php print($_GET['vserver']); ?>")}function p(){$("#ramusage").load("ajaxfunctions.php?a=control&act=rammb&vserver=<?php print($_GET['vserver']); ?>")}function v(){$("#diskusage").load("ajaxfunctions.php?a=control&act=diskgb&vserver=<?php print($_GET['vserver']); ?>")}function h(){$("#console").load("ajaxfunctions.php?a=control&act=retrieveconsole&vserver=<?php print($_GET['vserver']); ?>")}function d(){console.log("OS template refresh..."),$("#ostemplates").load("ajaxfunctions.php?a=availabletemplates&vserver=<?php print($_GET['vserver']); ?>")}function u(){console.log("TUN/TAP Update request..."),$("#hiddenres").load("ajaxfunctions.php?a=control&vserver=<?php print($_GET['vserver']); ?>&act=tun-status")}function g(){t(),u(),e(),n(),s(),a(),o(),r(),l(),i(),c(),h(),d(),p(),v()}function f(){console.log("Server reinstall request..."),$("#whichaction").html("Reinstalling Server..."),$("#loading").modal("show")}function m(p){$("#hiddenres").html(p),t(),u(),e(),n(),s(),a(),o(),r(),l(),i(),c(),h(),d()}console.log("Requesting data..."),t(),p(),e(),n(),s(),a(),o(),r(),l(),i(),c(),h(),d(),u(),d(),v(),$("#reload").click(function(){console.log("Data update request..."),$("#ostemplates").html('<img style="width: 2%;" src="load.png" alt="load">'),$("#os").html('<img style="width: 5%;" src="load.png" alt="load">'),$("#ipv4").html('<img style="width: 5%;" src="load.png" alt="load">'),$("#assignedips").html('<img style="width: 5%;" src="load.png" alt="load">'),$("#port").html('<img style="width: 5%;" src="load.png" alt="load">'),$("#serverstatus").html('<span class="status-light sl-grey"> </span> UNKNOWN'),$("#netdetails").html('<img style="width: 2%;" src="load.png" alt="load">'),$("#serialdetails").html('<img style="width: 2%;" src="load.png" alt="load">'),$("#sshdetails").html('<img style="width: 2%;" src="load.png" alt="load">'),g()}),$("#start").click(function(){console.log("Start server request..."),$("#whichaction").html("Starting..."),$("#loading").modal("show"),$("#hiddenres").load("ajaxfunctions.php?a=control&vserver=<?php print($_GET['vserver']); ?>&act=start"),g()}),$("#stop").click(function(){console.log("Stop server request..."),$("#whichaction").html("Shutting down..."),$("#loading").modal("show"),$("#hiddenres").load("ajaxfunctions.php?a=control&vserver=<?php print($_GET['vserver']); ?>&act=stop"),g()}),$("#restart").click(function(){console.log("Restart server request..."),$("#whichaction").html("Restarting..."),$("#loading").modal("show"),$("#hiddenres").load("ajaxfunctions.php?a=control&vserver=<?php print($_GET['vserver']); ?>&act=restart"),g()}),$("#enable-tun").click(function(){console.log("Disable TUN/TAP request..."),$("#whichaction").html("Enabling TUN/TAP..."),$("#loading").modal("show"),$("#hiddenres").load("ajaxfunctions.php?a=control&vserver=<?php print($_GET['vserver']); ?>&act=enable-tun")}),$("#reinstallvps").submit(function(t){console.log("Reinstalling virtual server..."),$("#ostemplate").css("display","none"),$("#ostemplatesmsg").html('<img width="2%" src="load.png" alt="Loading...">')}),$("#tuncontrol").on("click",function(){console.log("Toggle TUN/TAP request..."),$("#whichaction").html("Toggling TUN/TAP..."),event.preventDefault(),$("#loading").modal("show"),$("#hiddenres").load("ajaxfunctions.php?a=control&vserver=<?php print($_GET['vserver']); ?>&act=toggle-tun")}),$("#resetpw").on("click",function(){console.log("Password Reset request..."),$("#whichaction").html("Resetting password..."),$("#loading").modal("show"),$("#passmsg").load("ajaxfunctions.php?a=control&vserver=<?php print($_GET['vserver']); ?>&act=resetpass")}),$("#reinstallserver").submit(function(){return $(this).attr("action"),f(),$.ajax({url:"ajaxfunctions.php?a=control&act=reinstall&vserver=<?php print($_GET['vserver']); ?>",type:"POST",data:{os:$("select[name=newos]").val()},success:function(t){m(t)},error:function(t){m(t)}}),!1})});
</script>
<span style="display: none;" id="hiddenres"></span>
<h1>Container <?php print($_GET['vserver']); ?> <span style="font-size: 15px;"><a id="reload"><span class="glyphicon glyphicon-repeat"></span></a></span></h4></h1>

    
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
        <td class="col-xs-6" style="text-align: right; background-color: #f9f9f9;">RAM Usage <span id="ramusage">(Refreshing...)</span></td>
        <td class="col-xs-6">
 <div class="progress">
                      <div id="ram-bar" style="width: 0%;" class="progress-bar progress-bar-info progress-bar-striped" role="progressbar"></div>
                    </div> 
</td>
      </tr>
      <tr>
        <td class="col-xs-6" style="text-align: right; background-color: #f9f9f9;">Disk Usage <span id="diskusage">(Refreshing...)</span></td>
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
<?php 
if ($nodeinformation["status"] == "inactive"){ 
echo '<h4>Controls have been disabled as this container has been suspended.</h4>';
} else { 
?>
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
  <li><a href="#tab_ssh" data-toggle="tab">SSH</a></li>
  <li><a href="#tab_serial" data-toggle="tab">Serial Console</a></li>
  <li><a href="#tab_reimage" data-toggle="tab">Reimage virtual server</a></li>
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

        
<div class="tab-pane" id="tab_ssh">
          <div class="panel panel-default" style="border-top-left-radius: 0px; border-top-right-radius: 0px;"><div class="panel-body">
        <h4 style="margin-top: 0px;">To connect to your server, follow the instructions below. <small>The command has been generated automagically :)</small></h4>
        <span id="sshdetails"><img style="width: 2%;" src="load.png" alt="load"></span>
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
</div>


</div>
<?php 
}
} 
?>

