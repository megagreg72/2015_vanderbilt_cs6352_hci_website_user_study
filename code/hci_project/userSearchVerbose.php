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
  <?php if (isset($_COOKIE['username'])) : 
	$username = $_COOKIE['username'];
   ?>
    <div id="header">
      LoL Dream Team
    </div>
    <div id="menu">
      <a href="./index.html">Home</a> |
      <a href="./userSearch.html">Find a Team</a>
    </div>
    <div id="content">
      <div id="item">
Some data about you which we used to match:
        <div id="item" class="summoner-name">
Username: <?php echo $username; ?>
        </div>
        <div id="item" class="summoner-id">
Summoner ID: 
        </div>
        <div id="item" class="summoner-matches">
Matches: 
        </div>
        <div id="item" class="summoner-match-days">
Match Days: 
        </div>
        <div id="item" class="summoner-match-times">
Match Times: 
        </div>
      </div><br>
      <div id="header3">
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
You need to specify a LoL username before you can search for a team.
    </span>
    <br>Please <a href="userSearch.html">tell us your username</a>.
  <?php endif; ?>
  </body> 
</html>
