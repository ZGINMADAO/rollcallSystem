<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
	<link type="text/css" href="/Public/css/style.css" rel="stylesheet" />
  <script src="/Public/js/jquery-1.9.1.min.js" language="javascript"></script>
</head>
<style type="text/css">
.listNav{ width:98%; min-height:500px;overflow:hidden; margin:10px auto; background:#fff; border:1px solid #dadada;}
.listmain{ width:96%; padding:10px 0; margin:10px auto; overflow:hidden; font-size:14px;}
.listmain h1{ line-height:32px; font-size:16px; color:#333;}
.listmain .Role_manage{ font-size:14px; color:#444; overflow:hidden;}
.listmain .Role_manage ul li{ line-height:26px; float:left; padding:2px 10px;}
.listmain .Role_manage ul li input{ vertical-align:middle; margin-right:5px; margin-bottom:5px;}


.listmain .check{vertical-align:middle; margin-right:5px; margin-bottom:5px;}
.listmain .btn{ width:80px; height:24px; line-height:24px; outline:none; border:0; background:#09F; color:#fff; text-align:center; cursor:pointer;}
.listmain .btn:hover{ background:#606;}

</style>
<body>

<div class="main">
 <h3>角色列表</h3>
 <form action="<?php echo U('Role/changeAuth');?>" method="post">
  <div class="dm_content">
    <div class="listmain">
       <input type="checkbox" class="check" id="selectAll" onclick="SelectAll(this)" />全选
    </div>
    <?php if(is_array($authOne)): $i = 0; $__LIST__ = $authOne;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><div class="listmain">
    <h1> <input name="authid[]" class="check" type="checkbox" value="<?php echo ($vo["id"]); ?>" onclick="selectOne(this);" <?php if(in_array($vo['id'],$roleAuth) == 'true'): ?>checked<?php endif; ?>><?php echo ($vo['title']); ?></h1>
    <div class="Role_manage">
      <ul>
        <?php if(is_array($authSec)): $i = 0; $__LIST__ = $authSec;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vol): $mod = ($i % 2 );++$i; if($vo['id'] == $vol['level']): ?><li><input name="authid[]" type="checkbox" value="<?php echo ($vol["id"]); ?>" <?php if(in_array($vol['id'],$roleAuth) == 'true'): ?>checked<?php endif; ?>><?php echo ($vol['title']); ?></li><?php endif; endforeach; endif; else: echo "" ;endif; ?>
        <input type="hidden" name="roleid" value="<?php echo ($id); ?>" >
      </ul>
    </div>
    </div><?php endforeach; endif; else: echo "" ;endif; ?>
    <div class="listmain">
       <input type="submit" class="btn" value="添加">
    </div>
  </div>
  </form>
</div> 

</body>
<script type="text/javascript">
//全选
function SelectAll(obj) {
    var checkboxs=document.getElementsByName("authid[]");

    if($(obj).prop("checked")==true){
        $(checkboxs).prop("checked",true);
    }else{
        $(checkboxs).prop("checked",false);
    }

  }
  //一级栏全选
  function selectOne(obj){
    if($(obj).prop("checked")==true){
       console.log($(obj).parent().next().find("input:checkbox"));
       $(obj).parent().next().find("input:checkbox").prop("checked",true);
    }else{
       $(obj).parent().next().find("input:checkbox").prop("checked",false);
    }
  }
</script>
</html>