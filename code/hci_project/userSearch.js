function getCookie(cname) {
    var name = cname + "=";
    var ca = document.cookie.split(';');
    for(var i=0; i<ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0)==' ') c = c.substring(1);
        if (c.indexOf(name) == 0) return c.substring(name.length,c.length);
    }
    return "";
} 

function hourToStr(hourNum){
  var displayHour = hourNum;
  var ampmStr = "AM";
  if(displayHour > 12){
    displayHour = displayHour - 12;
    ampmStr = "PM";
  }
  // AM and PM are dumb
  if(displayHour == 12){
    if(ampmStr == "AM"){
      ampmStr = "PM";
    }
    else{
      ampmStr = "AM";
    }
  }
  var timeStr = "" + displayHour + ":00 " + ampmStr + " UTC";
  return timeStr;
}

function setIdElement(id){
  $(".summoner-id").append(id);
}

function setMatchesElement(numMatches){
  $(".summoner-matches").append(numMatches);
}

function setDaysElement(days){
  $(".summoner-match-days").append(days);
}

function setTimesElement(times){
  $(".summoner-match-times").append(times);
}

function setResultsElement(data){
  $("#searchResults").append(data);
}

function postApiData(data, callbackFunction){
  $.ajax({
    type: "POST",
    url: "match.php",
    data: data
  }).done( callbackFunction
  );
}

$(document).ready(function() {
  var username = getCookie("username");
  getSummonerId3(username, function(id) {
    //setIdElement(id);
    getSummonerMatches2(id, function(data) {
      var numMatches = data["totalGames"];
      //setMatchesElement(numMatches);
      var times = [];
      var dates = [];
      var daysOfWeekNames = ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"];
      var daysOfWeek = Array.apply(null, Array(7)).map(Number.prototype.valueOf,0);
      var hoursOfDay = Array.apply(null, Array(24)).map(Number.prototype.valueOf,0);
      for(var i = 0; i < numMatches; i++){
        times[i] = data["matches"][i]["timestamp"];
        dates[i] = new Date(times[i]);
        dayOfWeek = dates[i].getDay();
        hourOfDay = dates[i].getHours();
        daysOfWeek[dayOfWeek]++;
        hoursOfDay[hourOfDay]++;
      }

      daysOfWeekStr = "";
      for(var i = 0; i < daysOfWeekNames.length; i++){
        if(daysOfWeekStr != ""){
          daysOfWeekStr += ", ";
        }
        daysOfWeekStr += daysOfWeekNames[i] + ": " + daysOfWeek[i];
      }
      //setDaysElement(daysOfWeekStr);

      timesStr = "";
      for(var i = 0; i < hoursOfDay.length; i++){
        if(timesStr != ""){
          timesStr += ", ";
        }
        timesStr += "[" + hourToStr(i) + "]: " + hoursOfDay[i];
      }
      //setTimesElement(timesStr);
      out_data = {};
      // convert array into map by String day name
      var daysOfWeekMap = {};
      for(var i = 0; i < daysOfWeekNames.length; i++){
        daysOfWeekMap[daysOfWeekNames[i]] = daysOfWeek[i];
      }
      out_data["playDays"] = daysOfWeekMap;
      out_data["playHours"] = hoursOfDay;
      out_data["numMatches"] = numMatches;
      getSummonerLeagues2(id, function(leagues){
        var soloLeague = "unranked";
        if(leagues){
          var summonerLeagues = leagues[id];
          if(summonerLeagues){
            for(var i = 0; i < summonerLeagues.length; i++){
              var league = summonerLeagues[i];
              var queueName = league["queue"];
              var tierName = league["tier"];
              if(queueName == "RANKED_SOLO_5x5"){
                soloLeague = tierName.toLowerCase();
              }
            }
          }
        }
        var soloLeagueNum;
        var leagues = ["challenger", "master", "diamond", "platinum", "gold", "silver", "bronze", "unranked"];
        for(var i = 0; i < leagues.length; i++){
          if(leagues[i] === soloLeague){
            soloLeagueNum = i;
         }
        }
        out_data["league"] = soloLeagueNum;
        postApiData(out_data, function(php_response){
          setResultsElement(php_response);
          // put on page
        });
      });
    });
  },
  function(){
    alert("Oops! Could not find a summoner with that name in North America.")
  });
  //getSummonerId(username, setIdElement);
});
