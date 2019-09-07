<?php 
 if (isset($_POST['username'])) {
  $username = $_POST['username'];
  // set the cookie with the submitted user data
  setcookie('username', $username);
  // redirect the user to final landing page so cookie info is available
  header("Location:userSearch.php");
 } else {
  echo "<b>username:</b>".$_COOKIE['username'];
 }
?>
