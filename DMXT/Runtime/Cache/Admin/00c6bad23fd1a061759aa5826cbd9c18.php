<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>安徽职业技术学院——在线点名系统</title>
  <link type="text/css" href="/Public/css/style.css" rel="stylesheet" />
  <script src="/Public/js/jquery-1.9.1.min.js" language="javascript"></script>
</head>



<body>
<div class="main">
  <h3>上课点名</h3>
  <div><!---音乐-->
    <audio id="msc" type="audio/mpeg"></audio>
  </div>
  <div class="callmain">
      <b>班级：
     
        <select name="class_id" id="sele2">
            <option value="">请选择授课班级</option>
          <?php if(is_array($class_list)): $i = 0; $__LIST__ = $class_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><!--遍历班级表数据-->
            <option value="<?php echo ($vo["name"]); ?>"><?php echo ($vo['name']); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
        </select>
      
      </b>
      <b>
      <input type="button" class="A_btn" onclick="begin()" value="开始点名" id="begin" >
      </b>
      <b>
      <input type="button" class="A_btn" onclick="stop()" value="暂停点名" id="stop" disabled>
      </b>
  </div>
   
  <div class="dialog_mian">
    <div class="dialog_name">
        <P><span id="xuehao"></span></P>
        <p><span id="name"></span></p>
    </div>
    <div class="callmain" >
      <b><input type="button" class="A_btn"  onclick="vocation()" value="请假" id="vocation" disabled></b>
      <b><input type="button" class="A_btn"  onclick="absent();" value="旷课" id="absent" disabled></b>
    </div>
  </div>
</div>

</body>
<script type="text/javascript">
var arrMsg;
var int;

var result=[];

// $("#sele2").change(function(){
//   $.ajax({
//     url:"<?php echo U('Rollcall/stu');?>",
//     data:{class_name:$("#sele2 option:selected").val()},//获取下拉框班级表（name字段的值）
//     error:function() {
//       alert("拉取学生名单失败！");
//       return;
//     },
//     success:function(msg) {
//       console.log(msg);
//       if (msg. status===0){
//         alert(msg.info);
//         return;
//       }
//       arrMsg="";
//       arrMsg=msg;
//     }
//   });
// });
// 
$(function(){
  $("select[name='class_id']").change(function(){
    $.ajax({
      url:"<?php echo U('Rollcall/stu');?>",
      data:{
        class_name:$("[name='class_id']").val()
      },
      error:function() {
      alert("拉取学生名单失败！");
      return;
    },
    success:function(msg) {
      // console.log(msg);
      if (msg. status===0){
        alert(msg.info);
        return;
      }
      arrMsg="";
      //int="";
      //release="";
      //result=[];
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
  if (arrMsg.length<1) {
    createForm("<?php echo U('Rollcall/stateSave');?>",JSON.stringify(result));
    return;
  }
  $("#begin").attr("disabled",false).css("background-color","gray");
  $("#vocation").attr("disabled",true).css("background-color","gray");
  $("#absent").attr("disabled",true).css("background-color","gray");
  $("#stop").attr("disabled",false).css("background-color","");
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
    createForm("<?php echo U('Rollcall/stateSave');?>",JSON.stringify(result));
    return;
  }
  showText();
  arrMsg[0].state=1;//已到
  result.push(Object(arrMsg[0]));
  playMsc();
  arrMsg.shift();
}
  // $("#msc")[0].addEventListener('ended',function(){

  // });

function playMsc() {
  $("#msc").attr("src",""+arrMsg[0]['mp3_path']);
  $("#msc")[0].play();
  setTimeout('$("#msc")[0].play()',2000);//在4秒时间里2秒执行一次
}
function showText() {
  $("#xuehao").text(arrMsg[0]['no']);
  $("#name").text(arrMsg[0].name);
}

function setLoop() {
  int=setInterval("arrive()",4000);
}
/*
上课状态
state=1,正常
state=2,请假
state=3,旷课
 */

function stop() {
  $("#begin").attr("disabled",false).css("background-color","");
  $("#vocation").attr("disabled",false).css("background-color","");
  $("#absent").attr("disabled",false).css("background-color","");
  $("#stop").attr("disabled",true).css("background-color","gray");
  clearInterval(int);
}
//请假
function vocation() {
  $("#begin").attr("disabled",false);
  $("#vocation").attr("disabled",true).css("background-color","yellow");
  $("#absent").attr("disabled",true).css("background-color","gray");
  result[result.length-1].state=2;
}
//旷课
function absent() {
  $("#begin").attr("disabled",false);
  $("#vocation").attr("disabled",true).css("background-color","gray");
  $("#absent").attr("disabled",true).css("background-color","red");
  $("#stop").attr("disabled",true).css("background-color","gray");
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