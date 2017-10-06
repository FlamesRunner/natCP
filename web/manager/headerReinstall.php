<!DOCTYPE html>
<html>
<head>
<title>natCP</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet"> 
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
@import url('https://fonts.googleapis.com/css?family=Montserrat');
@import 'https://fonts.googleapis.com/css?family=Open+Sans';
.col-centered{
    float: none;
    margin: 0 auto;
}
.table-nonfluid {
   width: auto !important;
}
.checkbox-slider--b-flat {
  position: relative;
}
.checkbox {
margin-bottom: 0px;
}
.code {
    background-color: #000;
color: white;
    border-radius: 3px;
font-family: monospace,monospace; 
margin-bottom: 0px;
    
}
.checkbox-slider--b-flat input {
  display: block;
  position: absolute;
  top: 0;
  right: 0;
  bottom: 0;
  left: 0;
  width: 0%;
  height: 0%;
  margin: 0 0;
  cursor: pointer;
  opacity: 0;
  filter: alpha(opacity=0);
}
.checkbox-slider--b-flat input + span {
  cursor: pointer;
  -webkit-user-select: none;
     -moz-user-select: none;
      -ms-user-select: none;
          user-select: none;
}
.checkbox-slider--b-flat input + span:before {
  position: absolute;
  left: 0px;
  display: inline-block;
}
.checkbox-slider--b-flat input + span > h4 {
  display: inline;
}
.checkbox-slider--b-flat input + span {
  padding-left: 40px;
}
.checkbox-slider--b-flat input + span:before {
  content: "";
  height: 20px;
  width: 40px;
  background: rgba(100, 100, 100, 0.2);
  box-shadow: inset 0 0 5px rgba(0, 0, 0, 0.8);
  transition: background 0.2s ease-out;
}
.checkbox-slider--b-flat input + span:after {
  width: 20px;
  height: 20px;
  position: absolute;
  left: 0px;
  top: 0;
  display: block;
  background: #ffffff;
  transition: margin-left 0.1s ease-in-out;
  text-align: center;
  font-weight: bold;
  content: "";
}
.checkbox-slider--b-flat input:checked + span:after {
  margin-left: 20px;
  content: "";
}
.checkbox-slider--b-flat input:checked + span:before {
  transition: background 0.2s ease-in;
}
.checkbox-slider--b-flat input + span {
  padding-left: 40px;
}
.checkbox-slider--b-flat input + span:before {
  border-radius: 20px;
  width: 40px;
}
.checkbox-slider--b-flat input + span:after {
  background: #ffffff;
  content: "";
  width: 20px;
  border: solid transparent 2px;
  background-clip: padding-box;
  border-radius: 20px;
}
.checkbox-slider--b-flat input:not(:checked) + span:after {
  -webkit-animation: popOut ease-in 0.3s normal;
          animation: popOut ease-in 0.3s normal;
}
.checkbox-slider--b-flat input:checked + span:after {
  content: "";
  margin-left: 20px;
  border: solid transparent 2px;
  background-clip: padding-box;
  -webkit-animation: popIn ease-in 0.3s normal;
          animation: popIn ease-in 0.3s normal;
}
.checkbox-slider--b-flat input:checked + span:before {
  background: #5cb85c;
}
.checkbox-slider--b-flat.checkbox-slider-md input + span:before {
  border-radius: 30px;
}
.checkbox-slider--b-flat.checkbox-slider-md input + span:after {
  border-radius: 30px;
}
.checkbox-slider--b-flat.checkbox-slider-lg input + span:before {
  border-radius: 40px;
}
.checkbox-slider--b-flat.checkbox-slider-lg input + span:after {
  border-radius: 40px;
}
.checkbox-slider--b-flat input + span:before {
  box-shadow: none;
}

/*#####*/
.checkbox-slider-info.checkbox-slider--b input:checked + span:before,
.checkbox-slider-info.checkbox-slider--b-flat input:checked + span:before,
.checkbox-slider-info.checkbox-slider--c input:checked + span:before,
.checkbox-slider-info.checkbox-slider--c-weight input:checked + span:before {
  background: #5bc0de;
}

