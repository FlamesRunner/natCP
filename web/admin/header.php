<!DOCTYPE html>
<html>
   <head>
      <title>natCP</title>
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
      <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
      <link href="style.css" rel="stylesheet">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <script type="text/javascript">$(document).ready(function(){$('select').niceSelect()})</script>
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
         <li><a style="color:white;" href="/admin">Admin Home</a></li>
         <li><a style="color:white;" href="/admin/listvps.php">Virtual Servers</a></li>
         <li><a style="color:white;" href="/admin/usermanager.php">User Manager</a></li>
         <li><a style="color:white;" href="/admin/nodemanager.php">Node Manager</a>
         <li><a style="color:white;" href="/admin/templatemgr.php">Template Manager</a></li>
         <li><a style="color:white;" href="/manager">Return to userCP</a></li>
               <span id="navmsg"></span>
            </ul>
         </div>
      </nav>

 <div class="modal fade" id="messagemodal" role="dialog">
    <div class="modal-dialog">
    
      <div class="modal-content">
        <div class="modal-body">
    <center>
         <br>
          <span id="message"></span>
          <br>
   </center>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default btn-block" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
  </div>

<div data-keyboard="false" data-backdrop="static" class="modal fade" id="loading" role="dialog">
    <div class="modal-dialog">
   <div class="modal-content">
<div class="modal-body">
        <center>
          <br>
           <i class="fa fa-refresh fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span>
           <h1><span id="whichaction">(action)</span></h1>
           <span>Hang tight - we're processing your request! :)</span>
          <br><br>
        </center>
      </div>
       </div>

    </div>
  </div>

