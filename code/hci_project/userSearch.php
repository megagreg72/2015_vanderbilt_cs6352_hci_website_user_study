<?php
include_once 'includes/db_connect.php';
include_once 'includes/functions.php';

sec_session_start();
?>
<!DOCTYPE html>
<html>
  <head> 
    <link type="text/css" rel="stylesheet" href="style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
    <script src="js/api.js"></script>
    <script src="userSearch.js"></script>
    <title>LoL Dream Team</title>
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
       style="float:left; margin-right:10px;">Team Applicants</a>

    <a href="./userSearch.html"
       style="float:right; margin-left:10px;">Find a Team</a>
    <p style="display:inline; color:#997F3D;">|</p>
  </div>
  <div id="content">
    <?php if (isset($_COOKIE['username'])) : 
      $username = $_COOKIE['username'];
    ?>
      <form action="searchTeam.php" method="post" name="user_login_form">
        Search again with a different LoL username:<br>
        <input type="text" id="box" name="username" size="30">
        <input type="submit" id="button"value="Search"/>
      </form>
      <div id="header3">
      <br><br>
These teams seem like a good match for <?php echo $username; ?>:
      </div><br>
      <div id=searchResults class="item">
      </div>
    </div>
    <div id="footer">
Copyright Brian Gauch 2015 
    </div>
  </div>
  <?php else : ?>
    <span class="error">
You must first <a href="userSearch.html">search</a> for matching teams before viewing results.
    </span>
  <?php endif; ?>
  </body> 
</html>
