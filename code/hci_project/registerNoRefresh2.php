<?php
//include_once 'includes/db_connect.php';
include_once 'includes/db_functions.php';
include_once 'includes/psl-config.php';


$error_msg = "";

$members = [];
$summoner_data = [];
for($i=1; $i<=9; $i++){
  $str = 'member' . $i;
  if(isset($_POST[$str])){
    $members[$i-1] = filter_input(INPUT_POST, $str, FILTER_SANITIZE_STRING);
    $summoner_data[$i-1] = $_POST['summoner_data'][$i-1];
  }
}

$openings = [];
for($i=1; $i<=9; $i++){
  $str = 'opening' . $i;
  if(isset($_POST[$str])){
    $openings[$i-1] = filter_input(INPUT_POST, $str, FILTER_SANITIZE_STRING);
  }
}

error_log('POST: ' . print_r($_POST, true));
//error_log('members: ' . print_r($members, true));
//error_log('summoner_data: ' . print_r($summoner_data, true));
//error_log('openings: ' . print_r($openings, true));

if(!isset($_POST['name'])){
  $error_msg .= " no name";
}
if(!isset($_POST['description'])){
  $error_msg .= " no description";
}
if(!isset($_POST['email'])){
  $error_msg .= " no email";
}
if(!isset($_POST['p'])){
  $error_msg .= " no p";
}
if(!isset($_POST['member1'])){
  $error_msg .= " no member1";
}
if(!isset($_POST['opening1'])){
  $error_msg .= " no opening1";
}
if($error_msg == ''){
  $conn->autocommit(FALSE);
  // Sanitize and validate the data passed in
  $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
  $description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_STRING);
  $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
  $email = filter_var($email, FILTER_VALIDATE_EMAIL);
  if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $error_msg .= '<p class="error">The email address you entered is not valid</p>';
  }
 
  $password = filter_input(INPUT_POST, 'p', FILTER_SANITIZE_STRING);
  //$password = $_POST['p'];
  if (strlen($password) != 128) {
    // The hashed pwd should be 128 characters long.
    // If it's not, something really odd has happened
    error_log('hashed password had length: ' . strlen($password));
    $error_msg .= '<p>Invalid password configuration</p>';
  }

  // check existing email  
  $prep_stmt = "SELECT id FROM teams WHERE email = ? LIMIT 1";
  $stmt = $conn->prepare($prep_stmt);
  if ($stmt) {
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows == 1) {
      // A user with this email address already exists
      $error_msg .= "<br><p>A team with this email address already exists.  </p>";
    }
  }
  else {
    $error_msg .= '<br><p>Database error #1.  </p>';
  }
  $stmt->close();
 
  // check existing username
  $prep_stmt = "SELECT id FROM teams WHERE name = ? LIMIT 1";
  $stmt = $conn->prepare($prep_stmt);
  if ($stmt) {
    $stmt->bind_param('s', $name);
    $stmt->execute();
    $stmt->store_result();
 
    if ($stmt->num_rows == 1) {
      $error_msg .= "<br><p>A team with this name already exists.  </p>";
    }
  } 
  else {
    $error_msg .= '<br><p>Database error #2.  </p>';
  }
  $stmt->close();

  // password stuff
  if (empty($error_msg)) {
    // Create a random salt
    $random_salt = hash('sha512', uniqid(mt_rand(1, mt_getrandmax()), true));
 
    // Create salted password
    $password = hash('sha512', $password . $random_salt);
	
    // Insert the new team into the database 
    if ($insert_stmt = $conn->prepare("INSERT INTO teams (name, description, email, password, salt) VALUES (?, ?, ?, ?, ?)")) {
      $insert_stmt->bind_param('sssss', $name, $description, $email, $password, $random_salt);
      // Execute the prepared query.
      if (! $insert_stmt->execute()) {
        $error_msg .= '<br><p>Registration failure: INSERT of team<p>';
      }
    }
  }
  
  if(empty($error_msg)){
    $teamId = mysqli_insert_id($conn);
  }
  
  if(empty($error_msg)){
    //error_log('summoner_data: ' . print_r($summoner_data, true));
    foreach ($summoner_data as $summoner){
      $error_msg .= insertSummoner($conn, $summoner);
    }
  }
