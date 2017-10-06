<?php
include('Net/SSH2.php');
include('config.php');
include('db.php');

function getNodeData($nodeid) {

include('db.php');
$getnodedata = $dbh->prepare('SELECT * from nodes where id=:nodeid');
$getnodedata->bindParam(':nodeid', $nodeid);
$getnodedata->execute();
$result = $getnodedata->fetch();
return $result;

}

function downloadTemplate($templateurl, $saveas, $nodeid){
include('db.php');

$nodedata = getNodeData($nodeid);
$hostname = $nodedata['hostname'];
$accesskey = $nodedata['accesskey'];

$ssh = new Net_SSH2($hostname);
if (!$ssh->login('remote', $accesskey)) {
exit('System is under maintenance.');
}

$performact = $ssh->exec("/usr/bin/sudo /sbin/containermanager templatemgr add '" . $templateurl . "' '".$saveas."'");
return $performact;
}

function checkIP($ipaddress, $nodeid){
include('db.php');

$nodedata = getNodeData($nodeid);
$hostname = $nodedata['hostname'];
$accesskey = $nodedata['accesskey'];

$ssh = new Net_SSH2($hostname);
if (!$ssh->login('remote', $accesskey)) {
exit('System is under maintenance.');
}

$performact = $ssh->exec("/usr/bin/sudo /sbin/containermanager checkip '".$ipaddress."'");
if (strpos($performact, 'available') !== false) {
$code = "true";
} else {
$code = "false";
}

return $code;

}

function deleteTemplate($template, $nodeid){
include('db.php');

$nodedata = getNodeData($nodeid);
$hostname = $nodedata['hostname'];
$accesskey = $nodedata['accesskey'];

$ssh = new Net_SSH2($hostname);
if (!$ssh->login('remote', $accesskey)) {
exit('System is under maintenance.');
}

$performact = $ssh->exec("/usr/bin/sudo /sbin/containermanager templatemgr del '".$template."'");
return $performact;

}

function suspend($ctid, $nodeid){
include('db.php');

$nodedata = getNodeData($nodeid);
$hostname = $nodedata['hostname'];
$accesskey = $nodedata['accesskey'];

$ssh = new Net_SSH2($hostname);
if (!$ssh->login('remote', $accesskey)) {
exit('System is under maintenance.');
}

$performact = $ssh->exec("/usr/bin/sudo /sbin/containermanager suspend ".$ctid);
return $performact;

}

function unsuspend($ctid, $nodeid){
include('db.php');

$nodedata = getNodeData($nodeid);
$hostname = $nodedata['hostname'];
$accesskey = $nodedata['accesskey'];

$ssh = new Net_SSH2($hostname);
if (!$ssh->login('remote', $accesskey)) {
exit('System is under maintenance.');
}

$performact = $ssh->exec("/usr/bin/sudo /sbin/containermanager unsuspend ".$ctid);
return $performact;

}

function createContainer($ctid, $os, $ipaddress, $nodeid){

include('db.php');

$nodedata = getNodeData($nodeid);
$hostname = $nodedata['hostname'];
$accesskey = $nodedata['accesskey'];

$ssh = new Net_SSH2($hostname);
if (!$ssh->login('remote', $accesskey)) {
exit('System is under maintenance.');
}

$create = trim($ssh->exec("/usr/bin/sudo /sbin/containermanager create ".$ctid." ".$os));
$setIP = trim($ssh->exec("/usr/bin/sudo /usr/sbin/vzctl set " . $ctid . " --ipadd " . $ipaddress . " --save"));
$reinstall = reinstall($ctid, $os, $nodeid);
return '1';

}

function checkTemplate($os, $nodeid) {

include ('db.php');
$nodedata = getNodeData($nodeid);
$hostname = $nodedata['hostname'];
$accesskey = $nodedata['accesskey'];

$ssh = new Net_SSH2($hostname);
if (!$ssh->login('remote', $accesskey)) {
exit('System is under maintenance.');
}

$checkTemplate = getTemplates($nodeid);
if (in_array($os, $checkTemplate)){
return true;
} else {
return false;
}

}