.checkbox-slider-warning.checkbox-slider--b input:checked + span:before,
.checkbox-slider-warning.checkbox-slider--b-flat input:checked + span:before,
.checkbox-slider-warning.checkbox-slider--c input:checked + span:before,
.checkbox-slider-warning.checkbox-slider--c-weight input:checked + span:before {
  background: #f0ad4e;
}

.checkbox-slider-danger.checkbox-slider--b input:checked + span:before,
.checkbox-slider-danger.checkbox-slider--b-flat input:checked + span:before,
.checkbox-slider-danger.checkbox-slider--c input:checked + span:before,
.checkbox-slider-danger.checkbox-slider--c-weight input:checked + span:before {
  background: #d9534f;
}

/*******************************************************
Sizes
*******************************************************/
.checkbox-slider-sm {
  line-height: 10px;
}
.checkbox-slider-sm input + span {
  padding-left: 20px;
}
.checkbox-slider-sm input + span:before {
  width: 20px;
}
.checkbox-slider-sm input + span:after,
.checkbox-slider-sm input + span:before {
  height: 10px;
  line-height: 10px;
}
.checkbox-slider-sm input + span:after {
  width: 10px;
  vertical-align: middle;
}
.checkbox-slider-sm input:checked + span:after {
  margin-left: 10px;
}
.checkbox-slider-md {
  line-height: 30px;
}
.checkbox-slider-md input + span {
  padding-left: 60px;
}
.checkbox-slider-md input + span:before {
  width: 60px;
}
.checkbox-slider-md input + span:after,
.checkbox-slider-md input + span:before {
  height: 30px;
  line-height: 30px;
}
.checkbox-slider-md input + span:after {
  width: 30px;
  vertical-align: middle;
}
.checkbox-slider-md input:checked + span:after {
  margin-left: 30px;
}
.checkbox-slider-lg {
  line-height: 40px;
}
.checkbox-slider-lg input + span {
  padding-left: 80px;
}
.checkbox-slider-lg input + span:before {
  width: 80px;
}
.checkbox-slider-lg input + span:after,
.checkbox-slider-lg input + span:before {
  height: 40px;
  line-height: 40px;
}
.checkbox-slider-lg input + span:after {
  width: 40px;
  vertical-align: middle;
}
.checkbox-slider-lg input:checked + span:after {
  margin-left: 40px;
}
.modal-open {overflow: initial;}
@media (max-width: 768px) {
    .btn {
        width: 100%;
    }
}
@media (max-width: 768px) {
 .grouped {
  padding-top: 10px;
  width: 100%;
  float: left;
}
}

 @media (min-width: 769px) {
 .grouped {
  float: right;
}
}
.status-light {
    margin: 5px 10px;
    margin-left: 0px;
    margin-right: 5px;
    width: 10px;
    height: 10px;
    border-radius: 50%;
    float: left;
}

.sl-red {
    background-color: #940;
    box-shadow: @_base-shadow, inset #600 0 -1px 9px, #F00 0 @bottom-bleed @aura-radius;
}

.sl-green {
margin-top: 5px;
    background-color: green;
    box-shadow: @_base-shadow, inset #460 0 -1px 9px, #7D0 0 @bottom-bleed @aura-radius;
}
.sl-grey {
margin-top: 5px;
    background-color: lightgrey;
    box-shadow: @_base-shadow, inset #460 0 -1px 9px, #7D0 0 @bottom-bleed @aura-radius;
}


body {
padding-top: 90px;
font-family: 'Montserrat', sans-serif;
padding-bottom: 90px;
}
.navbar {
font-family: 'Open Sans', serif;
background-color: #00bfff;
    padding-top: 6px;
    height: 60px;
    color: white;
    -webkit-box-shadow: 0 1px 2px rgba(0,0,0,.3);
    box-shadow: 0 1px 2px rgba(0,0,0,.3);
    border-color: transparent;
}
#table{
#  width:100%;
#  table-layout: fixed;
#}

