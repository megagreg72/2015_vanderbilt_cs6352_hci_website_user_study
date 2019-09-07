<?php
include_once "includes/db_connect.php";

function printArray($array){
     foreach ($array as $key => $value){
        echo "$key => $value";
        if(is_array($value)){ //If $value is an array, print it as well!
            printArray($value);
        }
    }
}

function getTeamId($conn, $teamName){
  $sql = "SELECT id FROM teams WHERE name=" . "'" . $teamName . "'";
  $result = $conn->query($sql);
  $teamId = "NOT FOUND";
  if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
      $teamId = $row["id"];
    }
  }
  else {
    echo "Error: Team id not found";
  }
  return $teamId;
}

function getTeamName($conn, $teamId){
  $sql = "SELECT name FROM teams WHERE id=" . $teamId;
  $result = $conn->query($sql);
  $teamName = "NOT FOUND";
  if ($result->num_rows > 0) {
      // output data of each row
      while($row = $result->fetch_assoc()) {
          //echo "Name: " . $row["name"] . "<br>";
          $teamName = $row["name"];
      }
  } else {
      echo "Error: Team name not found";
  }
  return $teamName;
}

function getTeamDescription($conn, $teamId){
  $sql = "SELECT description FROM teams WHERE id=" . $teamId;
  $result = $conn->query($sql);
  $teamDescription = "NOT FOUND";
  if ($result->num_rows > 0) {
      // output data of each row
      while($row = $result->fetch_assoc()) {
          $teamDescription = $row["description"];
      }
  } else {
      echo "Error: Team description not found";
  }
  return $teamDescription;
}

function getTeamMembers($conn, $teamId){
  $sql = "SELECT * FROM teamMembers WHERE team_id=" . $teamId;
  $result = $conn->query($sql);
  $members = [];
  if ($result->num_rows > 0) {
      // output data of each row
      $i = 0;
      while($row = $result->fetch_assoc()) {
          $members[$i] = $row;
          $i++;
      }
  } else {
      echo "Error: Team members not found for team with id=" . $teamId;
  }
  return $members;
}

function getPlayHours($conn, $summonerId){
  $hoursById = getHours($conn);
  $sql = "SELECT * FROM summonerPlayHours WHERE summoner_id=" . $summonerId;
  $result = $conn->query($sql);
  $playHours = [];
  if ($result->num_rows > 0) {
      // output data of each row
      while($row = $result->fetch_assoc()) {
          $hourName = $hoursById[$row["hour_id"]];
          $value = $row["num_games"];
          $playHours[$hourName] = $value;
      }
  } else {
      echo "Error: playHour not found";
  }
  return $playHours;
}

function getPlayDays($conn, $summonerId){
  $daysById = getDays($conn);
  $sql = "SELECT * FROM summonerPlayDays WHERE summoner_id=" . $summonerId;
  $result = $conn->query($sql);
  $playDays = [];
  if ($result->num_rows > 0) {
      // output data of each row
      while($row = $result->fetch_assoc()) {
          $dayName = $daysById[$row["day_id"]];
          $value = $row["num_games"];
          $playDays[$dayName] = $value;
      }
  } else {
      echo "Error: playDay not found";
  }
  return $playDays;
}

function getDays($conn){
  $sql = "SELECT * FROM days";
  $result = $conn->query($sql);
  $days = [];
  if ($result->num_rows > 0) {
      // output data of each row
      while($row = $result->fetch_assoc()) {
          $id = $row["id"];
          $name = $row["name"];
          $days[$id] = $name;
      }
  } else {
      echo "Error: days not found";
  }
  return $days;
}

function getTeamOpenings($conn, $teamId){
  $sql = "SELECT * FROM teamOpenings WHERE team_id=" . $teamId;
  $result = $conn->query($sql);
  $openings = [];
  if ($result->num_rows > 0) {
      // output data of each row
      $i = 0;
      while($row = $result->fetch_assoc()) {
          $openings[$i] = $row;
          $i++;
      }
  } else {
      echo "Error: Team openings not found";
  }
  return $openings;
}

function getTeamIdsWithOpenings($conn){
  $sql = "SELECT DISTINCT t.id FROM teams t inner join teamOpenings o on t.id = o.team_id";
  $result = $conn->query($sql);
  $teamIds = [];
  if ($result->num_rows > 0) {
      // output data of each row
      $i = 0;
      while($row = $result->fetch_assoc()) {
          $teamIds[$i] = $row['id'];
          $i++;
      }
  } else {
      echo "Error: TeamIds with openings not found";
  }
  return $teamIds;
}

