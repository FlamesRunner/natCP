<?php
include('Net/SSH2.php');
include('config.php');

function getPowerLevel($ctid) {
$ssh = new Net_SSH2(NODE_IP);
if (!$ssh->login(NODE_USERNAME, NODE_PASSWORD)) {
    exit('System failiure. Please contact support.');
}

$var = trim($ssh->exec('/usr/bin/sudo /sbin/containermanager status ' . $ctid));
if (strpos($var, 'Online') !== false){
echo '<td><span class="label label-success">Online</span></td>';
} else {
echo '<td><span class="label label-danger">Offline</span></td>';
}

}

function destroyContainer($ctid){
$ssh = new Net_SSH2(NODE_IP);
if (!$ssh->login(NODE_USERNAME, NODE_PASSWORD)) {
    exit('System failiure. Please contact support.');
}
return trim($ssh->exec('/usr/bin/sudo /sbin/containermanager destroy '.$ctid));
}

function checkCTID($ctid){
$ssh = new Net_SSH2(NODE_IP);
if (!$ssh->login(NODE_USERNAME, NODE_PASSWORD)) {
    exit('System failiure. Please contact support.');
}

return trim($ssh->exec('/usr/bin/sudo /sbin/containermanager status '.$ctid));
}

function createContainer($ctid, $os){
$ssh = new Net_SSH2(NODE_IP);
if (!$ssh->login(NODE_USERNAME, NODE_PASSWORD)) {
    exit('System failiure. Please contact support.');
}

$create = trim($ssh->exec('/usr/bin/sudo /sbin/containermanager create '.$ctid.' '.$os));
$netinit = trim($ssh->exec('/usr/bin/sudo /sbin/containermanager net-init '.$ctid));
return '1';

}


function getTemplates(){
$ssh = new Net_SSH2(NODE_IP);
if (!$ssh->login(NODE_USERNAME, NODE_PASSWORD)) {
    exit('System failiure. Please contact support.');
}

return trim($ssh->exec('/usr/bin/sudo /sbin/get_available_templates'));
}

function getDisk($ctid){
$ssh = new Net_SSH2(NODE_IP);
if (!$ssh->login(NODE_USERNAME, NODE_PASSWORD)) {
    exit('System failiure. Please contact support.');
}

return trim($ssh->exec('/usr/bin/sudo /sbin/containermanager diskusage ' . $ctid));
}

function getos ($ctid) {

$ssh = new Net_SSH2(NODE_IP);
if (!$ssh->login(NODE_USERNAME, NODE_PASSWORD)) {
    exit('System failiure. Please contact support.');
}

return trim($ssh->exec('/usr/bin/sudo /sbin/containermanager getos ' . $ctid));

}

function checktun ($ctid) {

$ssh = new Net_SSH2(NODE_IP);
if (!$ssh->login(NODE_USERNAME, NODE_PASSWORD)) {
    exit('System failiure. Please contact support.');
}

return trim($ssh->exec('/usr/bin/sudo /sbin/containermanager checktun ' . $ctid));

}

function enabletun ($ctid) {

$ssh = new Net_SSH2(NODE_IP);
if (!$ssh->login(NODE_USERNAME, NODE_PASSWORD)) {
    exit('System failiure. Please contact support.');
}

return trim($ssh->exec('/usr/bin/sudo /sbin/containermanager tuntap ' . $ctid . ' 1'));

}

function disabletun ($ctid) {

$ssh = new Net_SSH2(NODE_IP);
if (!$ssh->login(NODE_USERNAME, NODE_PASSWORD)) {
    exit('System failiure. Please contact support.');
}

return trim($ssh->exec('/usr/bin/sudo /sbin/containermanager tuntap ' . $ctid . ' 0'));

}

function poweron($ctid) {

$ssh = new Net_SSH2(NODE_IP);
if (!$ssh->login(NODE_USERNAME, NODE_PASSWORD)) {
    exit('System failiure. Please contact support.');
}

return trim($ssh->exec('/usr/bin/sudo /sbin/containermanager start ' . $ctid));
}

function poweroff($ctid) {

$ssh = new Net_SSH2(NODE_IP);
if (!$ssh->login(NODE_USERNAME, NODE_PASSWORD)) {

    exit('System failiure. Please contact support.');
}
return trim($ssh->exec('/usr/bin/sudo /sbin/containermanager stop ' . $ctid));
}

function reboot($ctid) {
$ssh = new Net_SSH2(NODE_IP);
if (!$ssh->login(NODE_USERNAME, NODE_PASSWORD)) {
    exit('System failiure. Please contact support.');
}
return trim($ssh->exec('/usr/bin/sudo /sbin/containermanager restart ' . $ctid));
}


function reinstall($ctid, $os) {
$ssh = new Net_SSH2(NODE_IP);
if (!$ssh->login(NODE_USERNAME, NODE_PASSWORD)) {
    exit('System failiure. Please contact support.');
}

$act = trim($ssh->exec('/usr/bin/sudo /sbin/containermanager reinstall ' . $ctid . ' ' . $os));
trim($ssh->exec('/usr/bin/sudo /sbin/containermanager net-init ' . $ctid));

return $act;

}

function memoryusage($ctid) {
$ssh = new Net_SSH2(NODE_IP);
if (!$ssh->login(NODE_USERNAME, NODE_PASSWORD)) {
    exit('System failiure. Please contact support.');
}

return trim($ssh->exec('/usr/bin/sudo /sbin/containermanager memusage ' . $ctid));
}

function resetpass($ctid) {
$ssh = new Net_SSH2(NODE_IP);
if (!$ssh->login(NODE_USERNAME, NODE_PASSWORD)) {
    exit('System failiure. Please contact support.');
}

return $ssh->exec('/usr/bin/sudo /sbin/containermanager resetpass ' . $ctid);
}

?>
