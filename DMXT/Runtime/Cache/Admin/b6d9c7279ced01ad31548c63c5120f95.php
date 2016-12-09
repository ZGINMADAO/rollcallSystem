<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8" />
  <title>安徽职业技术学院——在线点名系统</title>
  <link type="text/css" href="/Public/css/style.css" rel="stylesheet" />
  <script src="/Public/js/jquery-1.9.1.min.js" language="javascript"></script>
</head>
<style type="text/css">
input.A_btn{ width:100px; height:26px; line-height:26px; vertical-align:top;border-radius:5px; outline:none; border:0; background:#3399FF; color:#fff; cursor:pointer;}

.dm_list li.n1{ width:5%;}	
.dm_list li.n2{ width:7%;}	
.dm_list li.n3{ width:15%;}		
.dm_list li.n4{ width:17%;}		
.dm_list li.n5{ width:17%;}		
.dm_list li.n6{ width:17%;}
.dm_list li.n7{ width:12%;}
.dm_list li.n8{ width:10%;}

input.stueidt{
	width:190px;
	padding:5px;
	height:22px;
	outline:none;
	border:1px solid #dadada;
	color:#444;
	font-size:16px;
	}
.tearch_name p{ padding:10px 0; font-size:16px;}
</style>
<body>

<div class="main">
  <h3>学生信息</h3>
   <div class="dm_main">
   
    <div style="width:96%; height:30px; margin:30px auto 10px auto; text-align:center;">
      <div style="width:70px; float:left; margin:0px 20px;">
        <a href="#" class=" button_blue" onclick="del()"  >
          <span class="view">批量删除</span>
          <span class="hidden">批量删除</span>
        </a>
      </div>
      <div style="width:70px; float:left; margin:0px 20px;">
        <a href="#" class=" button_blue" onclick="mp3_all()">
           <span class="view">批量生成音频</span>
           <span class="hidden">批量生成音频</span>
        </a>
      </div>

      <div style="width:350px; padding-left:2%; float:left;">
        <form method="post" name="formsearch">
          <input type="text" id="stu_no" name="searchWord" placeholder="输入学号/姓名" class="A_text"/>
          <input type="button" onclick="search()" value="搜索" class="A_btn">
        </form>
      </div>
    
    </div>
      
    <form name="form1" method="post">
      <div class="dm_content">
        <div class="dm_list">
          <ul class="dm_bt">
            <li class="n1"> <input type="checkbox" value="" id="selectAll" onclick="SelectAll()" /></li>
            <li class="n2">序&nbsp;号</li>
            <li class="n3">学&nbsp;号</li>
            <li class="n4">姓&nbsp;名</li>
            <li class="n5">班级名称</li>
            <!-- <li class="m6">班&nbsp;级ID</li> -->
            <li class="n6">音&nbsp;频</li>
            <li class="n7">音频状态</li>
            <li class="n8">操&nbsp;作</li>
          </ul>
          <!--遍历stu表查询出的数据-->
          <?php $num = '1'; ?>
          <?php if(is_array($result)): $i = 0; $__LIST__ = $result;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><ul class="dm_nrli">
              <li class="n1"><input name="idno[]" type="checkbox" value="<?php echo ($vo["id"]); ?>"/></li>
              <li class="n2"><?php echo ($num++); ?></li>
              <li class="n3"><?php echo ($vo["no"]); ?></li>
              <li class="n4"><?php echo ($vo["name"]); ?></li>
              <li class="n5"><?php echo ($vo["class_name"]); ?></li>
              <!-- <li class="m6"><?php echo ($vo["class_id"]); ?></li> -->
              <li class="n6">
                <input type="hidden" name="id" value="<?php echo ($vo["id"]); ?>"/>
                <img src="/Public/images/audio.png" onclick="mp3(this)" >
              </li>
              <!-- <li class="n7"><?php echo ($vo["mp3"]); ?></li> -->
              <li class="n7">
                <?php if($vo["mp3"] == 1): ?><img src="/Public/images/tru.png">
                <?php elseif($vo["mp3"] == 0): ?><img src="/Public/images/err.png"><?php endif; ?>
              </li>
              <li class="n8">
                 <input type="hidden" value="<?php echo ($vo["id"]); ?>"/>
                 <a href="#" onclick="ShowDiv('MyDiv','fade',this)" ><img src="/Public/images/edit.png"></a></li>
            </ul><?php endforeach; endif; else: echo "" ;endif; ?>
        </div>
      </div>
    </form>


  <!--分页-->
  <div class="pagination"><?php echo ($page); ?></div>

<!--弹出层时背景层DIV-->
  <div id="fade" class="black_overlay"></div>
  <div id="MyDiv" class="white_content">
     <div style="text-align: right; cursor: default; height: 40px; cursor:pointer;padding-right:10px; padding-top:10px;">
       <span style="font-size: 16px;" onclick="CloseDiv('MyDiv','fade')"><img src="/Public/images/w_close.png" title="关闭"></span>
     </div>
     <div class="tearch_name">
        <form id="popup" method="post" action="<?php echo U('Manage/stuEdit');?>">
          <input type="hidden" name="hidden_id">
          <p>学号：<input class="A_text" type="text" name="stu_no" value="<?php echo ($vo["no"]); ?>"></p>
          <p>姓名：<input class="A_text" type="text" name="stu_name" value="<?php echo ($vo["name"]); ?>"></p>
          <p>班级：<input class="A_text" type="text" name="stu_class" value="<?php echo ($vo["class_name"]); ?>"></p>
          <p><input type="submit" value="保&nbsp;存" class="A_btn" style="font-size:14px;"></p>
      </form>
     </div>
  </div>
</div>

</div>

<script type="text/javascript">
//弹出隐藏层
function ShowDiv(show_div,bg_div,obj){
  document.getElementById(show_div).style.display='block';
  document.getElementById(bg_div).style.display='block' ;
  var bgdiv = document.getElementById(bg_div);
  bgdiv.style.width = document.body.scrollWidth;
  $("#"+bg_div).height($(document).height());
  $("#popup").find("input:hidden").val($(obj).prev().val());
  $("[name='stu_no']").val($(obj).parent().siblings(".n3").text());
  $("[name='stu_name']").val($(obj).parent().siblings(".n4").text());
  $("[name='stu_class']").val($(obj).parent().siblings(".n5").text());
}
//关闭弹出层
function CloseDiv(show_div,bg_div) {
  document.getElementById(show_div).style.display='none';
  document.getElementById(bg_div).style.display='none';
}
</script>



<script type="text/javascript">
  function search() {
    //alert($("#stu_no").val());
    if ($("#stu_no").val()) {
      document.formsearch.action="<?php echo U('Manage/search');?>";
      document.formsearch.submit();
    } else{
      alert('请输入学号！');
      return false;
    }
    
  }
  function SelectAll() {
    var checkboxs=document.getElementsByName("idno[]");
    console.log(checkboxs);
    for (var i=0;i<checkboxs.length;i++) {
    var e=checkboxs[i];
    e.checked=!e.checked;
    }
  }
  function mp3(obj) {
    //console.log($(obj).prev().val());
    $.get('/admin/manage/one_mp3',
      {
        id:$(obj).prev().val()
      },
      function(data) {
        alert(data);
        window.location.reload();
      },
      'json');
    return false;
  }
  function mp3_all() {
    alert('此过程会需要一定时间，请等待！');
    document.form1.action="/admin/manage/mp3All";
    document.form1.submit();
  }
  function del() {
    var con;  
    con=confirm("您确定删除吗?此操作将不能恢复!"); //在页面上弹出对话框  
    if(con==true) {
      document.form1.action="/admin/manage/delAll";
      document.form1.submit();
    } else {
      
    }  
  }

</script>
</body>
</html>