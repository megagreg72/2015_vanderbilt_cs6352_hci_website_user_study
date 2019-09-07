<?php
include_once 'includes/functions.php';
include_once 'includes/db_functions.php';
sec_session_start();
?>

<link type="text/css" rel="stylesheet" href="style.css">
<html>
  <head> 
    <title>LoL Dream Team</title>
  </head> 
  <body> 
  <div id="header">
    LoL Dream Team
  </div>
  <div id="menu">
    <a href="./index.html">Home</a> |
    <a href="./teamApplicants.php">Back</a>
  </div>
  <div id="content">
    <?php 
      if(login_check($conn) == true){
        $teamName = $_SESSION['name'];
        $teamId = getTeamId($conn, $teamName);
        if(isset ($_POST['application_id'])){
          $applicationId = $_POST['application_id'];
          // TODO send a notification of rejection first?
          removeApplication($conn, $applicationId);

          echo '<div id="header2">Application Rejected</div>';
        }
        else{
          echo 'Oops! You should not access this page this way.';
        }
      }
      else{
        echo 'You must be logged in to use this page.';
      }
    ?>
  </div>
  </body> 
</html>
