<?php
include_once 'includes/db_functions.php';

function displayResult($conn, $teamId){
  $teamName = getTeamName($conn, $teamId);
  $description = getTeamDescription($conn, $teamId);
  $members = getTeamMembers($conn, $teamId);
  $numMembers = count($members);
  //$str = "<div id='header3'>" . $teamName . "</div>";
  $str = '<a id=header3 href=';
  $str .= '"userViewProfile.php?teamId=' . $teamId . '">';
  $str .= $teamName . "</a>";
  //$str .= "<div id='list'> <div id='item'> " . $description . "</div></div>";
  $str .= "<div id='list'>";
  //$str .= "<div id='item'> Description: " . $description . "</div></div>";
  $str .= "<div id='item'>" . $description . "</div></div>";
  //$str .= "<div id='item'> Members: " . $numMembers . "</div></div>";
  $str .= "</div>";
  echo $str;
}

function getHourScore($conn, $userPlayHours){
  $normalizedUserPlayHours = [];
  $userTotalMatches = 0;
  foreach($userPlayHours as $day => $numMatches){
    $userTotalMatches += $numMatches;
  }
  foreach($userPlayHours as $day => $numMatches){
    if($userTotalMatches > 0)
      $normalizedUserPlayHours[$day] = $numMatches / (float) $userTotalMatches;
    else
      $normalizedUserPlayHours[$day] = 1.0/24.0;
  }
  $teamIds = getTeamIdsWithOpenings($conn);
  $teamScores = [];
  foreach($teamIds as $i => $teamId){
    $members = getTeamMembers($conn, $teamId);
    $teamPlayHours = [];
    $teamTotalMatches = 0;
    $first = true;
    foreach($members as $j => $member){
      $summonerId = $member['summoner_id'];
      $playHours = getPlayHours($conn, $summonerId);
      if($first){
        foreach($playHours as $day => $numMatches){
          $teamPlayHours[$day] = $numMatches;
          $teamTotalMatches += $numMatches;
        }
      }
      else{
        foreach($playHours as $day => $numMatches){
          $teamPlayHours[$day] += $numMatches;
          $teamTotalMatches += $numMatches;
        }
      }
      $first = false;
    }
    $matchScore = 0.0;
    foreach($teamPlayHours as $day => $numMatches){
      $userPlay = $normalizedUserPlayHours[$day];
      if($teamTotalMatches > 0)
        $teamHourFrac = $numMatches / (float) $teamTotalMatches;
      else
        $teamHourFrac = 1.0/24.0;
      $dayScore = $userPlay * $teamHourFrac;
      //echo "<br>userFrac: " . $userPlay;
      //echo "teamFrac: " . $teamDayFrac;
      //echo "dayScore: " . $dayScore . "<br>";
      $matchScore += $hourScore;
    }
    $teamScores[$teamId] = $matchScore;
  }
  // sort teams by match score
  arsort($teamScores);
  return $teamScores;
}

function getDayScores($conn, $userPlayDays){
  $normalizedUserPlayDays = [];
  $userTotalMatches = 0;
  foreach($userPlayDays as $day => $numMatches){
    $userTotalMatches += $numMatches;
  }
  foreach($userPlayDays as $day => $numMatches){
    if($userTotalMatches > 0)
      $normalizedUserPlayDays[$day] = $numMatches / (float) $userTotalMatches;
    else
      $normalizedUserPlayDays[$day] = 1.0/7.0;
  }
  $teamIds = getTeamIdsWithOpenings($conn);
  $teamScores = [];
  foreach($teamIds as $i => $teamId){
    $members = getTeamMembers($conn, $teamId);
    $teamPlayDays = [];
    $teamTotalMatches = 0;
    $first = true;
    foreach($members as $j => $member){
      $summonerId = $member['summoner_id'];
      $playDays = getPlayDays($conn, $summonerId);
      if($first){
        foreach($playDays as $day => $numMatches){
          $teamPlayDays[$day] = $numMatches;
          $teamTotalMatches += $numMatches;
        }
      }
      else{
        foreach($playDays as $day => $numMatches){
          $teamPlayDays[$day] += $numMatches;
          $teamTotalMatches += $numMatches;
        }
      }
      $first = false;
    }
    $matchScore = 0.0;
    foreach($teamPlayDays as $day => $numMatches){
      $userPlay = $normalizedUserPlayDays[$day];
      if($teamTotalMatches > 0)
        $teamDayFrac = $numMatches / (float) $teamTotalMatches;
      else
        $teamDayFrac = 1.0/7.0;
      $dayScore = $userPlay * $teamDayFrac;
      //echo "<br>userFrac: " . $userPlay;
      //echo "teamFrac: " . $teamDayFrac;
      //echo "dayScore: " . $dayScore . "<br>";
      $matchScore += $dayScore;
    }
    $teamScores[$teamId] = $matchScore;
  }
  // sort teams by match score
  arsort($teamScores);
  return $teamScores;
}

function getLeagueScores($conn, $userLeague){
  $teamIds = getTeamIdsWithOpenings($conn);
  $teamScores = [];
  foreach($teamIds as $teamId){
    $teamAvgLeague = getAverageSoloLeague($conn, $teamId);
    $dist = abs($userLeague - $teamAvgLeague);
    $maxDist = 7.0;
    $teamScores[$teamId] = ($maxDist - $dist) / $maxDist;
  }
  // sort teams by match score
  arsort($teamScores);
  return $teamScores;
}

if(isset($_POST['playDays'], $_POST['league'])){
  $userPlayDays = $_POST['playDays'];
  $userLeague = $_POST['league'];
  $teamsByDayScore = getDayScores($conn, $userPlayDays);
  $teamsByLeagueScore = getLeagueScores($conn, $userLeague);
  $matches = [];
  foreach($teamsByLeagueScore as $teamId => $leagueScore){
    $dayScore = $teamsByDayScore[$teamId];
    //echo "dayScore=" . $dayScore;
    //echo "leagueScore=" . $leagueScore;
    $matches[$teamId] = $dayScore + (0.3 * $leagueScore);
  }
  arsort($matches);
  $i = 0;
  $numResultsToShow = 5;
  foreach($matches as $teamId => $matchScore){
    if($i < $numResultsToShow){
      displayResult($conn, $teamId);
      //echo "score: " . $matchScore . "<br>";
    }
    $i++;
  }
}
else{
  echo "Missing required POST data";
}

?>
