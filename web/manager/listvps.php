<?php
session_start();
include 'auth.php';
include 'db.php';
include 'header.php';
include 'functions.php';

//$ath = $dbh->prepare('SELECT * from virtualservers where owner=:username');
//$ath->bindParam(":username", $_SESSION['user_name']);
//$ath->execute();
?>
<div class="container">
<h1>Virtual Servers <span style="font-size: 15px;"><a id="reload"><span class="glyphicon glyphicon-repeat"></span></a></span></h1>


<script>
$( document ).ready(function() {
    console.log( "Requesting VPS list..." );

function list() {    
$( "#vps" ).load( "ajaxfunctions.php?a=listvps" );
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
