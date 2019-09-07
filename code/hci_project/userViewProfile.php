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
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.14.0/jquery.validate.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.14.0/additional-methods.min.js"></script>
    <script type="text/Javascript" src="js/api.js"></script>
    <script type="text/Javascript" src="js/apply.js"></script>
  </head>
  <body> 
  <div id="header">
    <a href="./index.html">LoL Dream Team</a>
  </div>
  <div id="menu">
    <a href="./userSearch.php">Back to Search Results</a>
  </div>
  <div Id="content">
    <?php 
      function printMembers($conn, $members){
        foreach($members as $key => $member){
          $summonerId = $member['summoner_id'];
          $summoner = getSummoner($conn, $summonerId);
          $name = $summoner['name'];
          $leagueId = getLeagueId($conn, $summonerId);
          $league = getLeague($conn, $leagueId);
          $leagueName = $league['tierName'];
          $prettyLeagueName = ucfirst($leagueName);
          $roleId = $summoner['role_id'];
          $roleName = getPrettyRoleName($conn, $roleId);
          $num_matches = $summoner['num_matches'];
          $memberStr = '<div id="item">';
          $memberStr .= '<b>' . $name . '</b>';
          $memberStr .= '<div id="item">Main Role: ' . $roleName . '</div>';
          $memberStr .= '<div id="item">League: ' . $prettyLeagueName . '</div>';
          //$memberStr .= ' Main Role: ' . $role;
          //$memberStr .= ' League: ' . $league;
          $memberStr .= '</div>';
          echo $memberStr;
        }
      }

      function printOpenings($conn, $username, $openings){
        foreach($openings as $key => $opening){
          $openingId = $opening['id'];
          $roleId = $opening['role_id'];
          $role = getPrettyRoleName($conn, $roleId);
          $str = '<div id="item">';
          $str .= '<form enctype="multipart/form-data"';
          $str .= 'action=""';
          $str .= 'method="post"';
          $str .= 'name="application_form"' . $openingId;
          $str .= 'id="application_form"' . $openingId;
          $str .= 'class="application_form"';
          $str .= ' style="display:inline">';
	  $str .= '<input type="hidden" name="opening_id" value=';
          $str .= '"' . $openingId . '" />';
	  $str .= '<input type="hidden" name="summoner_name" value=';
          $str .= '"' . $username . '" />';
	  $str .= '<input type="submit" name="submit" id="button" value="Apply"/>';
	  $str .= '</form>';
          $str .= ' Role: ' . $role;
          $str .= '</div>';
          echo $str;
        }
      }

      function setPlayDays($conn, $members){
        $teamPlayDays = [];
        foreach($members as $key => $member){
          $summonerId = $member['summoner_id'];
          $playDays = getPlayDays($conn, $summonerId);
          foreach($playDays as $key => $value){
            if(!array_key_exists($key, $teamPlayDays))
              $teamPlayDays[$key] = $value;
            else
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

      if(isset ($_COOKIE['username'], $_GET['teamId'])){
        $username = $_COOKIE['username'];

        $teamId = $_GET["teamId"];
        $teamName = getTeamName($conn, $teamId);
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
        printOpenings($conn, $username, $openings);
        echo '</div></div>';

        echo '<div id="header3">When They Play:</div>';
        echo '<div>(Totals of solo queue 5v5 ranked matches by members)</div>';
        echo '<div id="list"><div id="item">';
        setPlayDays($conn, $members);
        echo '</div></div>';
      }
      else{
        echo 'No team name?';
      }
    ?>
    <div id="profileDayGraph">Pie Chart Showing Hours by Days</div>
    <script type="text/javascript" style="margin:0 auto;" src="teamProfileBars.js">
    </script>

  </div>
  </body> 
</html>
