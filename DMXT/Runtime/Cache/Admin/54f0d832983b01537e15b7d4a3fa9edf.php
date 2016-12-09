<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8" />
  <title>安徽职业技术学院——在线点名系统</title>
  <link type="text/css" href="/Public/css/style.css" rel="stylesheet" />
  <script src="/Public/js/jquery-1.9.1.min.js" language="javascript"></script>
  <script src="/Public/js/calendar.js" language="javascript"></script>
</head>

<style type="text/css">
.dm_list li.n1{ width:5%;}	
.dm_list li.n2{ width:7%;}	
.dm_list li.n3{ width:15%;}		
.dm_list li.n4{ width:15%;}		
.dm_list li.n5{ width:7%;}		
.dm_list li.n6{ width:15%;}
.dm_list li.n7{ width:15%;}
.dm_list li.n8{ width:15%;}
.dm_list li.n9{ width:6%;}

.export{width:96%; height:30px; margin:30px auto 10px auto; font-size:14px;}
.export select{ width:160px; height:26px; margin:2px 1px 0px 1px;}
.export b{ margin:0 10px; font-weight:normal;}
.export b .A_text{ width:160px;}

</style>
<body>

<div class="main">
  <h3>导出信息</h3>
  <div class="dm_main">
    <div class="dm_content">
    <!-- 下拉框 -->
    <div class="export">
    <form name="sta_form" method="get" style="float:left;"> 
        <b>
    	<select name="teacher">
			<option value="">请选择教师：</option>
			<?php if(is_array($tea_list)): $i = 0; $__LIST__ = $tea_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vol): $mod = ($i % 2 );++$i;?><option value="<?php echo ($vol["user"]); ?>" <?php if($arr[0] == $vol['user']): ?>selected<?php endif; ?> >
			<?php echo ($vol["nikename"]); ?>(<?php echo ($vol["user"]); ?>)
			</option><?php endforeach; endif; else: echo "" ;endif; ?>
    	</select>
        </b>
        
        <b>
    	<select name="class">
			<option value="">请选择班级：</option>
			<?php if(is_array($cls_list)): $i = 0; $__LIST__ = $cls_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$val): $mod = ($i % 2 );++$i;?><option value="<?php echo ($val["name"]); ?>" <?php if($arr[1] == $val['name']): ?>selected<?php endif; ?>><?php echo ($val["name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
    	</select>
        </b>
        <b>
          起始日期：<input type="text" class="A_text" name="beginDate" id="" onclick="new Calendar().show(this);" readonly  value="<?php echo ($begin_date); ?>">
        </b>
        <b>
          结束日期：<input type="text" class="A_text" name="overDate" id="" onclick="new Calendar().show(this);" readonly  value="<?php echo ($over_date); ?>">
        </b> 
        <b>
    	   <input type="button" value="筛选" onclick="checkselect()" class="A_btn">
        </b>
    </form>
    <a href="<?php echo U('Batches/expUser');?>" class=" button_blue" style="width:70px; height:28px; margin-left:10px; line-height:28px; float:left;">
         <span class="view">导出</span>
         <span class="hidden">导出</span>
        </a>
    </div>
    
    
    
    <form name="form1" method="get">
    <div class="dm_list">
      <ul class="dm_bt">
        <li class="n2">序&nbsp;号</li>
        <li class="n3">学&nbsp;号</li>
         <li class="n4">姓&nbsp;名</li> 
        <li class="n5">状&nbsp;态</li>
        <li class="n6">班级名称</li>
        <li class="n7">教&nbsp;师</li>
        <li class="n8">点名时间</li>
      </ul>
      <!--遍历state表查询出的数据-->
      <?php $num = '1'; ?>
      <?php if(is_array($state_list)): $i = 0; $__LIST__ = $state_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><ul class="dm_nrli">
          <li class="n2"><?php echo ($num++); ?></li>
          <li class="n3"><?php echo ($vo["stu_id"]); ?></li>
          <li class="n4"><?php echo ($vo["stu_name"]); ?></li> 
          <li class="n5"><?php echo ($vo["state"]); ?></li>
          <li class="n6"><?php echo ($vo["class_name"]); ?></li>
          <li class="n7"><?php echo ($vo["teacher_name"]); ?></li>
          <li class="n8"><?php echo (date("Y-m-d",$vo["create_time"])); ?></li>
        </ul><?php endforeach; endif; else: echo "" ;endif; ?>
    </div>
    </form>
  </div>
  
  <!--分页-->
  <div class="pagination"><?php echo ($page); ?></div>
    
</div>



<script type="text/javascript">
function checkselect() {
  
  if($("[name=beginDate]").val().length>1||$("[name=overDate]").val().length>1) {
    if($("[name=beginDate]").val().length<1||$("[name=overDate]").val().length<1) {
      alert('日期请同时选择起始日期与结束日期，否则不选');
      return false;
    }
  }
  if($("[name=beginDate]").val().length>1&&$("[name=overDate]").val().length>1) {
    if(Date.parse($("[name=beginDate]").val())>Date.parse($("[name=overDate]").val())) {
      alert('起始日期不能大于结束日期');
      return false;
    }
  }
	document.sta_form.action="<?php echo U('Batches/selectState');?>";
	document.sta_form.submit();
}
</script>
</body>
</html>