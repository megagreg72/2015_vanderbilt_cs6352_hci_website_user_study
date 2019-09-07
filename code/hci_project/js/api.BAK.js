// Just a bunch of helper functions related to the LoL API

function getApiUrl(baseRequest, argNames, args){
  var apiKey = "a31d004f-fdc9-470e-84b2-5c8a9ced62b1";
  var region = "na";
  var baseUrl = "https://" + region + ".api.pvp.net/api/lol/" + region + "/";
  
  var getChar="?";
  var argsStr = "";
  var numArgs = args.length;
  var numArgNames = argNames.length;
  if(numArgs != numArgNames){
    alert("oops! Wrong number of args");
  }
  for(var i = 0; i < numArgs; i++){
    argsStr = argsStr + getchar + argNames[i] + "=" + args[i];
    getChar = "&";
  }
  var url = baseUrl + baseRequest + argsStr + getChar + "api_key=" + apiKey;
  return url;
}


function makeApiCall1(urlToCall){
  //alert("calling url: " + urlToCall);
  return $.Deferred(function(dfd){
    $.ajax({
      url: urlToCall,
      success: function(data) {
        //alert("ajax succIess!");
        dfd.resolve(data);
      },
      error: function(XMLHttpRequest, textStatus, errorThrown) {
        //alert("ajax success!");
        dfd.reject('Ajax error: ' + errorThrown 
                 + "<br> Status:" + textStatus);
      }
    });
  }).promise();
}


function makeApiCall3(urlToCall, successFunction, failureFunction){
  //alert("calling url: " + urlToCall);
  $.ajax({
     url: urlToCall,
     success: function(data) {
       //alert("ajax succIess!");
       successFunction(data);
     },
     error: function(XMLHttpRequest, textStatus, errorThrown) {
       //alert("ajax success!");
       failureFunction();
     }
  });
}

function makeApiCall2(urlToCall, callbackFunction){
  //alert("calling url: " + urlToCall);
  $.ajax({
     url: urlToCall,
     success: function(data) {
       //alert("ajax success!");
       callbackFunction(data);
     }
  });
}

function getSummonerId1(summonerName){
  // name is part of the url, not an official argument
  var baseRequest = "v1.4/summoner/by-name/" + summonerName;
  var argNames = [];
  var args = [];
  var url = getApiUrl(baseRequest, argNames, args);
  // consume the old Deferred and return a new Deferred,
  // after extracting the relevant information
  var dfd = $.Deferred();
  $.when(
    makeApiCall1(url)
  ).success(function(api_data){
    var idStr = "" + data[summonerName].id;
    dfd.resolve(idstr);
  })
  .fail( function(errorStr){
    dfd.reject('Failure getting id of summoner: ' 
               + summonerName + '.<br>Caused by: ' + errorStr);
  });
  return dfd.promise();
}

function getSummonerId2(summonerName, callbackFunction){
  // name is part of the url, not an official argument
  var baseRequest = "v1.4/summoner/by-name/" + summonerName;
  var argNames = [];
  var args = [];
  var url = getApiUrl(baseRequest, argNames, args);
  makeApiCall2(url, function(data){
    var idStr = "" + data[summonerName].id;
    callbackFunction(idStr);
  });
}

function getNumSummonerMatches2(summonerId, callbackFunction){
  var baseRequest = "v2.2/matchlist/by-summoner/" + summonerId;
  var argNames = [];
  var args = [];
  var url = getApiUrl(baseRequest, argNames, args);
  makeApiCall2(url, function(data){
    var ret = data["totalGames"];
    callbackFunction(ret);
  });
}

function getSummonerMatches1(summonerId){
  var baseRequest = "v2.2/matchlist/by-summoner/" + summonerId;
  var argNames = [];
  var args = [];
  var url = getApiUrl(baseRequest, argNames, args);
  return makeApiCall1(url);
}

function getSummonerMatches2(summonerId, callbackFunction){
  var baseRequest = "v2.2/matchlist/by-summoner/" + summonerId;
  var argNames = [];
  var args = [];
  var url = getApiUrl(baseRequest, argNames, args);
  makeApiCall2(url, callbackFunction);
}

function getSummonerData(summonerName){
  var dfd = $.Deferred();
  $.when( 
    getSummonerId1(summonerName)
  ).success( function(id) 
  {
    //setIdElement(id);
    $.when(
      getSummonerMatches1(id)
    ).success( function(api_matchlist) 
    {
      var roles = [];
      roles["sup"] = 0;
      roles["adc"] = 0;
      roles["top"] = 0;
      roles["mid"] = 0;
      roles["jng"] = 0;
      var daysOfWeek = Array.apply(null, Array(7)).map(Number.prototype.valueOf,0);
      var hoursOfDay = Array.apply(null, Array(24)).map(Number.prototype.valueOf,0);
      for(var i = 0; i < totalGames; i++){
        var api_timestamp = api_matchlist["matches"][i]["timestamp"];
        var date = new Date(api_timestamp);
        dayOfWeek = date.getDay();
        hourOfDay = date.getHours();
        daysOfWeek[dayOfWeek]++;
        hoursOfDay[hourOfDay]++;

        var api_role = api_matchlist["matches"][i]["role"];
        var api_lane = api_matchlist["matches"][i]["lane"];
        if(api_role == "DUO_SUPPORT"){
          roles["sup"]++;
        }
        else if(api_role == "DUO_CARRY"){
          roles["adc"]++;
        }
        else if(api_lane == "TOP"){
          roles["top"]++;
        }
        else if(api_lane == "MID" || api_lane == "MIDDLE"){
          roles["mid"]++;
        }
        else if(api_lane == "JUNGLE"){
          roles["jng"]++;
        }
        // otherwise, we aren't sure what role they played,
        // so just ignore this match
      }
      var api_totalGames = api_matchlist["totalGames"];

      var out_data = [];
      out_data["num_matches"] = api_totalGames;
      out_data["roles"] = roles;
      out_data["playHours"] = hoursOfDay;
      out_data["playDays"] = daysOfWeek;

      dfd.resolve(out_data);
    })
    .fail( function(errorStr){
      dfd.reject("failure getting matches for summoner " + summonerName
        + ".<br>Caused by: " + errorStr);
    });
  })
  .fail( function(errorStr){
    dfd.reject("failure getting id for summoner " + summonerName
      + ".<br>Caused by: " + errorStr);
  });
  return dfd.promise();
}
