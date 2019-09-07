<?php
include_once 'includes/functions.php';
include_once 'includes/db_functions.php';
sec_session_start();
?>

<link type="text/css" rel="stylesheet" href="style.css">
<html>
  <head> 
    <title>LoL Dream Team</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script type="text/javascript" style="margin:0 auto;" src="jscharts.js"></script>
  </head>
  <body> 
  <div id="header">
    <a href="./index.html">LoL Dream Team</a>
  </div>
  <div id="menu">
    <a href="./login_form.php" 
       style="float:left; margin-right:10px;">Team Login</a>
    <a href="./register.php"
       style="float:left; margin-right:10px;">Team Register</a>
    <a href="./teamProfile.php"
       style="float:left; margin-right:10px; text-decoration:underline;">Team Profile</a>
    <a href="./teamApplicants.php" 
       style="float:left; margin-right:10px;">Team Applicants</a>

    <a href="./userSearch.html"
       style="float:right; margin-left:10px;">Find a Team</a>
    <p style="display:inline; color:#997F3D;">|</p>
  </div>
  <div id="content">
    <?php 
      function printMembers($conn, $members){
        foreach($members as $key => $member){
          $summonerId = $member['summoner_id'];
          $summoner = getSummoner($conn, $summonerId);
          $name = $summoner['name'];
          $roleId = $summoner['role_id'];
          $role = getPrettyRoleName($conn, $roleId);
          $num_matches = $summoner['num_matches'];
          $memberStr = '<div id="item">';
          $memberStr .= '<b>' . $name . '</b>';
          $memberStr .= ' Main Role: ' . $role;
          $memberStr .= '</div>';
          echo $memberStr;
        }
      }

      function printOpenings($conn, $openings){
        foreach($openings as $key => $opening){
          $openingId = $opening['id'];
          $roleId = $opening['role_id'];
          $role = getPrettyRoleName($conn, $roleId);
          $str = '<div id="item">';
          $str .= $role;
          $str .= '</div>';
          echo $str;
        }
      }

      function setPlayDays($conn, $members){
        foreach($members as $key => $member){
          $summonerId = $member['summoner_id'];
          $playDays = getPlayDays($conn, $summonerId);
          $teamPlaydays = [];
          foreach($playDays as $key => $value){
            $teamPlayDays[$key] += $value;
          }
        }
   
        //$str =  '<div id="item">';
        foreach($teamPlayDays as $key => $value){
          echo '<div id="' . $key . '" value="' . $value . '"></div>';
          //$str .= $key . ': ' . $value . ', ';
        }
        //$str .= '</div>';
        //echo $str;
      }
      if(login_check($conn) == true){
        $teamName = $_SESSION['name'];
        $teamId = getTeamId($conn, $teamName);
        $description = getTeamDescription($conn, $teamId);
        $members = getTeamMembers($conn, $teamId);
        $openings = getTeamOpenings($conn, $teamId);
        echo '<div id="header2">Team Profile for: ';
        echo $teamName . " ";
        echo '</div>';
        echo '<div id="header3">Description:</div>';
        echo '<div id="list"><div id="item">';
        echo $description;
        echo '</div></div>';

        echo '<div id="header3">Players:</div>';
        echo '<div id="list"><div id="item">';
        printMembers($conn, $members);
        echo '</div></div>';

        echo '<div id="header3">Openings:</div>';
        echo '<div id="list"><div id="item">';
        printOpenings($conn, $openings);
        echo '</div></div>';

        echo '<div id="header3">Ranked Matches by Day:</div>';
        echo '<div id="list"><div id="item">';
        setPlayDays($conn, $members);
        echo '</div></div>';
    
        echo '<div id="profileDayGraph"></div>';
        echo '<script type="text/javascript" style="margin:0 auto;" src="teamProfileBars.js">';
        echo '</script>';
      }
      else{
        echo 'You must log in before viewing your profile.';
      }
    ?>

  </div>
  </body> 
</html>
