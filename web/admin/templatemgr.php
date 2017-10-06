<?php
session_start();
include 'auth.php';
include 'db.php';

if (!empty($_GET['node'])){
$checknode = $dbh->prepare('SELECT * from nodes where id=:hostname');
$checknode->bindParam(':hostname', $_GET['node']);
$checknode->execute();

if (!$checknode->rowCount() > 0){
header('Location: /vpscp/admin/templatemgr.php');
}
}

include 'header.php';
include 'functions.php';

echo '<div class="container">';

if (empty($_GET['node'])){
$sqlstatement = 'SELECT * FROM nodes';
$result = $dbh->query($sqlstatement);
echo '<h1>Template Manager</h1>';
echo '<h4>Please select a node to manage</h4>';
echo '<br /><br />';
?>
<div class="row">
<div class="col col-md-4">
<form action="templatemgr.php" method="GET" id="nodeform">
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
</div>
</div>
<?php
} else {

if ($_GET['act'] == "dl") {
echo '<h1>Template Manager <a href="templatemgr.php?node='.$_GET['node'].'" class="btn btn-danger">Cancel</a></h1>';
} else {
echo '<h1>Template Manager <a href="templatemgr.php?node='.$_GET['node'].'&act=dl" class="btn btn-success">Download Template</a></h1>';
}
echo '<hr>';

if ($_GET['act'] == "delete" && !empty($_GET['template'])){
$formattedos = str_replace(".tar.gz", "", $_GET['template']);
$deletetemplate = deleteTemplate($formattedos, $_GET['node']);
if (strpos($deletetemplate, 'does not') !== false) {
echo '<div class="alert alert-danger"><b>Error: </b>Template does not exist.</div>';
} else {
echo '<div class="alert alert-success"><b>Success: </b>Template '.$_GET['template'].' removed.</div>';
}
}
?>
<table class="table table-bordered table-hover">
<thead>
<tr>
<th>Template name</th>
<th>Actions</th>
</tr>
</thead>
<tbody>
<?php
$templates = getTemplates($_GET['node']);
foreach ($templates as $row) {
echo '<tr>';
echo '<td>'.$row.'</td>';
echo '<td><a href="templatemgr.php?node='.$_GET['node'].'&act=delete&template='.$row.'" class="btn btn-danger">Remove</a></td>';
echo '</tr>';
}
?>
</tbody>
</table>

<?php if ($_GET['act'] == "dl") { ?>
<br />
<hr>
<h3>Download template</h3>
<br />
<?php 
if (!empty($_POST['location']) && !empty($_POST['saveas'])){ 

$err = 0;

$ch = curl_init($_POST['location']);

curl_setopt($ch, CURLOPT_NOBODY, true);
curl_exec($ch);
$retcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
// $retcode >= 400 -> not found, $retcode = 200, found.

if ($retcode >= 400) {
$err = 1;
$msg = '<div class="alert alert-danger"><b>Invalid template location.</b></div>';
}

curl_close($ch);

if(preg_match('/[^a-z_\-0-9]/i', $_POST['saveas'])){
$err = 1;
$msg = '<div class="alert alert-danger"><b>The template name must be alphanumeric with dashes.</b></div>';
}

if ($err == 0){
$data = '<pre>'.downloadTemplate($_POST['location'], $_POST['saveas'], $_GET['node']).'</pre>';
} else {
$data = $msg;
}

echo $data;

echo '<a href="templatemgr.php?node='.$_GET['node'].'" class="btn btn-primary">Refresh templates</a><br /><br />';

}
?>
<form action="templatemgr.php?node=<?php echo $_GET['node']; ?>&act=dl" method="POST">
<label>Template location (templates are available at <a href="https://openvz.org/Download/template/precreated">https://openvz.org/Download/template/precreated</a>)</label>
<input type="url" name="location" class="form-control" placeholder="Location of tarball...">
<br />
<label>Save as...</label>
<input type="text" name="saveas" class="form-control" placeholder="Template name (users will see this as a usable template)">
<br />
<input type="submit" class="btn btn-success btn-block" value="Download template">
</form>
<?php } ?>

<?php } ?>