function getConsoleDetails($ctid, $nodeid){
include('db.php');

$nodedata = getNodeData($nodeid);
$hostname = $nodedata['hostname'];
$accesskey = $nodedata['accesskey'];

$ssh = new Net_SSH2($hostname);
if (!$ssh->login('remote', $accesskey)) {
exit('System is under maintenance.');
}

$details = $ssh->exec('/usr/bin/sudo /sbin/containermanager retrieveconsole ' . $ctid);
return $details;
}

function checkNodeStatus($accesskey, $hostname) {
include('db.php');

$ssh = new Net_SSH2($hostname);
if (!$ssh->login('remote', $accesskey)) {
return false;
}

$check = trim($ssh->exec('/usr/bin/sudo /sbin/containermanager'));
if (strpos($check, 'command not found') !== false){
return false;
} else {
return true;
}

}

function checkConsole($ctid, $nodeid){
include('db.php');

$nodedata = getNodeData($nodeid);
$hostname = $nodedata['hostname'];
$accesskey = $nodedata['accesskey'];

$ssh = new Net_SSH2($hostname);
if (!$ssh->login('remote', $accesskey)) {
exit('System is under maintenance.');
}

$status = trim($ssh->exec('/usr/bin/sudo /sbin/containermanager checkconsole ' . $ctid));
if ($status == "1") {
return "enabled";
} else {
return "disabled";
}
}

function toggleSession($ctid, $nodeid){
include('db.php');

$nodedata = getNodeData($nodeid);
$hostname = $nodedata['hostname'];
$accesskey = $nodedata['accesskey'];

$ssh = new Net_SSH2($hostname);
if (!$ssh->login('remote', $accesskey)) {
exit('System is under maintenance.');
}

$status = checkConsole($ctid, $nodeid);
if ($status == "enabled") {
$execute = trim($ssh->exec('/usr/bin/sudo /sbin/containermanager serialconsole ' . $ctid . ' 0'));
} else {
$execute = $ssh->exec('/usr/bin/sudo /sbin/containermanager serialconsole ' . $ctid . ' 1');
}
return $execute;
}

function getTemplates($nodeid){
include('db.php');

$nodedata = getNodeData($nodeid);
$hostname = $nodedata['hostname'];
$accesskey = $nodedata['accesskey'];

$ssh = new Net_SSH2($hostname);
if (!$ssh->login('remote', $accesskey)) {
exit('System is under maintenance.');
}

$arr = explode("\n", trim($ssh->exec('/usr/bin/sudo /sbin/get_available_templates')));
return $arr;
}

function getPowerLevel($ctid, $nodeid){
include('db.php');

$nodedata = getNodeData($nodeid);
$hostname = $nodedata['hostname'];
$accesskey = $nodedata['accesskey'];

$ssh = new Net_SSH2($hostname);
if (!$ssh->login('remote', $accesskey)) {
exit('System is under maintenance.');
}

$var = trim($ssh->exec('/usr/bin/sudo /sbin/containermanager status ' . $ctid));
if (strpos($var, 'Online') !== false){

echo '<a href="" disabled="" class="btn btn-default"> <span class="status-light sl-green"> </span> ONLINE';
} else {
echo '<a href="" disabled="" class="btn btn-default"> <span class="status-light sl-red"> </span> OFFLINE';

}

}

