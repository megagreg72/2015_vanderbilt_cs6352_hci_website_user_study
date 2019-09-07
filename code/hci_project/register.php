<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>LoL Dream Team</title>
    <script type="text/JavaScript" src="js/sha512.js"></script> 
    <script type="text/JavaScript" src="js/forms.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.14.0/jquery.validate.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.14.0/additional-methods.min.js"></script>
    <script type="text/Javascript" src="js/api.js"></script>
    <script type="text/Javascript" src="js/registerNoRefresh.js"></script>
    <link rel="stylesheet" href="style.css" />
    <style>
      label.error { width: 250px; display: inline; color: red;}
    </style>
    </head>
    <body>
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

      <a href="./userSearch.html"
         style="float:right; margin-left:10px;">Find a Team</a>
      <p style="display:inline; color:#997F3D;">|</p>
    </div>
    <div id="content">
        <div id="header2">Team Registration</div>
        <!-- Registration form to be output if the POST variables are not
        set or if the registration script caused an error. -->
        <?php
        if (!empty($error_msg)) {
            echo $error_msg;
        }
        ?>
        <form enctype="multipart/form-data"
              action=""
              method="post"
              name="registration_form"
              id="registration_form">
        <div class="item">
            Team name: 
            <input type='text' name='name' id='name' class='box'/>
        </div>
        <div class="item" id="member_area">
	    Current team members' LoL summoner names (max total members is 9):<br>
              <div id='member1' style='margin-bottom:4px;' class='member-group'>
		<input type='text' name='member1' class='member' id='box'/>
              </div>
              <div>
                <input type='button' name='btnAddMember' id='btnAddMember' value='Add a member' />
                <input type='button' name='btnDelMember' id='btnDelMember' value='Remove a member' />
              </div>
        </div>
        <div class='item' id="opening_area">
	    Openings for new members (max total members is 9):<br>
              <div id='opening1' style='margin-bottom:4px;' class='opening-group'>
                <select name='opening1' class='opening' id='box'>
                  <option value="any">Any</option>
                  <option value="adc">AD Carry</option>
                  <option value="support">Support</option>
                  <option value="mid">Mid</option>
                  <option value="top">Top</option>
                  <option value="jungler">Jungler</option>
                </select><br>
              </div>
              <div>
                <input type='button' name='btnAddMember' id='btnAddOpening' value='Add an opening' />
                <input type='button' name='btnDelOpening' id='btnDelOpening' value='Remove an opening' />
              </div>
        </div>
        <div class='item'>
            Team description:<br><textarea
                name='description' 
                id='description'
                class='box' 
		cols='40'
		rows = '5'
		></textarea>
        </div>
        <div class='item'>
            Email: <input type='text' name='email' id='email' class='box' /><br>
        </div>
        <div class="item">
            <p>Passwords must be 6 or more characters and must contain:
                <ul class="tab">
                    <li>At least one uppercase letter (A..Z)</li>
                    <li>At least one lowercase letter (a..z)</li>
                    <li>At least one number (0..9)</li>
                </ul>
            </p>
            Password: <input type="password"
                             name="password" 
                             id="password"
                             class="box"/><br>
        </div>
        <div class="item">
            Confirm password: <input type="password" 
                                     name="confirmpwd" 
                                     id="confirmpwd"
                                     class="box" /><br>
        </div>
        <div class="item">
            <input type="submit" 
                   name="submit"
		   class="button"
                   value="Register" 
            /><br>
      </form>
      <!-- We will output the results from registerNoRefresh2.php here -->
      <div id="callback-results"><div>
Already have a registered team? Return to the <a href="login_form.php">login page</a>.
   </div>
   <div id="footer">
      Copyright Brian Gauch 2015 
   </div>
   </body> 
</html>