/*
      $summonerId = $summoner["id"];
      $summonerName = $summoner["name"];
      $num_matches = $summoner["num_matches"];
      $league = $summoner["league"];
      $roles = $summoner["roles"];
      $playHours = $summoner["playHours"];
      $playDays = $summoner["playDays"];
      
      $mainRoleName = "any";
      $mainRoleMatches = 0;
      error_log('name: ' . print_r($summonerName, true));
      error_log('roles: ' . print_r($roles, true));
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
      error_log('summonerId: ' . print_r($summonerId, true));
      error_log('num_matches: ' . print_r($num_matches, true));
      error_log('day: ' . print_r($day, true));
        if ($insert_stmt = $conn->prepare("REPLACE INTO summonerPlayDays (summoner_id, num_games, day_id) SELECT ?, ?, id FROM days WHERE name = ?")) {
          $insert_stmt->bind_param('sss', $summonerId, $num_matches, $day);
          // Execute the prepared query.
          if (! $insert_stmt->execute()) {
            $error_msg .= '<br><p>Registration failure: INSERT of summoner day data for member ' . $summonerName . '.</p>';
          }
        }
      }

      foreach($playHours as $hour => $num_matches){
      error_log('summonerId: ' . print_r($summonerId, true));
      error_log('num_matches: ' . print_r($num_matches, true));
      error_log('hour: ' . print_r($hour, true));
        if ($insert_stmt = $conn->prepare("REPLACE INTO summonerPlayHours (summoner_id, hour_id, num_games) VALUES (?, ?, ?)")) {
          $insert_stmt->bind_param('sss', $summonerId, $hour, $num_matches);
          // Execute the prepared query.
          if (! $insert_stmt->execute()) {
            $error_msg .= '<br><p>Registration failure: INSERT of summoner hour data for member ' . $summonerName . '.</p>';
          }
        }
      }

    }
  }
*/

  if(empty($error_msg)){
    foreach ($members as $summonerName){
      // assumes we already have member summoner data
      if ($insert_stmt = $conn->prepare("INSERT INTO teamMembers (team_id, summoner_id) SELECT ?, id FROM summoners WHERE name = ?")) {
        $insert_stmt->bind_param('is', $teamId, $summonerName);
        // Execute the prepared query.
        if (! $insert_stmt->execute()) {
          $error_msg .= '<br><p>Registration failure: INSERT of member ' . $member . '.</p>';
        }
      }
    }
  }

  if(empty($error_msg)){
    foreach ($openings as $openingRoleName){
      if ($insert_stmt = $conn->prepare("INSERT INTO teamOpenings (team_id, role_id) SELECT ?, id FROM roles WHERE name = ?")) {
        $insert_stmt->bind_param('is', $teamId, $openingRoleName);
        // Execute the prepared query.
        if (! $insert_stmt->execute()) {
          $error_msg .= '<br><p>Registration failure: INSERT of member ' . $member . '.</p>';
        }
      }
    }
  }
}
$response_array = [];
if($error_msg != ''){
  $conn->close();
  $response_array = array('status' => 'error','message'=> $error_msg);
  //echo $error_msg;
  //print $error_msg;
  //header('Location: ./error.php?err='.$error_msg ); 
}
else{
  $conn->commit();
  $conn->autocommit(TRUE);
  $response_array = array('status' => 'success','message'=> 'hooray! success!');
  //print "successfully registered!";
  //header('Location: ./register_success.php');
}
header('Content-type: application/json');
echo json_encode($response_array);