function getOpening($conn, $openingId){
  $sql = "SELECT * FROM teamOpenings WHERE id=" . $openingId;
  $result = $conn->query($sql);
  $opening;
  if ($result->num_rows > 0) {
      // output data of each row
      $i = 0;
      while($row = $result->fetch_assoc()) {
          $opening = $row;
      }
  } else {
      echo "Error: Opening not found";
  }
  return $opening;
}

function getApplications($conn, $openingId){
  $sql = "SELECT * FROM applications WHERE opening_id=" . $openingId;
  $result = $conn->query($sql);
  $applications = [];
  if ($result->num_rows > 0) {
      // output data of each row
      $i = 0;
      while($row = $result->fetch_assoc()) {
          $applications[$i] = $row;
          $i++;
      }
  } else {
      // Likely to happen since this just means nobody applied
      // to this yet
      //echo "Error: Applications not found";
  }
  return $applications;
}

function getApplication($conn, $applicationId){
  $sql = "SELECT * FROM applications WHERE id=" . $applicationId;
  $result = $conn->query($sql);
  $application;
  if ($result->num_rows > 0) {
      // output data of each row
      $i = 0;
      while($row = $result->fetch_assoc()) {
          $application = $row;
      }
  } else {
      echo "Error: Application not found";
  }
  return $application;
}


function getSummonerId($conn, $summonerName){
  $sql = "SELECT id FROM summoners WHERE name='" . $summonerName . "'";
  $result = $conn->query($sql);
  $summonerId = "NOT FOUND";
  if ($result->num_rows > 0) {
      // output data of each row
      while($row = $result->fetch_assoc()) {
          $summonerId = $row["id"];
      }
  } else {
      echo "Error: Summoner id not found";
  }
  return $summonerId;
}

function getAllSummonerNames($conn){
  $sql = "SELECT name FROM summoners";
  $result = $conn->query($sql);
  $summonerNames = [];
  $i=0;
  if ($result->num_rows > 0) {
      // output data of each row
      while($row = $result->fetch_assoc()) {
          $summonerNames[$i] = $row["name"];
          $i++;
      }
  } else {
      echo "Error: Summoner ids not found";
  }
  return $summonerNames;
}

function getSummoner($conn, $summonerId){
  $sql = "SELECT * FROM summoners WHERE id=" . $summonerId;
  $result = $conn->query($sql);
  $summoner = "NOT FOUND";
  if ($result->num_rows > 0) {
      // output data of each row
      while($row = $result->fetch_assoc()) {
          $summoner = $row;
      }
  } else {
      echo "Error: Summoner not found";
  }
  return $summoner;
}

function insertMember($conn, $teamId, $summonerId){
  $sql = "INSERT IGNORE INTO teamMembers (team_id, summoner_id) VALUES (" . $teamId . ", " . $summonerId . ")";
  $success = $conn->query($sql);
  if ($success === TRUE) {
    // success
  } else {
      echo "Error: Could not insert new member into team";
  }
  return $success;
}

function insertApplication($conn, $openingId, $summonerId){
  $sql = "INSERT IGNORE INTO applications (summoner_id, opening_id) VALUES (" . $summonerId . ", " . $openingId . ")";
  $success = $conn->query($sql);
  if ($success === TRUE) {
    // success
  } else {
      echo "Error: Could not insert application";
  }
  return $success;
}

function removeApplication($conn, $applicationId){
  $sql = "DELETE FROM applications WHERE id=" . $applicationId;
  $success = $conn->query($sql);
  if ($success === TRUE) {
    // success
  } else {
      echo "Error: Could not delete application";
      echo " after this query:<br>";
      echo $sql;
  }
  return $success;
}

function removeOpening($conn, $openingId){
  $sql = "DELETE FROM teamOpenings WHERE id=" . $openingId;
  $success = $conn->query($sql);
  if ($success === TRUE) {
    // success
  } else {
      echo "Error: Could not delete opening";
      echo " after this query:<br>";
      echo $sql;
  }
  return $success;
}

function getLeagueId($conn, $summonerId){
  $sql = "SELECT * FROM summonerLeagues WHERE summoner_id=" . $summonerId;
  $result = $conn->query($sql);
  $leagueId = "NOT FOUND";
  if ($result->num_rows > 0) {
      // output data of each row
      while($row = $result->fetch_assoc()) {
          $leagueId = $row["league_id"];
      }
  } else {
      echo "Error: League not found by summonerId=" . $summonerId;
  }
  return $leagueId;
}

