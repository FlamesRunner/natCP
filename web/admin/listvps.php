<?php
session_start();
include 'auth.php';
include 'db.php';
include 'header.php';
include 'functions.php';

#$ath = $dbh->prepare('SELECT * from virtualservers where owner=:username');
#$ath->bindParam(":username", $_SESSION['user_name']);
#$ath->execute();

if (empty($_GET['p'])){
$_GET['p'] = "1";
}

$aths = $dbh->prepare('SELECT * from virtualservers');
$aths->execute();
$numOfRows = ceil($aths->rowCount() / 5);

?>
<div class="container">
<h1>Virtual Servers <?php if (isset($_GET['p'])) echo '(page '.$_GET['p'].') '; ?><span style="font-size: 15px;"><a id="reload"><span class="glyphicon glyphicon-repeat"></span></a></span> <a href="addvps.php" class="btn btn-success">Create virtual server</a></h1>
<br />
<form action="search.php" method="GET">
<div class="input-group">
<input type="text" name="searchquery" placeholder="IP address of container..." class="form-control" value="Not implemented yet." disabled>
<span class="input-group-btn">
<input type="submit" class="btn btn-primary" value="Search">
</span>
</div>
</form>
<nav aria-label="Page navigation">
<ul class="pagination">
<li>
<a href="listvps.php?p=<?php echo $_GET['p']-1; ?>" aria-label="">
<span aria-hidden="true">&laquo;</span>
</a>
</li>
<?php
for ($x = 1; $x <= $numOfRows; $x++) {
if ($x == $_GET['p']) {
echo '<li class="active">';
} else {
echo '<li>';
}
echo '<a href="?p='.$x.'">'.$x.'</a></li>';
}
?>
<li>
<a href="listvps.php?p=<?php echo $_GET['p']+1; ?>" aria-label="">
<span aria-hidden="true">&raquo;</span>
</a>
</li>
</ul>
</nav>
<script>
$( document ).ready(function() {
    console.log( "Requesting VPS list..." );

function list() {    
<?php if (isset($_GET['p'])) { ?>
$( "#vps" ).load( "ajaxfunctions.php?a=listvps&pagenum=<?php echo $_GET['p']; ?>" );
<?php } else { ?>
$( "#vps" ).load( "ajaxfunctions.php?a=listvps" );
<?php } ?>
}

list()


$( "#reload" ).click(function() {
console.log('Data update request...');
$( "#vps" ).html( '<div class="panel panel-default"><div class="panel-body"><img src="load.png" alt="load"></div></div>' );

list()
});
});

</script>

<div id="vps">
<div class="panel panel-default">
<div class="panel-body">
<img src="load.png" alt="load">
</div>
</div>
</div>
