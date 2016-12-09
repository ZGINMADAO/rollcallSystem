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

<body>
<div><!---音乐-->
    <audio id="msc" type="audio/mpeg"></audio>
  </div>
<div class="container_from">
  <div class="back"></div>
  <header class="header"><img src="/Public/images/logo.jpg" width="173" height="51"></header>
  <div class="grades"></div>
     <div class="name">
         <P align="center"><span id="xuehao"></span></P>
         <p align="center"><span id="name"></span></p>
     </div>
  <div class="from_main">
    <form method="get" >
      <div class="form_row">
         <select class="form-control" name="class_id" id="sele2">
            <option value="">请选择授课班级</option>
          <?php if(is_array($class_list)): $i = 0; $__LIST__ = $class_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><!--遍历班级表数据-->
            <option value="<?php echo ($vo["name"]); ?>"><?php echo ($vo['name']); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>      
         </select>
      </div>

      <div class="webContainerBox">
     <div class="main">
        <div class="list">
           <a onclick="begin()" class="m1" id="begin">
             <span class="icon icon-user"></span>
             <span class="ramin">开始点名</span>
           </a>
        </div>
        <div class="list">
           <a onclick="stop()" class="m2" id="stop" disabled> 
             <span class="icon icon-stop"></span>
             <span class="ramin">暂停点名</span>
           </a>
        </div>
        <div class="list">
           <a onclick="vocation()" class="m3" id="vocation" disabled>
             <span class="icon icon-leave"></span>
             <span class="ramin">请&nbsp;假</span>
           </a>
        </div>
        <div class="list">
           <a onclick="absent()" class="m4" id="absent" disabled>
             <span class="icon icon-class"></span>
             <span class="ramin">旷&nbsp;课</span>
           </a>
        </div>
     </div>
  </div>

    </form>
  </div>
  
  <div class="bottom">
     <ul>
       <li>
         <a href="<?php echo U('Index/index');?>">
           <span class="icon icon-home"></span>
           <span>网站首页</span>
         </a>
       </li>
       <li>
          <a href="<?php echo U('Login/logout');?>">
           <span class="icon icon-ShutDown"></span>
          <span>退出登录</span>
          </a>
        </li>
     </ul>
  </div>
  
</div>
</body>
<script type="text/javascript">
var arrMsg;
var int;
var result=[];


$(function(){
  $("select[name='class_id']").change(function(){
    $.ajax({
      url:"<?php echo U('Index/stu');?>",
      data:{
        class_name:$("[name='class_id']").val()
      },
      error:function() {
      alert("拉取学生名单失败！");
      return;
    },
    success:function(msg) {
      console.log(msg);
      if (msg. status===0){
        alert(msg.info);
        return;
      }
      arrMsg="";
      arrMsg=msg;
    }
    });
  });
});

function begin() {
  if ($("#sele2 option:selected").val()) {
    $("#sele2").prop("disabled",true);
  } else {
    alert('请选择班级');
    return;
  }
  $("#begin").css("background-color","gray");
  $("#vocation").css("background-color","gray").removeAttr('onclick');
  $("#absent").css("background-color","gray").removeAttr('onclick');
  $("#stop").attr("onclick","stop()").css("background-color","");
  if (arrMsg.length < 1) {
    createForm("<?php echo U('Index/stateSave');?>",JSON.stringify(result));
    return;
  }
  showText();
  arrMsg[0].state=1;//已到
  result.push(Object(arrMsg[0]));
  playMsc();
  arrMsg.shift();
  setLoop();
}

function arrive() {

  if (arrMsg.length<1) {
    stop();
    createForm("<?php echo U('Index/stateSave');?>",JSON.stringify(result));
    return;
  }
  showText();
  arrMsg[0].state=1;//已到
  result.push(Object(arrMsg[0]));
  playMsc();
  arrMsg.shift();
}

function playMsc() {
  $("#msc").attr("src",""+arrMsg[0]['mp3_path']);
  $("#msc")[0].play();
  setTimeout('$("#msc")[0].play()',3000);//在4秒时间里2秒执行一次
}
function showText() {
  $("#xuehao").text(arrMsg[0]['no']).css({"color":"red","font-size":"35px","margin-top":"30px"});
  $("#name").text(arrMsg[0].name).css({"color":"red","font-size":"35px","margin-top":"30px"});
}

function setLoop() {
  
  int=setInterval("arrive()",6000);
}
/*
上课状态
state=1,正常
state=2,请假
state=3,旷课
 */

function stop() {
  if (!arrMsg) {
    alert('请选择班级');
    return;
  }
  $("#begin").css("background-color","");
  $("#vocation").attr("onclick","vocation()").css("background-color","");
  $("#absent").attr("onclick","absent()").css("background-color","");
  $("#stop").css("background-color","gray");
  clearInterval(int);
}
//请假
function vocation() {
  if (!arrMsg) {
    alert('请选择班级');
    return;
  }
  $("#begin").css("background-color","");
  $("#vocation").css("background-color","yellow").removeAttr('onclick');
  $("#absent").css("background-color","gray").removeAttr('onclick');
  $("#stop").css("background-color","gray").removeAttr('onclick');
  result[result.length-1].state=2;
}
//旷课
function absent() {
  if (!arrMsg) {
    alert('请选择班级');
    return;
  }
  $("#begin").css("background-color","");
  $("#vocation").css("background-color","gray").removeAttr('onclick');
  $("#absent").css("background-color","red").removeAttr('onclick');
  $("#stop").css("background-color","gray").removeAttr('onclick');
  result[result.length-1].state=3;
}
//js创建表单提交
function createForm(URL,DATA){
  var temp = document.createElement("form"); 
  temp.action = URL;      
  temp.method = "post";      
  temp.style.display = "none";           
  var opt = document.createElement("textarea");      
  opt.name = "dataList";      
  opt.value = DATA;           
  temp.appendChild(opt);           
  document.body.appendChild(temp);      
  temp.submit();       
}
</script>
</html>