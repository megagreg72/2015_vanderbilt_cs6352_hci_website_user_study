<?php
ini_set('display_errors', 'On');
error_reporting(E_ALL | E_STRICT);
include_once 'includes/db_connect.php';
include_once 'includes/psl-config.php';

function do_alert($msg) 
{
  echo '<script type="text/javascript">alert("' . $msg . '"); </script>';
}

$error_msg = "";

$name = '';
/*
$members = [];
//$summoner_data = [];
for($i=1; $i<=9; $i++){
  $str = 'member' . $i;
  if(isset($_POST[$str])){
    $members[$i-1] = filter_input(INPUT_POST, $str, FILTER_SANITIZE_STRING);
    $dataStr = $str . '_data';
    //$summoner_data[$i-1] = json_decode($_POST[$str . '_data']);
  }
}

$openings = [];
for($i=1; $i<=9; $i++){
  $str = 'opening' . $i;
  if(isset($_POST[$str])){
    $openings[$i-1] = filter_input(INPUT_POST, $str, FILTER_SANITIZE_STRING);
  }
}
*/
if (isset($_POST['name'], $_POST['description'], $_POST['email'], $_POST['p'], $_POST['member1'], $_POST['opening1'])) {
  //do_alert("called register.inc.php");
  /*
  //echo '<script type="text/javascript">alert("called register.inc.php"); </script>';
  // Sanitize and validate the data passed in
  $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
  $description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_STRING);
  $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
  $email = filter_var($email, FILTER_VALIDATE_EMAIL);
  if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $error_msg .= '<p class="error">The email address you entered is not valid</p>';
  }
 
  $password = filter_input(INPUT_POST, 'p', FILTER_SANITIZE_STRING);
  if (strlen($password) != 128) {
    // The hashed pwd should be 128 characters long.
    // If it's not, something really odd has happened
    $error_msg .= '<p>Invalid password configuration</p>';
  }

  // check existing email  
  $prep_stmt = "SELECT id FROM teams WHERE email = ? LIMIT 1";
  $stmt = $mysqli->prepare($prep_stmt);
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
  $stmt = $mysqli->prepare($prep_stmt);
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
	
    // Insert the new user into the database 
    if ($insert_stmt = $mysqli->prepare("INSERT INTO teams (name, description, email, password, salt) VALUES (?, ?, ?, ?, ?)")) {
      $insert_stmt->bind_param('sssss', $name, $description, $email, $password, $random_salt);
      // Execute the prepared query.
      if (! $insert_stmt->execute()) {
        $error_msg .= '<br><p>Registration failure: INSERT of team<p>';
      }
    }
  }
  
  if(empty($error_msg)){
    $teamId = mysqli_insert_id($mysqli);
  }
  
  if(empty($error_msg)){
    foreach ($summoners_data as $summoner_data){
      //do_alert("test1");
      $num_matches = $summoner_data["num_matches"];
      $roles = $summoner_data["roles"];
      $playHours = $summoner_data["playHours"];
      $playDays = $summoner_data["playDays"];

      $mainRoleName = "";
      $mainRoleMatches = -1;
      foreach ($roles as $key->$value){
        if($value > $mainRoleMatches){
          $mainRoleMatches = $value;
          $mainRoleName = $key;
        }
      }      
      
      if ($insert_stmt = $mysqli->prepare("INSERT INTO summoners (id, name, num_matches, role_id) SELECT ?, ?, ?, id FROM roles WHERE name = ?")) {
        $insert_stmt->bind_param('ssss', $summonerId, $summonerName, $num_matches, $mainRoleName);
        // Execute the prepared query.
        if (! $insert_stmt->execute()) {
          $error_msg .= '<br><p>Registration failure: INSERT of summoner data for member ' . $member . '.</p>';
        }
      }
    }
  }

  if(empty($error_msg)){
    foreach ($members as $summonerName){
      // assumes we already have member summoner data
      if ($insert_stmt = $mysqli->prepare("INSERT INTO teamMembers (team_id, summoner_id) SELECT ?, id FROM summoners WHERE name = ?")) {
        $insert_stmt->bind_param('ss', $teamId, $summonerName);
        // Execute the prepared query.
        if (! $insert_stmt->execute()) {
          $error_msg .= '<br><p>Registration failure: INSERT of member ' . $member . '.</p>';
        }
      }
    }
  }

  if(empty($error_msg)){
    foreach ($openings as $openingRoleName){
      if ($insert_stmt = $mysqli->prepare("INSERT INTO teamOpenings (team_id, role_id) SELECT ?, id FROM roles WHERE name = ?")) {
        $insert_stmt->bind_param('ss', $teamId, $openingRoleName);
        // Execute the prepared query.
        if (! $insert_stmt->execute()) {
          $error_msg .= '<br><p>Registration failure: INSERT of member ' . $member . '.</p>';
        }
      }
    }
  }
*/
  $return = [];
  if($error_msg != ''){
    $return = array('status' => 'error','message'=> $error_msg);
    //print $error_msg;
    //header('Location: ./error.php?err='.$error_msg );
  }
  else{
    $return = array('status' => 'success','message'=> 'hooray! success!');
    //print "successfully registered!";
    //header('Location: ./register_success.php');
  }
}
else{
  $return = [];
  $return = array('status' => 'error','message'=> 'missing POST data');
}
$return["json"] = json_encode($return);
echo json_encode($return);

