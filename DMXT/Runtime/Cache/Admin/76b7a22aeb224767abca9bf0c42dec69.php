<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>安徽职业技术学院——在线点名系统</title>
  <link rel="Shortcut Icon" href="/favicon.ico">
  <link type="text/css" href="/Public/css/dmxtstyle.css" rel="stylesheet" />
  <script src="/Public/js/jquery-1.9.1.min.js" language="javascript"></script>

</head>   

<body>
<div class="person">
  <div class="info">
    <div class="jobnum">教工号：<?php echo ($res["user"]); ?></div>
    <div class="name">姓名：<?php echo ($res["nikename"]); ?></div>
    <div class="name">角色：<?php echo ($role["title"]); ?></div>
  </div>
  <div class="face"></div>
  <div class="facedark"></div>
</div>

<div class="aside">
  <div class="logo">
    <div class="sys_logo">
      <img src="/Public/images/dm_logo.jpg" width="106" height="106" />
    </div>
    <div class="sys_intro">
      <div>安徽职业技术学院</div>
      <span>在线点名系统</span>
    </div>
    <div class="clear"></div>
  </div>
  <div class="operation">
    <a href="<?php echo U('Index/index');?>" title="返回首页"><img src="/Public/images/home.png" width="22" height="20" /></a>
    <a href="<?php echo U('Index/edit');?>" title="账户管理" id="account"><img src="/Public/images/management.png" width="22" height="20" /></a>
    <a href="<?php echo U('Login/logout');?>" title="退出登录"><img src="/Public/images/turn_off.png" width="22" height="20" /></a>
  </div>
  <div class="nav">
    <ul>
      <?php if(checkRule('Rollcall',session('nameid'))): ?><li>
        <a href="javascript:void(0)" class="menu1" style="color: white; background: none;">
        <img src="/Public/images/rollcall.png" alt="点名管理" class="ico">
        <span>点名管理</span>
        <img src="/Public/images/arrow.png" alt="" class="arrow" style="display: none; opacity: 1;">
        </a>
        <ul style="display: none;" >
          <?php if(checkRule('Rollcall/rollCall',session('nameid'))): ?><li>
              <div ></div>
              <a href="<?php echo U('Rollcall/rollCall');?>" style="color: white; background: none;">上课点名</a>
            </li><?php endif; ?>
          <?php if(checkRule('Rollcall/studentList',session('nameid'))): ?><li>
              <div ></div>
              <a href="<?php echo U('Rollcall/studentList');?>" style="color: white; background: none;">点名状态</a>
          </li><?php endif; ?> 
          <?php if(checkRule('Rollcall/analyse',session('nameid'))): ?><li>
              <div ></div>
              <a href="<?php echo U('Rollcall/analyse');?>" style="color: white; background: none;">点名分析</a>
            </li><?php endif; ?>
        </ul>
      </li><?php endif; ?>
      <?php if(checkRule('Manage',session('nameid'))): ?><li>
          <a href="javascript:void(0);" class="menu1" style="color: white; background: none;">
          <img src="/Public/images/msg.png" alt="" class="ico">
          <span>信息管理</span>
          <img src="/Public/images/arrow.png" alt="" class="arrow" style="display: none; opacity: 1;">
          </a>
          <ul id="check" style="display: none;">
            <?php if(checkRule('Manage/teaDetail',session('nameid'))): ?><li>
                <a href="<?php echo U('Manage/teaDetail');?>" style="color: white; background: none;">教师信息</a>
              </li><?php endif; ?>
            <?php if(checkRule('Manage/stuMsg',session('nameid'))): ?><li>
                <a href="<?php echo U('Manage/stuMsg');?>" style="color: white; background: none;">学生信息</a>
              </li><?php endif; ?>
            <?php if(checkRule('Manage/banji',session('nameid'))): ?><li>
                <a href="<?php echo U('Manage/banji');?>" style="color: white; background: none;">班级信息</a>
              </li><?php endif; ?>
          </ul>
        </li><?php endif; ?>
      <?php if(checkRule('Batches',session('nameid'))): ?><li>
          <a href="javascript:void(0);" class="menu1" style="color: white; background: none;">
          <img src="/Public/images/upload.png" alt="" class="ico">
          <span>导入导出</span>
          <img src="/Public/images/arrow.png" alt="" class="arrow" style="display: none; opacity: 1;">
          </a>
          <ul id="check" style="display: none;">
            <?php if(checkRule('Batches/index',session('nameid'))): ?><li>
                <a href="<?php echo U('Batches/index');?>" style="color: white; background: none;">信息导入</a>
              </li><?php endif; ?>
            <?php if(checkRule('Batches/export',session('nameid'))): ?><li>
                <a href="<?php echo U('Batches/export');?>" style="color: white; background: none;">信息导出</a>
              </li><?php endif; ?>
          </ul>
        </li><?php endif; ?>
      <?php if(checkRule('Role',session('nameid'))): ?><li>
          <a href="javascript:void(0);" class="menu1" style="color: white; background: none;">
          <img src="/Public/images/role.png" alt="" class="ico">
          <span>角色管理</span>
          <img src="/Public/images/arrow.png" alt="" class="arrow" style="display: none; opacity: 1;">
          </a>
          <ul id="check" style="display: none;">
            <!-- <?php if(checkRule('Role/addAuth',session('nameid'))): ?><li>
                <a href="<?php echo U('Role/addAuth');?>" style="color:white;background:none;">
               权限管理</a>
              </li><?php endif; ?> -->
            <?php if(checkRule('Role/roleList',session('nameid'))): ?><li>
                <a href="<?php echo U('Role/roleList');?>" style="color: white; background: none;">角色列表</a>
              </li><?php endif; ?>
            <?php if(checkRule('Role/teacherList',session('nameid'))): ?><li>
                <a href="<?php echo U('Role/teacherList');?>" style="color:white;background:none;">
               教师列表</a>
              </li><?php endif; ?>
          </ul>
        </li><?php endif; ?>
      <?php if(checkRule('Info',session('nameid'))): ?><li>
          <a href="javascript:void(0);" class="menu1" style="color: white; background: none;">
          <img src="/Public/images/Info.png" alt="" class="ico">
          <span>数据管理</span>
          <img src="/Public/images/arrow.png" alt="" class="arrow" style="display: none; opacity: 1;">
          </a>
          <ul id="check" style="display: none;">
            <?php if(checkRule('Info/infoList',session('nameid'))): ?><li>
                <a href="<?php echo U('Info/infoList');?>" style="color: white; background: none;">音频文件</a>
              </li><?php endif; ?>
          </ul>
        </li><?php endif; ?>

    </ul>   
  </div>        
