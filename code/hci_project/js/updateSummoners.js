$(document).ready(function(){
  //var summonerNames = "<?php echo $summonerNames ?>";
  var summonerNames = dataFromPhp;
  for(var i=0; i<summonerNames.length; i++){
    var summonerName = summonerNames[i];
    // validate that this is a real LoL summoner
    var promise = getSummonerData(summonerName);
    var dataForPhp = {};
    promise.done( function(summoner_data){
      dataForPhp["summoner_name"] = summonerName;
      dataForPhp["summoner_data"] = summoner_data;
      $.ajax({
        url: "../updateSummoners2.php",
        type: "post",
        data: dataForPhp
      })
      .done(function(ret){
        alert("php returned: " + ret["message"]);
      })
      .fail(function(ret){
        alert("php call failed with message: " + ret["responseText"]);
      });
    });
    promise.fail(function(textStatus){
      //alert("xhr:" + xhr);
      alert("failed with textStatus:" + textStatus);
    });
  }
});
