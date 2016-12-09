<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
<meta charset="utf-8" />
<title>安徽职业技术学院——在线点名系统</title>
<link type="text/css" href="/Public/css/style.css" rel="stylesheet" />
<script src="/Public/js/jquery-1.9.1.min.js" language="javascript"></script>
<!-- <script type="text/javascript" src="/Public/js/default.js"></script> -->
</head>
<body>

<div class="main">
  <h3>班级信息</h3>
    
<div class="dm_main">
    <div class="dm_content">
        <div id="hidden" style="width:350px; margin-top:30px; padding-left:2%;display:none;">
            <form method="post" id="blk">
              <input type="text"  name="cls_name"  class="A_text"/>
              <input type="hidden" name="cls_id" />
              <input type="submit" value="修改" class="A_btn"/>
            </form>
        </div>
        <form name="form1" method="post">
        <div class="dm_list">
            <ul class="dm_bt">
               <!-- <li class="m1">  <input type="checkbox" value="" id="selectAll" onclick="SelectAll()" /> </li> -->
               <li class="m3">序号</li>
               <li class="m4">班级名称</li>
               <li class="m5">编&nbsp;辑</li>
               <li class="m6">删&nbsp;除</li>
            </ul>
            <?php $num = '1'; ?>
            <?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><ul class="dm_nrli">
              <!-- <li class="m1"><input name="idno[]" type="checkbox" value="<?php echo ($vo["id"]); ?>"/></li> -->
              <li class="m3"><?php echo ($num++); ?></li>
              
              <li class="m4"><?php echo ($vo["name"]); ?></li>
              <li class="m5"><a href="#" onclick="edit(this);"><input type="hidden" value="<?php echo ($vo["id"]); ?>" /><img src="/Public/images/edit.png"/> </a></li>
              <li class="m6"><a href="<?php echo U('Manage/classDel',array('id' => $vo['id']));?>" onclick="return confirm('谨慎删除');"><img src="/Public/images/del.png"/></a></li>
            </ul><?php endforeach; endif; else: echo "" ;endif; ?>
        </div>
        </form>
    </div>
    <!--分页-->
    <div class="pagination"><?php echo ($page); ?></div>
</div>



</body>
</html>
<script type="text/javascript">
function edit(obj) {
  alert('谨慎修改');
  $("#hidden").show();
	var className=$(obj).parent().prev().text();//遍历班级名
	var classId=$(obj).find("input:hidden").val();//遍历班级id

	$("input[name='cls_name']").val(className).css("display");
	$("input[name='cls_id']").val(classId);
	$("#blk").attr("action","<?php echo U('Manage/edit');?>");
	$("#blk").find(":submit").val("修改");
}
</script>