#.tbl-content{
#  height:300px;
#  overflow-x:auto;
#  margin-top: 0px;
#  border: 1px solid rgba(255,255,255,0.3);
#}
#th{
#  padding: 20px 15px;
#  text-align: left;
#  font-weight: 500;
#  font-size: 12px;
#  color: #fff;
#  text-transform: uppercase;
#}
#td{
  #padding: 15px;
  #text-align: left;
  #vertical-align:middle;
  #font-weight: 300;
  #font-size: 12px;
  #color: #fff;
 # border-bottom: solid 1px rgba(255,255,255,0.1);
#}
.navbar-nav {
background-color: #00bfff;
}
.navbar-default .navbar-collapse, .navbar-default .navbar-form {
    border-color: #00bfff;
}
.navbar-default .navbar-toggle {
    border-color: transparent;
}
.navbar-default .navbar-toggle .icon-bar {
    background-color: #fff;
}
.navbar-toggle {
background-color: #00bfff;
}

.progress {
height: 20px;
margin-top: 5px;
margin-bottom: 0px;
overflow: hidden;
background-color: #f5f5f5;
border-radius: 360px;
-webkit-box-shadow: inset 0 1px 2px rgba(0,0,0,0.1);
box-shadow: inset 0 1px 2px rgba(0,0,0,0.1);
}
.progress {

background-image: -webkit-gradient(linear,left 0,left 100%,from(#ebebeb),to(#f5f5f5));
background-image: -webkit-linear-gradient(top,#ebebeb 0,#f5f5f5 100%);
background-image: -moz-linear-gradient(top,#ebebeb 0,#f5f5f5 100%);
background-image: linear-gradient(to bottom,#ebebeb 0,#f5f5f5 100%);
background-repeat: repeat-x;
filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#ffebebeb',endColorstr='#fff5f5f5',GradientType=0);
}
.progress {
height: 12px;
background-color: #ebeef1;
background-image: none;
box-shadow: none;
}
.progress-bar {
float: left;
width: 0;
height: 100%;
font-size: 12px;
line-height: 20px;
color: #fff;
text-align: center;
background-color: #428bca;
-webkit-box-shadow: inset 0 -1px 0 rgba(0,0,0,0.15);
box-shadow: inset 0 -1px 0 rgba(0,0,0,0.15);
-webkit-transition: width .6s ease;
transition: width .6s ease;
}
.progress-bar {
background-image: -webkit-gradient(linear,left 0,left 100%,from(#428bca),to(#3071a9));
background-image: -webkit-linear-gradient(top,#428bca 0,#3071a9 100%);
background-image: -moz-linear-gradient(top,#428bca 0,#3071a9 100%);
background-image: linear-gradient(to bottom,#428bca 0,#3071a9 100%);
background-repeat: repeat-x;
filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#ff428bca',endColorstr='#ff3071a9',GradientType=0);
}
.progress-bar {
box-shadow: none;
border-radius: 360px;
background-color: #0090D9;
background-image: none;
-webkit-transition: all 1000ms cubic-bezier(0.785, 0.135, 0.150, 0.860);
-moz-transition: all 1000ms cubic-bezier(0.785, 0.135, 0.150, 0.860);
-ms-transition: all 1000ms cubic-bezier(0.785, 0.135, 0.150, 0.860);
-o-transition: all 1000ms cubic-bezier(0.785, 0.135, 0.150, 0.860);
transition: all 1000ms cubic-bezier(0.785, 0.135, 0.150, 0.860);
-webkit-transition-timing-function: cubic-bezier(0.785, 0.135, 0.150, 0.860);
-moz-transition-timing-function: cubic-bezier(0.785, 0.135, 0.150, 0.860);
-ms-transition-timing-function: cubic-bezier(0.785, 0.135, 0.150, 0.860);
-o-transition-timing-function: cubic-bezier(0.785, 0.135, 0.150, 0.860);
transition-timing-function: cubic-bezier(0.785, 0.135, 0.150, 0.860);
}
.progress-bar-success {
background-image: -webkit-gradient(linear,left 0,left 100%,from(#5cb85c),to(#449d44));
background-image: -webkit-linear-gradient(top,#5cb85c 0,#449d44 100%);
background-image: -moz-linear-gradient(top,#5cb85c 0,#449d44 100%);
background-image: linear-gradient(to bottom,#5cb85c 0,#449d44 100%);
background-repeat: repeat-x;
filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#ff5cb85c',endColorstr='#ff449d44',GradientType=0);
}
.progress-bar-success {
background-color: #0AA699;
background-image: none;
}
.progress-bar-info {
background-image: -webkit-gradient(linear,left 0,left 100%,from(#5bc0de),to(#31b0d5));
background-image: -webkit-linear-gradient(top,#5bc0de 0,#31b0d5 100%);
background-image: -moz-linear-gradient(top,#5bc0de 0,#31b0d5 100%);
background-image: linear-gradient(to bottom,#5bc0de 0,#31b0d5 100%);
background-repeat: repeat-x;
filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#ff5bc0de',endColorstr='#ff31b0d5',GradientType=0);
}
.progress-bar-info {
background-color: #0090D9;
background-image: none;
}
.progress-bar-warning {
background-image: -webkit-gradient(linear,left 0,left 100%,from(#f0ad4e),to(#ec971f));
background-image: -webkit-linear-gradient(top,#f0ad4e 0,#ec971f 100%);
background-image: -moz-linear-gradient(top,#f0ad4e 0,#ec971f 100%);
background-image: linear-gradient(to bottom,#f0ad4e 0,#ec971f 100%);
background-repeat: repeat-x;
filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#fff0ad4e',endColorstr='#ffec971f',GradientType=0);
}
.progress-bar-warning {
background-color: #FDD01C;
background-image: none;
}
.progress-bar-danger {
background-image: -webkit-gradient(linear,left 0,left 100%,from(#d9534f),to(#c9302c));
background-image: -webkit-linear-gradient(top,#d9534f 0,#c9302c 100%);
background-image: -moz-linear-gradient(top,#d9534f 0,#c9302c 100%);
background-image: linear-gradient(to bottom,#d9534f 0,#c9302c 100%);
background-repeat: repeat-x;
filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#ffd9534f',endColorstr='#ffc9302c',GradientType=0);
}
.progress-bar-danger {
background-color: #F35958;
background-image: none;
}
</style>

<?php
if ($_GET['reinstall'] == "true"){
?>
<script>
$('#navmsg').html('<li><a style="color:green;" href="#" id="reinstalltext">Reinstalling...</a></li>');
</script>
<?php
}
?>

</head>
<body style="padding-right: 0px;">
<nav class="navbar navbar-default navbar-fixed-top" role="navigation">

   <div class="navbar-header">
      <button type="button" class="navbar-toggle"
         data-toggle="collapse" data-target="#sys-navbar-collapse">
         <span class="sr-only">Toggle navigation</span>
         <span class="icon-bar" style="color: white;"></span>
         <span class="icon-bar" style="color: white;"></span>
         <span class="icon-bar" style="color: white;"></span>
      </button>

      <a style="color:white;" class="navbar-brand" href="#">natCP</a>
   </div>

   <div class="collapse navbar-collapse" id="sys-navbar-collapse">

      <ul class="nav navbar-nav">
         <li><a style="color:white;" href="/manager">Home</a></li>
         <li><a style="color:white;" href="/manager/listvps.php">Virtual Servers</a></li>
	 <li><a style="color:white;" href="/manager/myaccount.php">My account</a></li>
	 <li><a style="color:white;" href="/?logout">Log Out</a></li>
	 <span id="navmsg"><li><a style="color:green;" href="#" id="reinstalltext">Reinstalling...</a></li></span>
      </ul>
   </div>
</nav>


