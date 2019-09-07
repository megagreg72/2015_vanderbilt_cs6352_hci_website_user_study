<?php
include_once 'includes/db_connect.php';
include_once 'includes/psl-config.php';

  $email = "foo@bar.com";
  $prep_stmt = "SELECT id FROM teams WHERE email = ? LIMIT 1";
  $stmt = $mysqli->prepare($prep_stmt);
 
  // check existing email  
  if ($stmt) {
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows == 0) {
      echo "didn't find it";
    }
    else{
      echo "found it";
    }
    echo "<br>" . $stmt->num_rows;
  }
  else{
    echo "<br>I blew up";
  }
  $stmt->close();
