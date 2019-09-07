<link type="text/css" rel="stylesheet" href="style.css">
<html>
   <head> <title>LoL Dream Team</title> </head> 
<script type="text/javascript" style="margin:0 auto;" src="jscharts.js"></script>
   <body> 
   <div id="header">
      LoL Dream Team
   </div>
   <div id="menu">
      <a href="./index.html">Home</a> |
      <a href="./login_form.php">Login</a> |
      <a href="./register.php">Register</a> |
      <a href="./teamProfile.html">Your Team Profile</a> |
      <a href="./teamApplicants.html">Your Team Applicants</a>
   </div>
   <div id="content">
   <div id="header3"> Team Hours Login</div>
      <div id="list"><div id="item">
<div id="graph"></div>
<script type="text/javascript" style="margin:0 auto;">
    var mon = 60;
    var tues = 70;
    var wed = 10;
    var thurs = 80;
    var fri = 15;
    var sat = 85;
    var sun = 90;
	myData = new Array(['Mon', mon], ['Tues', tues], ['Wed', wed], 
                       ['Thurs', thurs], ['Fri', fri], ['Sat', sat], ['Sun', sun]);
	var myChart = new JSChart('graph', 'bar');
	myChart.setDataArray(myData);
	myChart.setBarColor('#997F3D');
	myChart.setTitlePosition('left');
	myChart.setTitle('The daily play data:');
	myChart.setTitleColor('#555555');
	myChart.setAxisColor('#555555');
	myChart.setAxisNameColor('#555555');
	myChart.setAxisValuesColor('#555555');
	myChart.setAxisNameX('Days');
	myChart.setAxisNameY('Hours');
	myChart.setTitleFontSize(12);
	myChart.setTextPaddingTop(30);
	myChart.setSize(350, 150);
	myChart.draw();
</script>
</body>
</html>
      </div></div>
   </div>
   <div id="footer">
      Copyright Brian Gauch 2015 
   </div>
   </body> 
</html>

