<?php
include_once 'includes/db_connect.php';
include_once 'includes/functions.php';
 
sec_session_start();
?>

<!DOCTYPE html> 
<html>
  <head> 
     <title>LoL Dream Team</title> 
     <script type="text/JavaScript" src="js/sha512.js"></script> 
     <script type="text/JavaScript" src="js/forms.js"></script>
     <link type="text/css" rel="stylesheet" href="style.css">
  </head> 
  <body> 
  <div id="header">
    <a href="./index.html">LoL Dream Team</a>
  </div>
  <div id="menu">
    <a href="./login_form.php" 
       style="float:left; margin-right:10px; text-decoration:underline;">Team Login</a>
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
      <div id="header2"> Team Login</div>
      <?php
        if (isset($_GET['error'])) {
            echo '<p class="error">Error Logging In!</p>';
        }
        ?> 
      <div id="item">
Enter your email and password to manage your team profile and see your applicants.  
      </div>
      <div id="item">
	     If you don't have an account yet, please 
		<a href=register.php> register</a>.
      </div>
         <form action="includes/process_login.php" method="post" name="login_form">                      
            Email: <input type="text" name="email" id="box"/>
            Password: <input type="password" 
                             name="password" 
                             id="box"/>
            <input type="button" 
                   value="Login" 
                   id="button"
                   onclick="formhash(this.form, this.form.password);" /> 
        </form>
        <?php
          if (login_check($conn) == true) {
          echo '<p>Currently logged in as ' . $_SESSION['name'] . '.</p>';
           echo '<p>Do you want to change team? <a href="includes/logout.php">Log out</a>.</p>';
          }
        ?>      
   <div id="footer">
   </div>
      Copyright Brian Gauch 2015 
   </div>
   </body> 
</html>
