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
  //getSummonerId("froggen", setIdElement);
  getSummonerId2(username, function(id) {
    setIdElement(id);
    getSummonerMatches2(id, function(data) {
      var numMatches = data["totalGames"];
      setMatchesElement(numMatches);
      var times = [];
      var dates = [];
      var daysOfWeekNames = ["Sun", "Mon", "Tue", "Wed", "Thur", "Fri", "Sat"];
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
      setDaysElement(daysOfWeekStr);

      timesStr = "";
      for(var i = 0; i < hoursOfDay.length; i++){
        if(timesStr != ""){
          timesStr += ", ";
        }
        timesStr += "[" + hourToStr(i) + "]: " + hoursOfDay[i];
      }
      setTimesElement(timesStr);
      out_data = {};
      //out_data["playDays"] = daysOfWeek;
      out_data["playDays"] = daysOfWeek;
      out_data["playHours"] = hoursOfDay;
      out_data["numMatches"] = numMatches;

      postApiData(out_data, function(php_response){
        setResultsElement(php_response);
        // put on page
      });
    });
  });
  //getSummonerId(username, setIdElement);
});
