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
       style="float:left; margin-right:10px;">Team Profile</a>
    <a href="./teamApplicants.php" 
       style="float:left; margin-right:10px; text-decoration: underline;">Team Applicants</a>

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

      function printPlayDays($conn, $summonerId){
        $playDays = getPlayDays($conn, $summonerId);
        $str =  '<div id="item">';
        foreach($playDays as $key => $value){
        //  echo '<div id="' . $key . '" value="' . $value . '"></div>';
          $str .= $key . ': ' . $value . ', ';
        }
        $str .= '</div>';
        echo $str;
      }

      function getTeamPlayDays($conn, $teamId){
        $members = getTeamMembers($conn, $teamId);
        $teamPlayDays = [];
        foreach($members as $key => $member){
          $summonerId = $member['summoner_id'];
          $playDays = getPlayDays($conn, $summonerId);
          foreach($playDays as $key => $value){
            $teamPlayDays[$key] += $value;
          }
        }
        return $teamPlayDays;
      }

      if(login_check($conn) == true){
        $teamName = $_SESSION['name'];
        $teamId = getTeamId($conn, $teamName);
        $openings = getTeamOpenings($conn, $teamId);
        $teamPlayDays = getTeamPlayDays($conn, $teamId);
        $num_applications = 0;
        echo '<div>';
        $jsData = [];
        foreach($openings as $key => $opening){
          $openingId = $opening['id'];
          $openingRoleId = $opening['role_id'];
          $openingRole = getPrettyRoleName($conn, $openingRoleId);
          $applications = getApplications($conn, $openingId);
          if(count($applications) > 0){
            $jsData[$openingId] = [];
            $jsData[$openingId]['team'] = $teamPlayDays;
            echo '<div id="header2">Applicants for ' . $openingRole . '</div>';
            echo '<div id="list">';
            //render the bar chart
            echo '<div id="opening' . $openingId . 'DayGraph"';
            echo 'style="float:left"></div>';
            echo '<script type="text/javascript" style="margin:0 auto;" src="teamApplicantsBars.js">';
            echo '</script>';
            $legendColors = ['#D6CCB1', '#C2B28B', '#AD9964', '#997F3D'];
            $i = 0;
            echo '<div id="legend">';
            //render the legend
            foreach($applications as $key => $application){
              // create legend elements
              $legendColor = $legendColors[$i];
              $applicationId = $application['id'];
              $summonerId = $application['summoner_id'];
              $summoner = getSummoner($conn, $summonerId);
              $summonerName = $summoner['name'];
              $playDays = getPlayDays($conn, $summonerId);
              echo '<div id="legendElement" style=display:block>';
              echo '<canvas class="legendCanvas" legendColor="' . $legendColor . '" width="15"';
              echo 'height="15" border:1px solid #c3c3c3;">';
              echo 'Your browser does not support the HTML5 canvas tag.</canvas>';
              $i++;
              echo '<a href="#' . $applicationId . '">';
              echo $summonerName . '</a>';
              echo '</div>';
              // send day data
              $jsData[$openingId][$applicationId] = [];
              $j=0;
              foreach($playDays as $day => $value){
                $jsData[$openingId][$applicationId][$day] = intval($value);
                $j++;
              }
            }
            echo '<div id="legendElement" style=display:block>';
            echo '<canvas class="legendCanvas" legendColor="#000000" width="15" height="15" style="border:1px solid #c3c3c3;">
Your browser does not support the HTML5 canvas tag.
</canvas>';
            echo '<a>Your Team</a>';
            echo '</div>';
            // close legend div
            echo '</div>';
            //close graph div
            //echo '</div>';
            //undo float left style?
            echo '<br style="clear:both" />';
          }
          //render each application in detail
          foreach($applications as $key => $application){
            $num_applications++;
            $applicationId = $application['id'];
            $summonerId = $application['summoner_id'];
            $summoner = getSummoner($conn, $summonerId);
            $summonerName = $summoner['name'];
            $roleId = $summoner['role_id'];
            $role = getPrettyRoleName($conn, $roleId);
            $num_matches = $summoner['num_matches'];
            $leagueId = getLeagueId($conn, $summonerId);
            $league = getLeague($conn, $leagueId);
            $leagueName = ucfirst($league['tierName']);
            $str = '';
            $str .= '<div class="header2" id="' . $applicationId . '"> ';
            $str .= $summonerName . " ";
            $str .= '<form action="acceptApplication.php" method="post"';
            $str .= ' style="display:inline">';
            $str .= '<input type="hidden" name="application_id" value=';
            $str .= '"' . $applicationId . '" />';
            $str .= '<input type="submit" id="smallButton" value="Accept"/>';
            $str .= '</form>';
            $str .= '<form action="rejectApplication.php" method="post"';
            $str .= ' style="display:inline">';
            $str .= '<input type="hidden" name="application_id" value=';
            $str .= '"' . $applicationId . '" />';
            $str .= '<input type="submit" id="smallButton" value="Reject"/>';
            $str .= '</form>';
            $str .= '</div>';

            $str .= '<div id="header3">Main Role: ' . $role . '</div>';
            $str .= '<div id="header3">League: ' . $leagueName . '</div>';
            $str .= '<div id="header3">Ranked Matches Played: ' . $num_matches . '</div>';

            //$str .= '<div id="header3">Often Plays:</div>';
            //$str .= '<div id="list"><div id="item">';
            echo $str;
            //printPlayDays($conn, $summonerId);
            //echo '</div></div>';
          }
          echo '</div>';
        }
        // pass a bunch of data to javascript
        echo '<script>';
        echo 'var dataFromPhp = ' . json_encode($jsData) . ';';
        echo '</script>';

        echo '</div>';
        if($num_applications == 0){
          echo '<div id="header3">There are currently no applications to your team. Check back later!</div>';
        }
      }
      else{
        echo 'You must log in before viewing applications to your team.';
      }
    ?>
  </div>
  </body> 
</html>
