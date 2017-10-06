<?php
include 'db.php';
include 'functions.php';

$apikey = '1879163436749685193858109294104779693172';

if ($_GET['apikey'] == $apikey) {
} else {
die('Access denied');
}

function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

if ($_GET['act'] == "createvps" && !empty($_GET['serviceid']) && !empty($_GET['email'])){
// Create user

$serviceid= $_GET['serviceid'] + 100;

$sql = 'INSERT INTO users (user_name, user_password_hash, user_email) VALUES (:username, :password, :email)';
$adduser = $dbh->prepare($sql);
$adduser->bindParam(':username', $_GET['email']);
$newpassword = generateRandomString(16);
$adduser->bindParam(':password', password_hash($newpassword, PASSWORD_DEFAULT));
$adduser->bindParam(':email', $_GET['email']);
$adduser->execute();

// Add virtual server

$output = createContainer($serviceid, 'debian-7', '4');
$changerootpassword = trim(resetpass($serviceid, '4'));
$sql2 = 'INSERT INTO virtualservers (ctid, owner, status, nodeid) VALUES (:ctid, :owner, "active", 4)';
$addcontainer = $dbh->prepare($sql2);
$addcontainer->bindParam(':ctid', $serviceid);
$addcontainer->bindParam(':owner', $_GET['email']);
$addcontainer->execute();

// Done. Return the data to WHMCS

$returnthis = array(
	"ctid" => $serviceid,
	"userpassword" => $newpassword,
	"rootpassword" => $changerootpassword
);

echo json_encode($returnthis);

} else {

}
?>
