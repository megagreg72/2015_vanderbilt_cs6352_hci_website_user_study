<?php
include_once 'register.inc.php';
include_once 'includes/functions.php';
?>
<!DOCTYPE html>
<html>
  <head>
        <meta charset="UTF-8">
        <title>LoL Dream Team</title>
        <script type="text/JavaScript" src="js/sha512.js"></script> 
        <script type="text/JavaScript" src="js/forms.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
        <!--
        <script type="text/javascript" src="http://code.jquery.com/jquery-1.7.1.min.js"></script>
        --!>
        <link rel="stylesheet" href="style.css" />
  </head>
  <div id="header">
    <a href="./index.html">LoL Dream Team</a>
  </div>
  <div id="menu">
    <a href="./login_form.php" 
       style="float:left; margin-right:10px;">Team Login</a>
    <a href="./register.php"
       style="float:left; margin-right:10px; text-decoration:underline;">Team Register</a>
    <a href="./teamProfile.php"
       style="float:left; margin-right:10px;">Team Profile</a>
    <a href="./teamApplicants.php" 
       style="float:left; margin-right:10px;">Team Applicants</a>

    <a href="./userSearch.php" 
       style="float:right; margin-left:10px;">Search Results</a>
    <a href="./userSearch.html"
       style="float:right; margin-left:10px;">Find a Team</a>
    <p style="display:inline; color:#997F3D;">|</p>
  </div>
  <body>
  <div id="content">
        <div id="header2">Team Registration</div>
        <!-- Registration form to be output if the POST variables are not
        set or if the registration script caused an error. -->
        <?php
        if (!empty($error_msg)) {
            echo $error_msg;
        }
        ?>
        <ul>
            <li>Unless otherwise noted, text fields may contain only digits, upper and lowercase letters and underscores.</li>
            <li>Only Usernames must match official LoL data.</li>
        </ul>
	<br>
        <form action="<?php echo esc_url($_SERVER['PHP_SELF']); ?>" 
                method="post" 
                name="registration_form">
        <div id="item">
            Team name: 
            <input type='text' name='name' id='box'/>
        </div>
        <div id="item">
	    Current team members' LoL usernames (at least 1, up to 8):<br>
              <div id='member1' style='margin-bottom:4px;' class='clonedInput_member'>
		<input type='text' name='member1' id='box'/>
              </div>
              <div>
                <input type='button' id='btnAddMember' value='Add a member' />
                <input type='button' id='btnDelMember' value='Remove a member' />
              </div>
        </div>
        <div id='item'>
	    Openings for new members (at least 1, up to 8):<br>
              <div id='opening1' style='margin-bottom:4px;' class='clonedInput_opening'>
                <select name='opening1' id='box'>
                  <option value="any">Any</option>
                  <option value="adc">AD Carry</option>
                  <option value="support">Support</option>
                  <option value="mid">Mid</option>
                  <option value="top">Top</option>
                  <option value="jungler">Jungler</option>
                </select><br>
		<!--  <input type='text' name='opening1' id='box'/>  --!>
              </div>
              <div>
                <input type='button' id='btnAddOpening' value='Add an opening' />
                <input type='button' id='btnDelOpening' value='Remove an opening' />
              </div>
        </div>
        <div id='item'>
            Team description:<br><textarea
                name='description' 
                id='box' 
		cols='40'
		rows = '5'
		></textarea>
        </div>
        <div id='item'>
            Email: <input type='text' name='email' id='box' /><br>
        </div>
        <div id="item">
            <p>Passwords must be 6 or more characters and must contain:
                <ul class="tab">
                    <li>At least one uppercase letter (A..Z)</li>
                    <li>At least one lowercase letter (a..z)</li>
                    <li>At least one number (0..9)</li>
                </ul>
            </p>
            Password: <input type="password"
                             name="password" 
                             id="box"/><br>
        </div>
        <div id="item">
            Confirm password: <input type="password" 
                                     name="confirmpwd" 
                                     id="box" /><br>
        </div>
        <div id="item">
            <input type="button" 
		   id = "button"
                   value="Register" 
                   onclick="return regformhash(this.form,
                                   this.form.name,
				   this.form.description,
                                   this.form.email,
                                   this.form.password,
                                   this.form.confirmpwd);" /> 
	</div>
      </form>
Already have a registered team? Return to the <a href="login_form.php">login page</a>.
   </div>
   <div id="footer">
      Copyright Brian Gauch 2015 
   </div>
   </body> 
   <script type="text/JavaScript" src="js/dynamicForms.js"></script>
</html>
