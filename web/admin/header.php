<!DOCTYPE html>
<html>
<head>
<title>natCP Administration</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
<style>
@import 'https://fonts.googleapis.com/css?family=Open+Sans';
.col-centered{
    float: none;
    margin: 0 auto;
}
body {
padding-top: 90px;
font-family: 'Open Sans', serif;
}
.navbar {
background-color: #00bfff;
    padding-top: 6px;
    height: 60px;
    color: white;
    -webkit-box-shadow: 0 1px 2px rgba(0,0,0,.3);
    box-shadow: 0 1px 2px rgba(0,0,0,.3);
    border-color: transparent;
}
</style>
</head>
<body>
<nav class="navbar navbar-default navbar-fixed-top" role="navigation">

   <div class="navbar-header">
      <button type="button" class="navbar-toggle"
         data-toggle="collapse" data-target="#sys-navbar-collapse">
         <span class="sr-only">Toggle navigation</span>
         <span class="icon-bar"></span>
         <span class="icon-bar"></span>
         <span class="icon-bar"></span>
      </button>

      <a style="color:white;" class="navbar-brand" href="#">natCP</a>
   </div>

   <div class="collapse navbar-collapse" id="sys-navbar-collapse">

      <ul class="nav navbar-nav">
         <li><a style="color:white;" href="/admin">Home</a></li>
         <li><a style="color:white;" href="/admin/listvps.php">Virtual Servers</a></li>
         <li><a style="color:white;" href="/admin/usermanager.php">User Manager</a></li>
	 <li><a style="color:white;" href="/manager/">Return to userCP</a>
      </ul>
   </div>
</nav>
