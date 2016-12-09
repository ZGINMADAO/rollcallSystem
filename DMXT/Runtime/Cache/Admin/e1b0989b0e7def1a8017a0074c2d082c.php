<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>安徽职业技术学院——在线点名系统</title>
  <script src="/Public/js/jquery-1.9.1.min.js" language="javascript"></script>
  <link type="text/css" href="/Public/css/style.css" rel="stylesheet" />
</head>
<body>
<div class="main">
  <h3>教师列表</h3>
  <div class="dialog_mian">
    <?php if(is_array($teacherRole)): $i = 0; $__LIST__ = $teacherRole;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vol): $mod = ($i % 2 );++$i;?><dl class="Teacher_list">
        <a href="#"  onclick="ShowDiv('MyDiv','fade',this)">
          <input type="hidden" value="<?php echo ($vol["id"]); ?>">
          <dt>
            <p>
              <img src="/Public/images/teacher.png" width="200" height="200" />  
              <span  style="color:white" title="<?php echo ($vol['title']); ?>">[<?php echo ($vol['title']); ?>]</span>
            </p>
          </dt>
          <dd  style="color:black"><?php echo ($vol["nikename"]); ?><!-- <span  style="color:#999">[<?php echo ($vol['title']); ?>]</span> --></dd>
        </a>
      </dl><?php endforeach; endif; else: echo "" ;endif; ?>
  </div>
</div>
<!--弹出层时背景层DIV-->
<div id="fade" class="black_overlay">
</div>
<div id="MyDiv" class="white_content">
  <div style="text-align: right; cursor: default; height: 40px; cursor:pointer;padding-right:10px; padding-top:10px;">
     <span style="font-size: 16px;" onclick="CloseDiv('MyDiv','fade')"><img src="/Public/images/w_close.png" title="关闭"></span>
  </div>
  <div class="tearch_name">
    <form id="popup" method="post" action="<?php echo U('Role/assignRole');?>">
      <h1>某某教师</h1>
      <p style="text-align:center;">
        <select name="roleSelect">
            <option value="0">角色选择</option>
          <?php if(is_array($roleAll)): $i = 0; $__LIST__ = $roleAll;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$val): $mod = ($i % 2 );++$i;?><option value="<?php echo ($val["id"]); ?>"><?php echo ($val["title"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
        </select>
      </p>
        <input type="hidden" name="hideid">
      <p class="btn">
        <input type="submit" value="提交"/>
      </p>
    </form>
  </div> 
</div>
<script type="text/javascript">
//弹出隐藏层
function ShowDiv(show_div,bg_div,obj) {
  document.getElementById(show_div).style.display='block';
  document.getElementById(bg_div).style.display='block' ;
  var bgdiv = document.getElementById(bg_div);
  bgdiv.style.width = document.body.scrollWidth;
  // bgdiv.style.height = $(document).height();
  $("#"+bg_div).height($(document).height());
  $("#popup").find("h1").text($(obj).find("dd").text());
  $("#popup").find("input:hidden").val($(obj).find("input").val());
};
//关闭弹出层
function CloseDiv(show_div,bg_div) {
  document.getElementById(show_div).style.display='none';
  document.getElementById(bg_div).style.display='none';
};
</script>
</body>
</html>