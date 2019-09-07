function barGraphHelper(graphElementId, numApplicants, barData){
  //alert("trying ID: " + graphElementId);
  var baseFigWidth = 50;
  var figWidthPerBar = 200;
  var figWidth = baseFigWidth + (figWidthPerBar*(numApplicants+1));
  var applicantColors = ['#D6CCB1', '#C2B28B', '#AD9964', '#997F3D'];
  var teamColor = '#000000';
  var barColors = [];
  for (i=0; i<numApplicants; i++){
    barColors[i] = applicantColors[i];
  }
  barColors[numApplicants] = teamColor;

  var myChart = new JSChart(graphElementId, 'bar');
  myChart.setDataArray(barData);
  //myChart.colorizeBars(barColors);
  for(i=0; i<barColors.length; i++){
    myChart.setBarColor(barColors[i], i+1);
  }
  myChart.setBarValuesColor('#000000');
  //myChart.setTitlePosition('left');
  myChart.setTitle('');
  //myChart.setTitleColor('#555555');
  myChart.setAxisColor('#555555');
  myChart.setAxisNameColor('#000000');
  myChart.setAxisValuesColor('#000000');
  myChart.setAxisNameX('Days');
  myChart.setAxisNameY('Matches');
  //myChart.setTitleFontSize(16);
  myChart.setAxisNameFontSize(16);
  myChart.setAxisValuesFontSize(16);
  myChart.setAxisPaddingBottom(50);
  myChart.setAxisPaddingLeft(70);
  myChart.setBarValuesFontSize(16);
  myChart.setLabelFontSize(16);
/*
  myChart.setLegendShow(true);
  myChart.setLegendPosition('right top');
  myChart.setLegendColor('#000000');
  myChart.setLegendFontSize(16);
  for(i=0; i<numApplicants; i++){
    myChart.setLegendForBar(i+1, ('applicant' + (i+1)));
  }
  myChart.setLegendForBar(numApplicants+1, 'your team');
*/
  myChart.setTextPaddingTop(30);
  myChart.setSize(figWidth, 225);
  myChart.draw();
  
}

function createBarGraph(graphElementId, data){
  var teamDays = data["team"];
  var keys = [];
  for (var key in data){
    if (data.hasOwnProperty(key)) {
      keys.push(key);
    }
  }
  var applicantsDays = [];
  for(var i=0; i<keys.length; i++){
    var key = keys[i];
    if(key != "team"){
      var applicationId = parseInt(key);
      var applicantDays = data[key];
      applicantsDays[i] = applicantDays;
    }
  }
  var numApplicants = applicantsDays.length;
 
  var dayLabels = ['Mon', 'Tue', 'Wed', 'Thurs', 'Fri', 'Sat', 'Sun'];
  var dataDayKeys = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
  barData = [];
  for(var i=0; i<7; i++){
    dataDayKey = dataDayKeys[i];
    barData[i] = [];
    barData[i][0] = dayLabels[i];
    for(var j=0; j<(applicantsDays.length); j++){
      barData[i][j+1] = applicantsDays[j][dataDayKey];
    }
    barData[i][numApplicants+1] = teamDays[dataDayKey];
  }
  for(var i=0; i<7; i++){
  }

  barGraphHelper(graphElementId, numApplicants, barData);
}

var alreadyDidStuff = false;
$(document).ready(function () {
    // render legends using colors from PHP
    //alert("ready!");
    var legendElements = document.getElementsByClassName("legendCanvas");
    for(i=0; i<legendElements.length; i++){
      var legendElement = legendElements[i];
      var desiredColor = legendElement.getAttribute("legendColor");
      var ctx = legendElement.getContext("2d");
      ctx.fillStyle = desiredColor;
      ctx.fillRect(0,0,15,15);
    }
    if(!alreadyDidStuff){
      // render bar charts
      var data = dataFromPhp;
      for (var key in data){
        if (data.hasOwnProperty(key)) {
          var openingId = key;
          var openingData = data[openingId];
          var elementName = "opening" + openingId + "DayGraph";
          createBarGraph(elementName, openingData);
        }
      }
      //alert("done with graphs!");
      alreadyDidStuff = true;
    }
});