function status($ctid, $nodeid){
include('db.php');

$nodedata = getNodeData($nodeid);
$hostname = $nodedata['hostname'];
$accesskey = $nodedata['accesskey'];

$ssh = new Net_SSH2($hostname);
if (!$ssh->login('remote', $accesskey)) {
exit('System is under maintenance.');
}

$var = trim($ssh->exec('/usr/bin/sudo /sbin/containermanager status ' . $ctid));
if (strpos($var, 'Online') !== false){

#echo '<a href="" disabled="" class="btn btn-default"> <span class="status-light sl-green"> </span> ONLINE';
$statusmsg = 'true';
} else {
#echo '<a href="" disabled="" class="btn btn-default"> <span class="status-light sl-red"> </span> OFFLINE';
$statusmsg = 'false';

}
return $statusmsg;
}


function getDisk($ctid, $nodeid){
include('db.php');

$nodedata = getNodeData($nodeid);
$hostname = $nodedata['hostname'];
$accesskey = $nodedata['accesskey'];

$ssh = new Net_SSH2($hostname);
if (!$ssh->login('remote', $accesskey)) {
exit('System is under maintenance.');
}

return trim($ssh->exec('/usr/bin/sudo /sbin/containermanager diskusage ' . $ctid));
}

function getos ($ctid, $nodeid){
include('db.php');

$nodedata = getNodeData($nodeid);
$hostname = $nodedata['hostname'];
$accesskey = $nodedata['accesskey'];

$ssh = new Net_SSH2($hostname);
if (!$ssh->login('remote', $accesskey)) {
exit('System is under maintenance.');
}



return trim($ssh->exec('/usr/bin/sudo /sbin/containermanager getos ' . $ctid));

}

function checktun ($ctid, $nodeid){
include('db.php');

$nodedata = getNodeData($nodeid);
$hostname = $nodedata['hostname'];
$accesskey = $nodedata['accesskey'];

$ssh = new Net_SSH2($hostname);
if (!$ssh->login('remote', $accesskey)) {
exit('System is under maintenance.');
}

return trim($ssh->exec('/usr/bin/sudo /sbin/containermanager checktun ' . $ctid));

}

function enabletun ($ctid, $nodeid){
include('db.php');

$nodedata = getNodeData($nodeid);
$hostname = $nodedata['hostname'];
$accesskey = $nodedata['accesskey'];

$ssh = new Net_SSH2($hostname);
if (!$ssh->login('remote', $accesskey)) {
exit('System is under maintenance.');
}

return trim($ssh->exec('/usr/bin/sudo /sbin/containermanager tuntap ' . $ctid . ' 1'));

}

function disabletun ($ctid, $nodeid){
include('db.php');

$nodedata = getNodeData($nodeid);
$hostname = $nodedata['hostname'];
$accesskey = $nodedata['accesskey'];

$ssh = new Net_SSH2($hostname);
if (!$ssh->login('remote', $accesskey)) {
exit('System is under maintenance.');
}

return trim($ssh->exec('/usr/bin/sudo /sbin/containermanager tuntap ' . $ctid . ' 0'));

}

function poweron($ctid, $nodeid){
include('db.php');

$nodedata = getNodeData($nodeid);
$hostname = $nodedata['hostname'];
$accesskey = $nodedata['accesskey'];

$ssh = new Net_SSH2($hostname);
if (!$ssh->login('remote', $accesskey)) {
exit('System is under maintenance.');
}

return trim($ssh->exec('/usr/bin/sudo /sbin/containermanager start ' . $ctid));
}

function poweroff($ctid, $nodeid){
include('db.php');

$nodedata = getNodeData($nodeid);
$hostname = $nodedata['hostname'];
$accesskey = $nodedata['accesskey'];

$ssh = new Net_SSH2($hostname);
if (!$ssh->login('remote', $accesskey)) {
exit('System is under maintenance.');
}

return trim($ssh->exec('/usr/bin/sudo /sbin/containermanager stop ' . $ctid));
}

function reboot($ctid, $nodeid){
include('db.php');

$nodedata = getNodeData($nodeid);
$hostname = $nodedata['hostname'];
$accesskey = $nodedata['accesskey'];

$ssh = new Net_SSH2($hostname);
if (!$ssh->login('remote', $accesskey)) {
exit('System is under maintenance.');
}

return trim($ssh->exec('/usr/bin/sudo /sbin/containermanager restart ' . $ctid));
}