</div>

<div class="topdata">的撒大大</div>
<!--    主要内容显示区域-->
<div class="article">
  <iframe src="<?php echo U('Index/welcome');?>" frameborder="0" scrolling="auto" id="iframe" name="main" style="height: 683px;">
  </iframe>
</div>

<script type="text/javascript" src="/Public/js/default.js"></script>
  <script>
    //自定义框架适应高度
    window.onresize = function() {
      var iframe = document.getElementById("iframe");
      iframe.style.height = document.body.offsetHeight + 'px';
    };
    window.onload = function() {
      var iframe = document.getElementById("iframe");
      iframe.style.height = document.body.offsetHeight + 'px';
    };
  </script>
  <script type="text/javascript">
    $(document).ready(function(){
      //个人信息小方块
      var person=$(".person");
      var face=$(".person .face");
      var facedark=$(".person .facedark");
      var info=$(".person .info");
      person.hover(function(){
        face.css({
          top:"25px",
          left:"0",
          width:"50px",
          height:"50px"
        });
        facedark.hide();
        person.css({
          width:"200px",
          background:"#016fc1",
          height:"100px"
        });
        info.show(0);  
      },function() {

        face.css({height:"0",width:"0"});
        facedark.show();
        person.css({ width:"50px",height:"50px",background:"#fff"})
        info.hide();
      })
    });
  </script> <!--person经过出现结束-->
  <script type="text/javascript">
    //导航条
    $(document).ready(function() {
      //显示箭头
      $(".nav li").hover(function(){
        $(this).find(".arrow").stop().fadeIn(200);
      },function() {
        $(this).find(".arrow").fadeOut(200);
      });
      //三角形的位置变化
      $(".nav li ul li a").click(function() {
        //添加三角形并变色
        trg="<div class='trg'></div>";
        $(this).css("color","#FEEC47").before(trg);
        //同胞三角消失
        $(this).parent().siblings().children("div").remove(".trg");
        $(this).parent("li").parent("ul").parent("li").siblings("li").find("div").remove(".trg");
        //同胞颜色返回白色.css("color","white")
        $(this).parent().siblings().children("a").css("color","white");
        $(this).parent("li").parent("ul").parent("li").siblings("li").find("a").css("color","white");
      });
      //点击上拉下拉动画
      $(".nav li a").click(function(){  
      $(this).next("ul").toggle(100);
      //console.log($(this).parent().siblings().children("ul"));
      $(this).parent().siblings().children("ul").hide(100);
      });
      //鼠标经过改变背景色
      $(".nav li a").hover(function(){
      $(this).css({"background":"#127bcb"});
      //$(this).css({"background":"#0057AE"});
      },function(){
        $(this).css({"background":"none"});
      });
      //超链接跳转
      $(".nav li ul li a,#account").click(function(){
        if($(this).attr("id")=="depart_project") {
        } else {
          //var webname=$(this).attr("id");
          var webname=$(this).attr("href");
          $("#iframe").attr("src",webname);
          return false;
        }
      });
      //小图标点击事件
      //刷新子页面
      $("#refresh").click(function(){
    
        src=$("#iframe").attr("src");
        $("#iframe").attr("src",src);
      })
    });
  </script>

<!-- 检测浏览器 -->
<!-- <script type="text/javascript">
 var browser=navigator.appName
 var b_version=navigator.appVersion
 var version=b_version.split(";");
 var trim_Version=version[1].replace(/[ ]/g,"");
 if(browser=="Microsoft Internet Explorer" && trim_Version=="MSIE6.0")
 {
 alert("请使用IE8以上的浏览器进行登陆访问");
 }
 else if(browser=="Microsoft Internet Explorer" && trim_Version=="MSIE7.0")
 {
 alert("请使用IE8以上的浏览器进行登陆访问");
 }
 else if(browser=="Microsoft Internet Explorer" && trim_Version=="MSIE8.0")
 {
 alert("请使用IE8以上的浏览器进行登陆访问");
 }
 </script> --> 
</body>
</html>