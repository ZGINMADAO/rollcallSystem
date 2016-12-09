<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
  
</head>
<link type="text/css" href="/Public/css/style.css" rel="stylesheet" />
<style type="text/css">
.dm_list li.n0{ width:15%;}	
.dm_list li.n1{ width:10%;}	
.dm_list li.n2{ width:15%;}	
.dm_list li.n3{ width:20%;}		
.dm_list li.n4{ width:20%;}		
.dm_list li.n5{ width:20%;}		

</style>
<body>

<div class="main">
  <h3>学生上课记录</h3>
  <div class="dm_main">
    <div class="dm_content">
       <div class="dm_list">
           <ul class="dm_bt">
           	 <li class="n0">教&nbsp;师</li>
             <li class="n1">班&nbsp;级</li>
             <li class="n2">姓&nbsp;名</li>
             <li class="n3">已&nbsp;到</li> 
             <li class="n4">请&nbsp;假</li>
             <li class="n5">旷&nbsp;课</li>
           </ul>
           <?php if(is_array($stuStaDeatil)): $i = 0; $__LIST__ = $stuStaDeatil;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$val): $mod = ($i % 2 );++$i;?><ul class="dm_nrli">
           	 <li class="n0"><?php echo ($val["teacher_name"]); ?></li>
             <li class="n1"><?php echo ($val["class_name"]); ?></li>
             <li class="n2"><?php echo ($val["stu_name"]); ?></li>
             <li class="n3"><?php if($val["state"] == 1): ?><img src="/Public/images/tru.png">&nbsp;<?php echo (date("Y-m-d",$val["create_time"])); endif; ?></li> 
             <li class="n4"><?php if($val["state"] == 2): ?><img src="/Public/images/round.png">&nbsp;<?php echo (date("Y-m-d",$val["create_time"])); endif; ?></li>
             <li class="n5"><?php if($val["state"] == 3): ?><img src="/Public/images/err.png">&nbsp;<?php echo (date("Y-m-d",$val["create_time"])); endif; ?></li>
           </ul><?php endforeach; endif; else: echo "" ;endif; ?>
       </div>


      <div class="pagination"><?php echo ($page); ?></div>

    </div>
  </div>
</div>


</body>
</html>