function reinstall($ctid, $os, $nodeid){
include('db.php');

$nodedata = getNodeData($nodeid);
$hostname = $nodedata['hostname'];
$accesskey = $nodedata['accesskey'];

$ssh = new Net_SSH2($hostname);
if (!$ssh->login('remote', $accesskey)) {
exit('System is under maintenance.');
}

$formattedos = str_replace(".tar.gz","",$os);

$act = trim($ssh->exec('/usr/bin/sudo /sbin/containermanager reinstall ' . $ctid . ' ' . $formattedos));
trim($ssh->exec('/usr/bin/sudo /sbin/containermanager net-init ' . $ctid));

return $act;

}

function memoryusage($ctid, $nodeid){
include('db.php');

$nodedata = getNodeData($nodeid);
$hostname = $nodedata['hostname'];
$accesskey = $nodedata['accesskey'];

$ssh = new Net_SSH2($hostname);
if (!$ssh->login('remote', $accesskey)) {
exit('System is under maintenance.');
}

return trim($ssh->exec('/usr/bin/sudo /sbin/containermanager memusage ' . $ctid));
}

function setResources($ctid, $nodeid, $ram, $cpu, $cpu_units, $disk, $swap){
include('db.php');

$nodedata = getNodeData($nodeid);
$hostname = $nodedata['hostname'];
$accesskey = $nodedata['accesskey'];

$ssh = new Net_SSH2($hostname);
if (!$ssh->login('remote', $accesskey)) {
exit('System is under maintenance.');
}
return $ssh->exec('/usr/bin/sudo /usr/sbin/vzctl set ' . $ctid . ' --ram ' . $ram . 'M --swap  ' . $swap . 'M --cpus ' . $cpu . ' --cpuunits ' . $cpu_units . ' --diskspace ' . $disk . 'G:' . $disk . ' --save');
}

function updateResources($ctid, $nodeid, $ram, $cpu, $cpu_units, $disk, $swap){

include('db.php');

$nodedata = getNodeData($nodeid);
$hostname = $nodedata['hostname'];
$accesskey = $nodedata['accesskey'];

$ssh = new Net_SSH2($hostname);
if (!$ssh->login('remote', $accesskey)) {
exit('System is under maintenance.');
}

$query = '/usr/bin/sudo /usr/sbin/vzctl set ' . $ctid;

if ($ram !== null) {
$query .= ' --ram ' . $ram . 'M';
}

if ($cpu !== null) {
$query .= ' --cpus ' . $cpu;
}

if ($cpu_units !== null) {
$query .= ' --cpuunits ' . $cpu_units;
}

if ($disk !== null) {
$query .= ' --diskspace ' . $disk . 'G:' . $disk .'G';
}

if ($swap !== null) {
$query .= ' --swap ' . $swap . 'M';
}

$query .= ' --save';

return $ssh->exec($query);

}

function resetpass($ctid, $nodeid){
include('db.php');

$nodedata = getNodeData($nodeid);
$hostname = $nodedata['hostname'];
$accesskey = $nodedata['accesskey'];

$ssh = new Net_SSH2($hostname);
if (!$ssh->login('remote', $accesskey)) {
exit('System is under maintenance.');
}

return $ssh->exec('/usr/bin/sudo /sbin/containermanager resetpass ' . $ctid);
}

function destroy($ctid, $nodeid){
include('db.php');

$nodedata = getNodeData($nodeid);
$hostname = $nodedata['hostname'];
$accesskey = $nodedata['accesskey'];

$ssh = new Net_SSH2($hostname);
if (!$ssh->login('remote', $accesskey)) {
exit('System is under maintenance.');
}

return $ssh->exec('/usr/bin/sudo /sbin/containermanager destroy ' . $ctid);
}


?>
