<?php
include 'includes/db_connect.php';
include 'includes/psl-config.php';

$error_msg = "";

//printArray($_POST);

function printArray($array){
     foreach ($array as $key => $value){
        echo "$key => $value";
        if(is_array($value)){ //If $value is an array, print it as well!
            printArray($value);
        }  
    } 
}

function displayResult($teamId){
  $teamName = getTeamName($teamId);
  $description = "lorem ipsum doler sit amet";
  $str = "<div id='header3'>" . $teamName . "</div>";
  //$str .= "<div id='list'> <div id='item'> " . $description . "</div></div>";
  $str .= "<div id='list'> <div id='item'> " . $description . "</div></div>";
  echo $str;
}

function getMatches(){
  $teamId1 = "4";
  $teamId2 = "5";
  // in order of match strenght
  $matches = [$teamId1, $teamId2];
  return $matches;
}

function getTeamName($teamId)
{
  $teamName;
  $prep_stmt = "SELECT name FROM teams WHERE id = ? LIMIT 1";
  $stmt = $mysqli->prepare($prep_stmt);
  if ($stmt) {
    $stmt->bind_param('s', $teamId);
    $stmt->execute();
    //$stmt->store_result();
    if ($result = $stmt->store_result()) {
      while ($row = $result->fetch_row()) {
        $teamName = $row[0];
      }
      $result->free();
    }
  }
  else{
    error_log("failed to get team name");
  }
  $stmt.close();
}

if (isset($_POST['playDays'], $_POST['playHours'], $_POST['numMatches'])) {
  // Sanitize and validate the data passed in
  $playDays = $_POST['playDays'];
  $playHours = $_POST['playHours'];
  $numMatches = filter_input(INPUT_POST, 'numMatches', FILTER_SANITIZE_STRING);
  
  $matches = getMatches();
  foreach($matches as $value)
  {
    echo displayResult($value);
  }
  
  /*
  var_dump($playDays);
  error_log("playDays = " . $playDays["0"] . $playDays[1]);
  //error_log("playHours = " . $playHours);
  error_log("numMatches = " . $numMatches);
  */
}
else{
  echo "missing a required input";
  error_log("Oh no! Missing a required POST value.");
}
