<?php
include_once 'includes/functions.php';
include_once 'includes/db_functions.php';
sec_session_start();
?>

<link type="text/css" rel="stylesheet" href="style.css">
<html>
  <head> 
    <title>LoL Dream Team</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.14.0/jquery.validate.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.14.0/additional-methods.min.js"></script>
    <script type="text/Javascript" src="js/api.js"></script>
    <script type="text/javascript" src="js/updateSummoners.js"></script>
  </head>
  <body>
  <div id="header">
    LoL Dream Team
  </div>
  </head>
</html>

<?php
        $summonerNames = [];
        //$summonerNames = getAllSummonerNames($conn);
        //$summonerNamesToProcess = ["tpx imagine"];
        $name = $_GET["name"];
        $summonerNamesToProcess = [];
        $summonerNamesToProcess[0] = $name;
        // pass a bunch of data to javascript
        echo '<script>';
        echo 'var dataFromPhp = ' . json_encode($summonerNamesToProcess) . ';';
        echo '</script>';

        //echo '<script type="text/javascript"> var fromPhp=7;</script>';
        //echo '$(document).ready(function(){var summonerNames = ' . json_encode($summonerNames) . ';for(var i=0; i<summonerNames.length; i++){var summonerName = summonerNames[i];var promise = getSummonerData(summonerName);promise.done( function(summoner_data){dataForPhp["summoner_name"] = summonerName;dataForPhp["summoner_data"] = summoner_data;$.ajax({url: "updateSummoners2.php",type: "post",data: dataForPhp}).done(function(ret){alert("php returned: " + ret["message"]);}).fail(function(ret){alert("php call failed with message: " + ret["responseText"]);});promise.fail(function(textStatus){alert("failed with textStatus:" + textStatus);});});}});';
        echo '</script>';
        //foreach($summonerNames as $summonerName){
          //echo '<script type="text/javascript" src="js/updateSummoners.js">'
          //     , '</script>'
        //}
?>
