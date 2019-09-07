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
  var dfd = $.Deferred();
  $.ajax({
    url: urlToCall,
    done: function(data) {
      //alert("ajax succIess!");
      dfd.resolve(data);
    },
    fail: function(XMLHttpRequest, textStatus, errorThrown) {
      //alert("ajax success!");
      dfd.reject('Ajax error: ' + errorThrown 
               + "<br> Status:" + textStatus);
    }
  });
  return dfd.promise();
}


function makeApiCall3(urlToCall, successFunction, failureFunction){
  //alert("calling url: " + urlToCall);
  var promise = $.ajax({
     url: urlToCall,
     timeout: 3000 //3 second timeout
  });
  promise.done(function(data) {
    //alert("ajax success!");
    successFunction(data);
  });
  promise.fail(function(jqXHR, textStatus) {
    if(textStatus === 'timeout')
    {
      alert("failed from timeout");
    }
    //alert("ajax failure!");
    failureFunction(jqXHR, textStatus);
  });
}

function makeApiCall2(urlToCall, callbackFunction){
  //alert("calling url: " + urlToCall);
  $.ajax({
     url: urlToCall
  }).done(function(data) {
       //alert("ajax success!");
       callbackFunction(data);
  }).fail(function() {
       //alert("ajax failure");
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
  ).done(function(api_data){
    var nameNoPlus = summonerName.replace(/\+/g, "");
    var nameNoSpaces = nameNoPlus.replace(/\s/g, '');
    var lowerCaseName = nameNoSpaces.toLowerCase();
    var idStr = "" + data[lowerCaseName].id;
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
    var nameNoPlus = summonerName.replace(/\+/g, "");
    var nameNoSpaces = nameNoPlus.replace(/\s/g, '');
    var lowerCaseName = nameNoSpaces.toLowerCase();
    var idStr = "" + data[lowerCaseName].id;
    callbackFunction(idStr);
  });
}

function getSummonerId3(summonerName, callbackFunction, failureCallback){
  // name is part of the url, not an official argument
  var nameNoPlus = summonerName.replace(/\+/g, '');
  var baseRequest = "v1.4/summoner/by-name/" + nameNoPlus;
  var argNames = [];
  var args = [];
  var url = getApiUrl(baseRequest, argNames, args);
  makeApiCall3(url, function(data){
    var nameNoSpaces = nameNoPlus.replace(/\s/g, '');
    var lowerCaseName = nameNoSpaces.toLowerCase();
    var idStr = "" + data[lowerCaseName].id;
    callbackFunction(idStr);
  },
  function(jqXHR, textStatus){
    failureCallback(jqXHR, textStatus);
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
  makeApiCall3(url, callbackFunction, function(error){
    fakeData = {
     "totalGames": 0,
     "startIndex": 0,
     "endIndex": 0
    }
    callbackFunction(fakeData);
  });
}

function getSummonerLeagues2(summonerId, callbackFunction){
  var baseRequest = "v2.5/league/by-summoner/" + summonerId;
  var argNames = [];
  var args = [];
  var url = getApiUrl(baseRequest, argNames, args);
  makeApiCall3(url, callbackFunction, function(error){
    fakeData = {};
    callbackFunction(fakeData);
  });
}

function getSummonerData(summonerName){
  var dfd = $.Deferred();
  var out_data = {};
  out_data["name"] = summonerName;
  getSummonerId3(summonerName, function(id)
  {
    out_data["id"] = id;
    getSummonerMatches2(id, function(api_matchlist)
    {
      var api_totalGames = api_matchlist["totalGames"];
      var roles = {};
      roles["sup"] = 0;
      roles["adc"] = 0;
      roles["top"] = 0;
      roles["mid"] = 0;
      roles["jng"] = 0;
      var daysOfWeek = {0:0,1:0,2:0,3:0,4:0,5:0,6:0};
      //var daysOfWeek = Array.apply(null, Array(7)).map(Number.prototype.valueOf,0);
      var hoursOfDay = {0:0,1:0,2:0,3:0,4:0,5:0,
                        6:0,7:0,8:0,9:0,10:0,11:0,
                        12:0,13:0,14:0,15:0,16:0,17:0,
                        18:0,19:0,20:0,21:0,22:0,23:0};
      //var hoursOfDay = Array.apply(null, Array(24)).map(Number.prototype.valueOf,0);
      for(var i = 0; i < api_totalGames; i++){
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

      var daysOfWeekNames = ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"];
      var daysOfWeekMap = {};
      for(var i = 0; i < daysOfWeekNames.length; i++){
        daysOfWeekMap[daysOfWeekNames[i]] = daysOfWeek[i];
      }

      out_data["num_matches"] = api_totalGames;
      out_data["roles"] = roles;
      out_data["playHours"] = hoursOfDay;
      out_data["playDays"] = daysOfWeekMap;
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
        out_data["league"] = soloLeague;
        dfd.resolve(out_data);
      });
    }//,
    //function(errorStr){
    //  alert("bad1");
    //  dfd.reject("failure getting matches for summoner " + summonerName
    //    + ".<br>Caused by: " + errorStr);
    //}
    );
  },
  function(jqXHR, textStatus){
    dfd.reject("No LoL user with the name [" + summonerName
      + "] exists in North America.");
  });
  return dfd.promise();
}
