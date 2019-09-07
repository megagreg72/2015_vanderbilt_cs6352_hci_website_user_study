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
          $application = getApplication($conn, $applicationId);
          $openingId = $application['opening_id'];
          $summonerId = $application['summoner_id'];
          $summoner = getSummoner($conn, $summonerId);
          $summonerName = $summoner['name'];
          // TODO send a notification of acceptance first?
          insertMember($conn, $teamId, $summonerId);
          removeApplication($conn, $applicationId);
          removeOpening($conn, $openingId);

          echo '<div id="header2">Application Accepted!</div><br>';
          echo '<div id="header2">You should get in contact with ' . $summonerName . ' by friending them in-game.</div>';
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
