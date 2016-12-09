<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="Shortcut Icon" href="/favicon.ico">
	<title>安徽职业技术学院—在线点名系统</title>
	<script src="/Public/js/jquery-1.9.1.min.js" language="javascript"></script>

	<style type="text/css">
	* {
		margin: 0px;
		padding: 0px;
		outline:none;
	}
	input[type=submit],
	input[type=reset],
	input[type=button]{
	  filter:chroma(color=#000000);
	}
	input[type=text] { box-sizing : content-box; -moz-box-sizing : content-box; }
	html, body {
		height: 100%;
		width: 100%;
	}
	body {
		font-size: 12px;
		font-family:"Microsoft YaHei";
		line-height: 1.5em;
		background: #ECF5FF;
	}
	h1 {
		color: #FFFFFF;
		text-align: center;
		margin: 20px;
		cursor:default;
	}
	.clearfix:after{
		height:0;
		line-height:0;
		font-size:0;
		visibility:hidden;
		display:block;
		content:".";
		clear:both;
	}
	.bluebg {
		background: #1ea1eb;
		height: 350px;
		width: 100%;
		overflow: hidden;
	}
	.bluebg .logo {
		text-align: center;
		margin-top: 40px;
	}
	 .form {
		margin: -100px auto 0px;
		width: 400px;
		background: #FFFFFF;
		border: 1px solid #D7EBFF;
		padding-top: 10px;
		padding-bottom: 30px;
		position: relative;
	}
	.form .msgbox {
		color: #FFFFFF;
		background: #FF9900;
		height: 20px;
		line-height:20px;
		text-align:center;
		visibility:hidden;
		display: block;
		margin: 0px auto;
		width:180px;
		position:relative;
	}
	.form .msgbox .close {
		position:absolute;
		top:0;
		right:0;
		height:20px;
		width:20px;
		text-align:center;
		padding-top:6px;
		cursor:pointer;
	}
	 .form .form_row {
		text-align: center;
		position: relative;
		margin-top: 10px;
	}
	.form .form_row input {
		width: 290px;
		padding: 10px 10px 10px 35px;
		border: 1px solid #CCCCCC;
		font-size:14px;
		color:#333333;
	}
	.form .form_row .input_focus {
		border: 1px solid #1ea1eb;
	}
	.form .form_row .verify_area {
		width: 337px;
		margin: 0px auto;
	}
	.form .form_row .verifycode {
		float: left;
		width: 150px;
	}
	.form .form_row .verifyimg {
		display: block;
		height: 30px;
		width: 130px;
		float: left;
		padding-top: 5px;
	}
	.form .form_row .submit {
		font-size: 14px;
		color: #FFFFFF;
		background: #3399FF;
		width: 337px;
		cursor:pointer;
		margin-top: 20px;
		margin-right: auto;
		margin-bottom: 0px;
		margin-left: auto;
	}
	.form .form_row .submit:hover {
		background: #0984FF;
	}
	.form .form_row .u_logo {
		background: url(/Public/images/user.png) no-repeat;
		height: 20px;
		width: 20px;
		position: absolute;
		top: 11px;
		left: 40px;
	}
	.form .form_row .p_logo {
		background: url(/Public/images/password.png);
		height: 20px;
		width: 20px;
		position: absolute;
		left: 40px;
		top: 11px;
	}
	.form .form_row .v_logo {
		background: url(/Public/images/verify_logo.png);
		height: 20px;
		width: 20px;
		position: absolute;
		left: 40px;
		top: 11px;
	}
	.form .form_row .remind {
		color: #999999;
		position: absolute;
		left: 70px;
		top: 9px;
		top:13px !important; 
		z-index:0;
	}
	.footer {
		text-align: center;
		margin-top: 20px;
	}
	.footer p {
		line-height: 18px;
		color: #999999;
	}
	.footer a {
		color: #999999;
		text-decoration: none;
	}
	
	</style>
</head>
<body>
<div id="qrcode"></div>
	<!--蓝色背景及logo-->
    <div class="bluebg">
        <div class="logo">
                <img src="/Public/images/azy_logo.png" width="120" height="120">    </div>
      <h1>在线点名系统</h1>
    </div>
    <!--表单区域-->
    <div class="form">
        <div class="msgbox">
        	<a class="close"><img src="/Public/images/cross_grey_small.png"></a>
            <span class="msg">我是提示框</span>
        </div>
        <form method="post" action="" name="form1">
            <div class="form_row">
                <span class="u_logo"></span>
                <!-- <span class="remind">请输入用户名</span> -->
                <input name="user" type="text" placeholder="请输入用户名" id="user" maxlength="20" class="">
          </div>
            <div class="form_row">
          <span class="p_logo"></span>
                <!-- <span class="remind">请输入密码</span> -->
                <input name="pwd" type="password" placeholder="请输入密码" id="password" maxlength="20" class="" >
          </div>
            <div class="form_row clearfix">
              <div class="verify_area">
                <span class="v_logo"></span>   
                <input name="verify" type="verify" placeholder="请填写验证码" id="verify" class="verifycode" maxlength="4">
                <img id="src" src="<?php echo U('Login/verify');?>" onclick='this.src=this.src+"?"+Math.random()' width="93" height="37" /></div>
            </div>
          <div class="form_row">
            <label>
            <input class="submit" type="button" onclick="return check()" value="登&nbsp;&nbsp;录" style="padding-left:10px;"></label>
          </div>
        </form>
    </div>
    <!--底部-->
    <div class="footer">
        <p>科技创新，勇往直前！</p>
        <p>技术支持：安徽迅时网络科技有限公司 <a href="http://www.ahxunshi.com/" target="_blank">www.ahxunshi.com</a></p>
    </div>
<script type="text/javascript">
	function check() {
		if (form1.user.value == '') {
			alert('用户名不能为空！');
			form1.user.focus();
			return false;
		}
		if (form1.password.value == '') {
			alert('密码不能为空！');
			form1.password.focus();
			return false;
		}
		if (form1.verify.value == '') {
			alert('请填写4位验证码！');
			form1.verify.focus();
			return false;
		}
		$.ajax({
			url:"<?php echo U('Login/login');?>",
			data:{
				"user":form1.user.value,
				"pwd":form1.password.value,
				"verify":form1.verify.value
			},
			type:"post",
			dataType: "json",
			success:function(msg) {
				if (msg.status == 1) {
					window.location.href = msg.url;	
				}
				if (msg.status == 2) {
		          alert(msg.info);
		          $("input[name='verify']").val("").focus(); // 清空并获得焦点
		          var imgSrc=$("#src").attr("src")+"?a="+Math.random();
		          $("#src").attr("src",imgSrc);
		        }
		        if (msg.status == 3) {
		          alert(msg.info);
		          window.location.href = msg.url;
		        }
			},
		});
	}
</script>
	<!-- 检测浏览器 -->
<script>
	function myBrowser(){
	    var userAgent = navigator.userAgent; //取得浏览器的userAgent字符串
	    var isOpera = userAgent.indexOf("Opera") > -1; //判断是否Opera浏览器
	    var isIE = userAgent.indexOf("compatible") > -1 && userAgent.indexOf("MSIE") > -1 && !isOpera; //判断是否IE浏览器
	    // var isFF = userAgent.indexOf("Firefox") > -1; //判断是否Firefox浏览器
	    // var isSafari = userAgent.indexOf("Safari") > -1; //判断是否Safari浏览器
	    if (isIE) {
	        var IE5 = IE55 = IE6 = IE7 = IE8 = false;
	        var reIE = new RegExp("MSIE (\\d+\\.\\d+);");
	        reIE.test(userAgent);
	        var fIEVersion = parseFloat(RegExp["$1"]);
	        IE55 = fIEVersion == 5.5;
	        IE6 = fIEVersion == 6.0;
	        IE7 = fIEVersion == 7.0;
	        IE8 = fIEVersion == 8.0;
	        if (IE55) {
	            return "IE55";
	        }
	        if (IE6) {
	            return "IE6";
	        }
	        if (IE7) {
	            return "IE7";
	        }
	        if (IE8) {
	            return "IE8";
	        }
	    } //isIE end
	    if (isFF) {
	        return "FF";
	    }
	    if (isOpera) {
	        return "Opera";
	    }
	}//myBrowser() end
	//以下是调用上面的函数
	if (myBrowser() == "IE55") {
	    window.location.href="/Public/503.html";
	}
	if (myBrowser() == "IE6") {
	    window.location.href="/Public/503.html";
	}
	if (myBrowser() == "IE7") {
	    window.location.href="/Public/503.html";
	}
	if (myBrowser() == "IE8") {
	    window.location.href="/Public/503.html";
	}
</script> 
</body>
</html>