<!DOCTYPE html> 
<html>
  <head>
    <title>natCP</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Lato:300|Josefin+Sans:300|Source+Sans+Pro" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    </script>
    <link href="assets/login.css" rel="stylesheet">
 <!--   <script src="assets/newlogin.js"></script> -->
    <link href="assets/new.css" rel="stylesheet">
  
 </head>
  <body>
    <div class="container">
      <h2 class="header" style="color: white;">
       Server missionControl
      </h2>
      <div class="col-md-4 col-md-offset-4">

<?php
// show potential errors / feedback (from login object)
if (isset($login)) {
    if ($login->errors) {
	echo '<br />';
        foreach ($login->errors as $error) {
         $btn = $error;
       }
    }
    if ($login->messages) {
        echo '<br />';
        foreach ($login->messages as $message) {
            $btn = $message;
        }
    }
}

if(empty($error) and empty($message)) {
$btn = "LOG IN";
}
?>

        <form method="post" id="authenticate" action="index.php">
          <div id="returnmsg">
          </div>
          <div class="sp">
          </div>
          <input type="text" id="username" placeholder="Username" name="user_name" value="" class="form-control input-lg">
          <div class="sp">
          </div>
          <input type="password" id="password" placeholder="Password" name="user_password" class="form-control input-lg">
          <div class="spp">
          <input type="submit" name="login" value="<?php print($btn); ?>" class="btn btn-default btn-login input-lg btn-block" style="text-transform: uppercase;">
          <div class="sp">
          </div>
        </form>
        <form method="post" id="links">
          <div class="footerlink">
            <a href="mailto:andrew@andrew-hong.me" class="footerlink">NEED ASSISTANCE?
            
          </div>
          </div>
       </div>
      </body>
    </html>
