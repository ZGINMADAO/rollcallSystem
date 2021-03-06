<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="zh-cn">
<head>
  <meta charset="utf-8" />
  <title>安徽职业技术学院——在线点名系统</title>
  <link type="text/css" href="/Public/css/style.css" rel="stylesheet" />
  <script src="/Public/js/jquery-1.9.1.min.js" language="javascript"></script>
  <!-- <script type="text/javascript" src="/Public/js/default.js"></script> -->
</head>
<style type="text/css">
.dm_list li.m1{ width:5%;}	
.dm_list li.m2{ width:15%;}	
.dm_list li.m3{ width:25%;}		
.dm_list li.m4{ width:25%;}		
.dm_list li.m5{ width:10%;}		
.dm_list li.m6{ width:10%;}
.dm_list li.m7{ width:10%;}

.teaDetail_add{
   width:90%;
   margin:30px auto 0 auto;
   overflow:hidden;
   line-height:30px;
   text-align:center;
   font-size:14px;
   }
.teaDetail_add b{ margin:0 15px; font-weight:normal;}
.teaDetail_add b input{ margin-left:5px;}
</style>

<body>
<div class="main">
  <h3>角色列表</h3>
  <div class="dm_main"> 
    <!-- 添加角色 -->
    <div class="teaDetail_add">
      <form method="post" id="blk" action="<?php echo U('Role/roleAdd');?>">
        <b>角色:<input type="text" class="A_text" id="role" placeholder="不多于四位" name="role_name"/></b>
        <input type="hidden" name="role_id"/>
        <b><input type="submit" class="A_btn" onclick="return checkform()" value="添加"></b>
      </form>
    </div>
    <div class="dm_content">
      <form name="form1" method="post">
        <div class="dm_list">
          <ul class="dm_bt">
            <li class="m1"> <input type="checkbox" value="" id="selectAll" onclick="SelectAll()" /></li>
            <li class="m2">序&nbsp;号</li>
            <li class="m3">角&nbsp;色</li>
            <li class="m4">权&nbsp;限</li>
            <li class="m6">编&nbsp;辑</li>
            <li class="m7">删&nbsp;除</li>
          </ul>
          <?php $num = '1'; ?>
          <?php if(is_array($role)): $i = 0; $__LIST__ = $role;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><ul class="dm_nrli">
              <li class="m1"><input name="idno[]" type="checkbox" value="<?php echo ($vo["id"]); ?>"/></li>
              <li class="m2"><?php echo ($num++); ?></li>
              <li class="m3" id="role"><?php echo ($vo["title"]); ?></li>
              <li class="m4"><a href="<?php echo U('Role/assignAuth',array('id'=>$vo['id']));?>">分配</a></li>
              <li class="m6"><a href="#" onclick="edit(this);"><input type="hidden" value="<?php echo ($vo["id"]); ?>" /><img src="/Public/images/edit.png"></a></li>
              <li class="m7"><a href="<?php echo U('Role/del',array('id'=>$vo['id']));?>" onclick="return confirm('您确定删除吗?此操作将不能恢复!')"><img src="/Public/images/del.png"></a></li>
            </ul><?php endforeach; endif; else: echo "" ;endif; ?>
        </div>
       </form>  
    </div>
    
    <!--分页-->
    <div class="pagination"><?php echo ($page); ?></div>
    
  </div>
</div>

<script type="text/javascript">
function edit(obj) {
  var role_name=$(obj).parent().prev().prev().text();//遍历角色名
  var role_id=$(obj).find("input:hidden").val();//遍历角色id
  $("input[name='role_name']").val(role_name).css("display");
  $("input[name='role_id']").val(role_id);
  $("#blk").attr("action","<?php echo U('Role/edit');?>");
  $("#blk").find(":submit").val("修改");
}
function checkform() {
  if ($("#role").val().length<2 || $("#role").val().length>4) {
    alert('角色名不少于两位,且不能多于四位');
    $("#role").focus();
    return false;
  }
  return true;
}
</script>
</body>
</html>