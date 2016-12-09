<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>安徽职业技术学院——在线点名系统</title>
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
</head>

<link type="text/css" rel="stylesheet" href="/Public/m_css/dmxtstyle.css">
<link type="text/css" rel="stylesheet" href="/Public/m_css/style.css">
<script src="/Public/js/jquery-1.9.1.min.js" language="javascript"></script>
<script>
$(document).ready(function(){
	//点击输入框，添加蓝色边框
	$(":text,:password,textarea").bind({
		focus:function(){$(this).addClass("input_focus");},
		blur:function(){$(this).removeClass("input_focus");},
		click:function(){$(this).css("background-color","#FFFFFF")}
	});	
	//user获得焦点
	$("#user").focus();
	//输入框输入时，提示文字消失
	$(".from_main").find("input").bind({
		keydown:function(){
			$(this).siblings(".remind").hide();
		},
		blur:function(){
			if($(this).val().length>0){
				$(this).siblings(".remind").hide();
			}else{
				$(this).siblings(".remind").show();
			}
		}
	});
});
</script>
<body>

<div class="container_from">
  <header class="header"><img src="/Public/images/logo.jpg" width="173" height="51"></header>
  <div class="from_main">
     <form method="post" action="" name="form1">
        <div class="form_row">
           <span class="icon icon-PEOPLE"></span>
           <!-- <span class="remind">请输入用户名</span> -->
           <input name="user" placeholder="请输入用户名" style="font-size:0.875em;" type="text" id="user" maxlength="20" class="">
        </div>
        <div class="form_row">
           <span class="icon icon-lock"></span>
           <!-- <span class="remind">请输入密码</span> -->
           <input name="pwd" placeholder="请输入密码" style="font-size:0.875em;" type="password" id="pwd" maxlength="20" class="">
        </div>
        <div class="form_row clearfix">
          <div class="verify_area">
              <span class="icon icon-shield"></span>
              <!-- <span class="remind">请输入验证码</span>    -->   
              <input name="verify" placeholder="请输入验证码" type="text" id="verify" class="verifycode" maxlength="4" style="background-color: rgb(255, 255, 255);font-size: 0.875em;">
              <span class="verifyimg" title="看不清楚?换一张"><img id="src" src="<?php echo U('Login/verify');?>" onclick="this.src=this.src+'?a='+Math.random()" width="83" height="31" /></span>
          </div>
        </div>
        <div class="form_row">
            <label>
            <input class="submit" type="button" onclick="return check()" value="登&nbsp;&nbsp;录"></label>
        </div>
     </form>
  </div>
</div>
<script type="text/javascript">
  function check() {
    if ($("#user").val() == '') {
      alert('用户名不能为空！');
      form1.user.focus();
      return false;
    }
    if ($("#pwd").val() == '') {
      alert('密码不能为空！');
      form1.password.focus();
      return false;
    }
    if ($("#verify").val() == '') {
      alert('请填写4位验证码！');
      form1.verify.focus();
      return false;
    }
    $.ajax({
      url:"<?php echo U('Login/login');?>",
      data:{
        "user":$("#user").val(),
        "pwd":$("#pwd").val(),
        "verify":$("#verify").val()
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
</body>
</html>