function getAverageSoloLeague($conn, $teamId){
  $members = getTeamMembers($conn, $teamId);
  $leagueSum = 0;
  foreach($members as $member){
    $leagueId = getLeagueId($conn, $member['summoner_id']);
    $league = getLeague($conn, $leagueId);
    $leagueSum += $league['tierNum'];
  }
  $avgLeague = $leagueSum / sizeof($members);
  return $avgLeague;
}

function getLeague($conn, $leagueId){
  $sql = "SELECT * FROM leagues WHERE id=" . $leagueId;
  $result = $conn->query($sql);
  $league = "NOT FOUND";
  if ($result->num_rows > 0) {
      // output data of each row
      while($row = $result->fetch_assoc()) {
          $league = $row;
      }
  } 
  else {
      echo "Error: League not found by id " . $leagueId;
  }
  return $league;
}

function getLeagueByName($conn, $leagueName){
  $sql = "SELECT * FROM leagues WHERE tierName=" . $leagueName;
  $result = $conn->query($sql);
  $league = "NOT FOUND";
  if ($result->num_rows > 0) {
      // output data of each row
      while($row = $result->fetch_assoc()) {
          $league = $row;
      }
  } 
  else {
      echo "Error: League not found by name";
  }
  return $league;
}

function getPrettyRoleName($conn, $roleId){
  $sql = "SELECT name FROM roles WHERE id=" . $roleId;
  $result = $conn->query($sql);
  $roleName = "NOT FOUND";
  if ($result->num_rows > 0) {
      // output data of each row
      while($row = $result->fetch_assoc()) {
          $roleName = $row["name"];
      }
  } 
  else {
      echo "Error: Role not found";
  }
  $pretty = "";
  if($roleName=="mid"){
    $pretty = "Mid";
  }
  if($roleName=="jng"){
    $pretty = "Jungler";
  }
  if($roleName=="top"){
    $pretty = "Top";
  }
  if($roleName=="sup"){
    $pretty = "Support";
  }
  if($roleName=="adc"){
    $pretty = "AD Carry";
  }
  if($roleName=="any"){
    $pretty = "Any";
  }
  return $pretty;
}


function insertSummoner($conn, $summonerData){
  error_log('summonerData: ' . print_r($summonerData, true));
  $error_msg = "";
  $summonerId = $summonerData["id"];
  $summonerName = $summonerData["name"];
  $num_matches = $summonerData["num_matches"];
  $league = $summonerData["league"];
  $roles = $summonerData["roles"];
  $playHours = $summonerData["playHours"];
  $playDays = $summonerData["playDays"];

  $mainRoleName = "any";
  $mainRoleMatches = 0;
  //error_log('name: ' . print_r($summonerName, true));
  //error_log('roles: ' . print_r($roles, true));
  foreach ($roles as $key=>$value){
    if($value > $mainRoleMatches){
      $mainRoleMatches = $value;
      $mainRoleName = $key;
    }
  }
  if ($insert_stmt = $conn->prepare("REPLACE INTO summoners (id, name, num_matches, role_id) SELECT ?, ?, ?, id FROM roles WHERE name = ?")) {
    $insert_stmt->bind_param('ssss', $summonerId, $summonerName, $num_matches, $mainRoleName);
    // Execute the prepared query.
    if (! $insert_stmt->execute()) {
      $error_msg .= '<br><p>Registration failure: INSERT of summoner data for member ' . $summonerName . '.</p>';
    }
  }
  error_log('summonerId: ' . print_r($summonerId, true));
  error_log('league: ' . print_r($league, true));
  if ($insert_stmt = $conn->prepare("REPLACE INTO summonerLeagues (summoner_id, league_id) SELECT ?, id FROM leagues WHERE tierName = ?")) {
    $insert_stmt->bind_param('ss', $summonerId, $league);
    // Execute the prepared query.
    if (! $insert_stmt->execute()) {
      $error_msg .= '<br><p>Registration failure: INSERT of league data for member ' . $summonerName . '.</p>';
    }
  }

  foreach($playDays as $day => $num_matches){
    //error_log('summonerId: ' . print_r($summonerId, true));
    //error_log('num_matches: ' . print_r($num_matches, true));
    //error_log('day: ' . print_r($day, true));
    if ($insert_stmt = $conn->prepare("REPLACE INTO summonerPlayDays (summoner_id, num_games, day_id) SELECT ?, ?, id FROM days WHERE name = ?")) {
      $insert_stmt->bind_param('sss', $summonerId, $num_matches, $day);
      // Execute the prepared query.
      if (! $insert_stmt->execute()) {
        $error_msg .= '<br><p>Registration failure: INSERT of summoner day data for member ' . $summonerName . '.</p>';
      }
    }
  }
  foreach($playHours as $hour => $num_matches){
    //error_log('summonerId: ' . print_r($summonerId, true));
    //error_log('num_matches: ' . print_r($num_matches, true));
    //error_log('hour: ' . print_r($hour, true));
    if ($insert_stmt = $conn->prepare("REPLACE INTO summonerPlayHours (summoner_id, hour_id, num_games) VALUES (?, ?, ?)")) {
      $insert_stmt->bind_param('sss', $summonerId, $hour, $num_matches);
      // Execute the prepared query.
      if (! $insert_stmt->execute()) {
        $error_msg .= '<br><p>Registration failure: INSERT of summoner hour data for member ' . $summonerName . '.</p>';
      }
    }
  }
  return $error_msg;
}

