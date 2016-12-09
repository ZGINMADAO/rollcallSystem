<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8" />
  <title>安徽职业技术学院——在线点名系统</title>
  <script src="/Public/js/calendar.js" language="javascript"></script>
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

.export{width:96%; height:30px; margin:30px auto; text-align:center;}
.exportli b{ height:30px; float:left; margin:8px; font-weight:normal;}
.exportli b .ramin{ font-size:14px; padding-right:3px;}
.exportli select{ width:160px; height:26px;}
.exportli .A_text{ width:160px;}
.export2{width:96%; height:50px; line-height:50px; margin:40px auto; text-align:center; font-size:20px; }
.export2 b{ margin:0 30px;}
.export2 span{ color:#f00;}


.bottom_btn{width:200px; height:30px; margin:30px auto 10px auto; text-align:center;}
.bottom_btn .link{ width:200px; height:30px; line-height:30px; color:#fff; text-align:center; background:#3399FF; border-radius:5px; display:block;}
</style>
<body>

<div class="main">
  <h3>学生列表</h3>
   <div class="dm_main">
      <div class="dm_content">
 
        <div class="export exportli">
          <form name="sta_form" method="get" >
            <b>
              <select name="teacher">
                 <option value="">请选择教师</option>
                 <?php if(is_array($tea_list)): $i = 0; $__LIST__ = $tea_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vol): $mod = ($i % 2 );++$i;?><option value="<?php echo ($vol["user"]); ?>" <?php if($arr[0] == $vol['user']): ?>selected<?php endif; ?> >
                 <?php echo ($vol["nikename"]); ?>(<?php echo ($vol["user"]); ?>)
                 </option><?php endforeach; endif; else: echo "" ;endif; ?>
              </select>
            </b>
            <b>
              <select name="cls">
                 <option value="">请选择班级</option>
                 <?php if(is_array($cls_list)): $i = 0; $__LIST__ = $cls_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$val): $mod = ($i % 2 );++$i;?><option value="<?php echo ($val["id"]); ?>" <?php if($arr[1] == $val['id']): ?>selected<?php endif; ?>><?php echo ($val["name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
              </select>
            </b>
            <b>
              <select name="stu_state">
                <option value="">状态选择</option>
                <option value="1" <?php if($arr[2] == 1): ?>selected<?php endif; ?>>已到</option>
                <option value="2" <?php if($arr[2] == 2): ?>selected<?php endif; ?>>请假</option>
                <option value="3" <?php if($arr[2] == 3): ?>selected<?php endif; ?>>旷课</option>
              </select>
            </b>
            <b><span class="ramin">起始日期：</span><input type="text" class="A_text" name="beginDate" id="" onClick="new Calendar().show(this);" readonly ></b>
            <b><span class="ramin">结束日期：</span><input type="text" class="A_text" name="overDate" id="" onClick="new Calendar().show(this);" readonly ></b>
            <b><input type="button" class="A_btn" value="筛选" onClick="checkselect()" ></b>
            <!-- <b><input type="button" value="全部状态" class="A_btn" onclick="stateAll()"></b> -->
            </form>
            <b>
               <form method="post" action="<?php echo U('Rollcall/search');?>"/>
                <input type="text" name="searchWord" class="A_text" placeholder="输入学号/姓名" />
                <input type="submit" value="搜索" class="A_btn"/>
              </form>
            </b>
    
        </div>

        <div class="dm_list">
        <form name="form1" method="post">
          <ul class="dm_bt">
            <li class="n1"> <input type="checkbox" value="" id="selectAll" onclick="SelectAll()" /></li>
            <li class="n2">序&nbsp;号</li>
            <li class="n3">学&nbsp;号</li>
            <li class="n4">姓&nbsp;名</li>
            <li class="n5">班级名称</li>
            <!-- <li class="m6">班&nbsp;级ID</li> -->
            <li class="n6">教师</li>
            <li class="n7">编&nbsp;辑</li>
            <li class="n8">查&nbsp;看</li>
          </ul>
          <?php $num = '1'; ?>
          <?php if(is_array($result)): $i = 0; $__LIST__ = $result;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><ul class="dm_nrli">
              <li class="n1"><input name="idno[]" type="checkbox" value="<?php echo ($vo["sid"]); ?>"/></li>
              <li class="n2"><?php echo ($num++); ?></li>
              <li class="n3"><a href="<?php echo U('Rollcall/oneStaDeatil',array('sid' => $vo['sid']));?>"><?php echo ($vo["stu_id"]); ?></a></li>
              <li class="n4"><?php echo ($vo["stu_name"]); ?></li>
              <li class="n5"><?php echo ($vo["class_name"]); ?></li>
              
              <li class="n6">
                <?php echo ($vo["teacher_name"]); ?>
              </li>
             
              <li class="n7">
              <a href="<?php echo U('Rollcall/stateEdit',array('sid' => $vo['sid'],'id' => $vo['id']));?>" title="编辑"><img src="/Public/images/edit.png"></a>
              </li>
              <li class="n8">
              <a href="<?php echo U('Rollcall/oneStaDeatil',array('sid' => $vo['sid']));?>" title="查看"><img src="/Public/images/ico_view.gif"></a>
              </li>
            </ul><?php endforeach; endif; else: echo "" ;endif; ?>
        </form>
        </div>
        
        <div class="bottom_btn">
          <a href="#" class="link" onclick="del()"  >批量删除</a>
        </div>
        
        <div class="pagination"><?php echo ($page); ?></div>
      </div>
    
</div>

  <!--分页-->
  
<script type="text/javascript">
  function SelectAll() {
    var checkboxs=document.getElementsByName("idno[]");
    console.log(checkboxs);
    for (var i=0;i<checkboxs.length;i++) {
    var e=checkboxs[i];
    e.checked=!e.checked;
    }
  }
  function del() {
    var con;  
    con=confirm("您确定删除吗?此操作将不能恢复!"); //在页面上弹出对话框  
    if(con==true) {
      document.form1.action="<?php echo U('Rollcall/delAll');?>";
      document.form1.submit();
    } else {
      
    }  
  }

  // function stateAll() {
  //   document.form1.action="<?php echo U('Rollcall/stateAll');?>";
  //   document.form1.submit();
  // }


function checkselect() {
    if($("[name=beginDate]").val().length>1||$("[name=overDate]").val().length>1){
        if($("[name=beginDate]").val().length<1||$("[name=overDate]").val().length<1){
            alert('日期请同时选择起始日期与结束日期，否则不选');
            return false;
        }
    }

    if($("[name=beginDate]").val().length>1&&$("[name=overDate]").val().length>1){
        if(Date.parse($("[name=beginDate]").val())>Date.parse($("[name=overDate]").val())){
            alert('起始日期不能大于结束日期');
            return false;
        }
    }

  document.sta_form.action="<?php echo U('Rollcall/findState');?>";
  document.sta_form.submit();
}
</script>
</body>
</html>