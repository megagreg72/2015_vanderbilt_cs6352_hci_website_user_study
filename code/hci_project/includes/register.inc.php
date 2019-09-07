<?php
include_once 'db_connect.php';
include_once 'psl-config.php';
 
$error_msg = "";

$_POST['member'] = filter_var_array($_POST['member'], FILTER_SANITIZE_STRING);
$_POST['opening'] = filter_var_array($_POST['opening'], FILTER_SANITIZE_STRING);


if (isset($_POST['name'], $_POST['description'], $_POST['email'], $_POST['p'])) {
  // Sanitize and validate the data passed in
  $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
  $description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_STRING);
  $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
  $email = filter_var($email, FILTER_VALIDATE_EMAIL);
  if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    // Not a valid email
    $error_msg .= '<p class="error">The email address you entered is not valid</p>';
  }
 
  $password = filter_input(INPUT_POST, 'p', FILTER_SANITIZE_STRING);
  if (strlen($password) != 128) {
    // The hashed pwd should be 128 characters long.
    // If it's not, something really odd has happened
    $error_msg .= '<p class="error">Invalid password configuration.</p>';
  }

  // Username validity and password validity have been checked client side.
  // This should should be adequate as nobody gains any advantage from
  // breaking these rules.
  //
 
  $prep_stmt = "SELECT id FROM teams WHERE email = ? LIMIT 1";
  $stmt = $conn->prepare($prep_stmt);
 
  // check existing email  
  if ($stmt) {
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows == 1) {
      // A user with this email address already exists
      $error_msg .= '<p class="error">A team with this email address already exists.</p>';
    }
  } 
  else {
    $error_msg .= '<p class="error">Database error Line 39</p>';
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
      // A user with this username already exists
      $error_msg .= '<p class="error">A team with this name already exists</p>';
    }
  } 
  else {
    $error_msg .= '<p class="error">Database error #1</p>';
  }
  $stmt->close();
 
  if (empty($error_msg)) {
    // Create a random salt
    $random_salt = hash('sha512', uniqid(mt_rand(1, mt_getrandmax()), true));
 
    // Create salted password
    $password = hash('sha512', $password . $random_salt);
	
    // Insert the new user into the database 
    if ($insert_stmt = $conn->prepare("INSERT INTO teams (name, description, email, password, salt) VALUES (?, ?, ?, ?, ?)")) {
      $insert_stmt->bind_param('sssss', $name, $description, $email, $password, $random_salt);
      // Execute the prepared query.
      if (! $insert_stmt->execute()) {
        header('Location: ../error.php?err=Registration failure: INSERT of team');
      }
    }
    // get ID of inserted team
    $teamId = '';
    $prep_stmt = "SELECT id FROM teams WHERE name = ? LIMIT 1";
    $stmt = $conn->prepare($prep_stmt);
 
    if ($stmt) {
      $stmt->bind_param('s', $name);
      $stmt->execute();
      $stmt->bind_result($teamId);
 
      if ($teamId == '') {
        // A user with this username already exists
        $error_msg .= '<p class="error">Team was not successfully inserted</p>';
      }
    } 
    else {
      $error_msg .= '<p class="error">Database error #2</p>';
    }
    $stmt->close();
    // insert team members
    
    //myDump($_POST['member']);
    //myDump($_POST);
    //if(!empty($_POST['member'])){
      //foreach($_POST['member']) as $key => $value){
        
        //$member = $value;
        $member = $_POST['member[0]'];
        if ($insert_stmt = $conn->prepare("INSERT INTO members (team_id, username) VALUES (?, ?)")) {
          $insert_stmt->bind_param('ss', $teamId, $member);
          // Execute the prepared query.
          if (! $insert_stmt->execute()) {
            header('Location: ../error.php?err=Registration failure: INSERT of member');
          }
        }
        
      //}
      
    }
    
    // insert openings
    /*
    foreach($_POST['opening']) as $key=>$value){
      $openingRole = $value;
      // get ID of inserted team
      $roleId = '';
      $prep_stmt = "SELECT id FROM roles WHERE name = ? LIMIT 1";
      $stmt = $conn->prepare($prep_stmt);
 
      if ($stmt) {
        $stmt->bind_param('s', $openingRole);
        $stmt->execute();
        $stmt->bind_result($roleId);
 
        if ($id == '') {
          // A user with this username already exists
          $error_msg .= '<p class="error">Invalid Opening Role</p>';
        }
      } 
      else {
        $error_msg .= '<p class="error">Database error #3</p>';
      }
      $stmt->close();
      if ($insert_stmt = $conn->prepare("INSERT INTO openings (teamId, role) VALUES (?, ?)")) {
        $insert_stmt->bind_param('ss', $teamId, $openingRole);
        // Execute the prepared query.
        if (! $insert_stmt->execute()) {
          header('Location: ../error.php?err=Registration failure: INSERT of opening');
        }
      }
    }
    */
  }
  header('Location: ./register_success.php');
}

function myDump($data) {
    print '<pre>' . print_r($data, true) . '</pre>';
}
