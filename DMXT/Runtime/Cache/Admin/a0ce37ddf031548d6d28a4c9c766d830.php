<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
    
    <link type="text/css" href="/Public/css/style.css" rel="stylesheet" />
<script src="/Public/js/jquery-1.9.1.min.js" language="javascript"></script>
<!-- <script type="text/javascript" src="/Public/js/default.js"></script> -->
<script language="JavaScript">  
	function startTime()     
	{     
		var today=new Date();//定义日期对象     
		var yyyy = today.getFullYear();//通过日期对象的getFullYear()方法返回年      
		var MM = today.getMonth()+1;//通过日期对象的getMonth()方法返回年      
		var dd = today.getDate();//通过日期对象的getDate()方法返回年       
		var hh=today.getHours();//通过日期对象的getHours方法返回小时     
		var mm=today.getMinutes();//通过日期对象的getMinutes方法返回分钟     
		var ss=today.getSeconds();//通过日期对象的getSeconds方法返回秒     
		// 如果分钟或小时的值小于10，则在其值前加0，比如如果时间是下午3点20分9秒的话，则显示15：20：09     
		MM=checkTime(MM);  
		dd=checkTime(dd);  
		mm=checkTime(mm);     
		ss=checkTime(ss);      
		var day; //用于保存星期（getDay()方法得到星期编号）  
		if(today.getDay()==0)   day   =   "星期日 "   
		if(today.getDay()==1)   day   =   "星期一 "   
		if(today.getDay()==2)   day   =   "星期二 "   
		if(today.getDay()==3)   day   =   "星期三 "   
		if(today.getDay()==4)   day   =   "星期四 "   
		if(today.getDay()==5)   day   =   "星期五 "   
		if(today.getDay()==6)   day   =   "星期六 "   
		document.getElementById('nowDateTimeSpan').innerHTML=yyyy+"-"+MM +"-"+ dd +" " + hh+":"+mm+":"+ss+"   " + day;     
		setTimeout('startTime()',1000);//每一秒中重新加载startTime()方法   
	}     
	  
	function checkTime(i)     
	{     
		if (i<10){  
			i="0" + i;  
		}     
		  return i;  
	}    
</script> 
<style type="text/css">

body{ background:#e4f6ff;}
.welcome{
	width:680px;
	padding-right:70px;
	height:400px;
	position:absolute;
	top:50%;
	left:50%;
	margin-top:-250px;
	margin-left:-375px;
	background:url(/Public/images/welcomebg.jpg) 0 0 no-repeat #e4f6ff;
	overflow:hidden;
	}
.come{
	padding-top:120px;
	text-align:center;}
.date{
	font-size:16px;
	text-align:center;
	font-weight:bold;
	padding-top:30px;
	line-height:30px;
	color:#046eaa;
	}	
</style>

</head>
<body onload="startTime()">
<div class="welcome">
<p class="come"><img src="/Public/images/welcome.png" ></p>
<p class="date">当前时间：<span id="nowDateTimeSpan"></span></p>

</div>

</body>
</html>