function updateSummoner($conn, $summonerData){
  error_log('summonerData: ' . print_r($summonerData, true));
  $error_msg = "";
  $summonerId = $summonerData["id"];
  $summonerName = $summonerData["name"];
  $num_matches = $summonerData["num_matches"];
  $league = $summonerData["league"];
  $roles = $summonerData["roles"];
  $playHours = $summonerData["playHours"];
  $playDays = $summonerData["playDays"];

  $mainRoleName = "any";
  $mainRoleMatches = 0;
  //error_log('name: ' . print_r($summonerName, true));
  //error_log('roles: ' . print_r($roles, true));
  foreach ($roles as $key=>$value){
    if($value > $mainRoleMatches){
      $mainRoleMatches = $value;
      $mainRoleName = $key;
    }
  }
  /*
  if ($insert_stmt = $conn->prepare("REPLACE INTO summoners (id, name, num_matches, role_id) SELECT ?, ?, ?, id FROM roles WHERE name = ?")) {
    $insert_stmt->bind_param('ssss', $summonerId, $summonerName, $num_matches, $mainRoleName);
    // Execute the prepared query.
    if (! $insert_stmt->execute()) {
      $error_msg .= '<br><p>Registration failure: INSERT of summoner data for member ' . $summonerName . '.</p>';
    }
  }
  */
  error_log('summonerId: ' . print_r($summonerId, true));
  error_log('league: ' . print_r($league, true));
  if ($insert_stmt = $conn->prepare("REPLACE INTO summonerLeagues (summoner_id, league_id) SELECT ?, id FROM leagues WHERE tierName = ?")) {
    $insert_stmt->bind_param('ss', $summonerId, $league);
    // Execute the prepared query.
    if (! $insert_stmt->execute()) {
      $error_msg .= '<br><p>Registration failure: INSERT of league data for member ' . $summonerName . '.</p>';
    }
  }

  foreach($playDays as $day => $num_matches){
    //error_log('summonerId: ' . print_r($summonerId, true));
    //error_log('num_matches: ' . print_r($num_matches, true));
    //error_log('day: ' . print_r($day, true));
    if ($insert_stmt = $conn->prepare("REPLACE INTO summonerPlayDays (summoner_id, num_games, day_id) SELECT ?, ?, id FROM days WHERE name = ?")) {
      $insert_stmt->bind_param('sss', $summonerId, $num_matches, $day);
      // Execute the prepared query.
      if (! $insert_stmt->execute()) {
        $error_msg .= '<br><p>Registration failure: INSERT of summoner day data for member ' . $summonerName . '.</p>';
      }
    }
  }

  foreach($playHours as $hour => $num_matches){
    //error_log('summonerId: ' . print_r($summonerId, true));
    //error_log('num_matches: ' . print_r($num_matches, true));
    //error_log('hour: ' . print_r($hour, true));
    if ($insert_stmt = $conn->prepare("REPLACE INTO summonerPlayHours (summoner_id, hour_id, num_games) VALUES (?, ?, ?)")) {
      $insert_stmt->bind_param('sss', $summonerId, $hour, $num_matches);
      // Execute the prepared query.
      if (! $insert_stmt->execute()) {
        $error_msg .= '<br><p>Registration failure: INSERT of summoner hour data for member ' . $summonerName . '.</p>';
      }
    }
  }
  return $error_msg;
}
