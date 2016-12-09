<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="zh-cn">
<head>
<meta charset="utf-8" />
<title>安徽职业技术学院——在线点名系统</title>
<link type="text/css" href="/Public/css/style.css" rel="stylesheet" />
<script src="/Public/js/jquery-1.9.1.min.js" language="javascript"></script>
</head>
<style type="text/css">
.teaDetail_add{
	 width:96%;
	 margin:30px auto 0 auto;
	 overflow:hidden;
	 line-height:30px;
	 text-align:center;
	 font-size:14px;
	 }
.teaDetail_add b{ margin:0 15px; font-weight:normal;}
.teaDetail_add b input{ margin-left:5px;}

.dm_list li.n1{ width:8%;}	
.dm_list li.n2{ width:8%;}	
.dm_list li.n3{ width:18%;}		
.dm_list li.n4{ width:20%;}		
.dm_list li.n5{ width:30%;}		
.dm_list li.n6{ width:8%;}
.dm_list li.n7{ width:8%;}


</style>


<body>
<div class="main">
  <h3>教师信息</h3>  
  <div class="dm_main">
  <?php if(checkRule('Manage/teacherAdd',session('nameid'))): ?><div class="teaDetail_add">
        <form method="post" action="<?php echo U('Manage/teacherAdd');?>" id="blk">
            <b>姓名:<input type="text" class="A_text"  id="tea_name" name="tea_name" onkeyup="value=value.replace(/[^\u4E00-\u9FA5]/g,'')" onblur="this.value=this.value.replace(/[^\u4E00-\u9FA5]/g,'')"/></b>
            <b>用户名:<input type="text" class="A_text" id="jobnum" name="tea_no" onkeyup="this.value=this.value.replace(/[\W]/g,'') " onblur="this.value=this.value.replace(/[\W]/g,'')" /></b>
            <!-- <div style="display:none;" id="hidden"> -->
            <b>密码:<input type="password" class="A_text" id="jobnum" name="password" onkeyup="this.value=this.value.replace(/[\W]/g,'') " onblur="this.value=this.value.replace(/[\W]/g,'')" /></b>
            <!-- </div> -->
            <input type="hidden" name="editid"/>
            <b><input type="submit" class="A_btn" onclick="return teaAdd()" value="添加"></b>
        </form>
      </div><?php endif; ?>
      <div class="dm_content">
        <form name="form1" method="post"> 
          <div class="dm_list">
              <ul class="dm_bt">
                 <li class="n1">序&nbsp;号</li>
                 <li class="n2">姓&nbsp;名</li>
                 <li class="n3">班&nbsp;级</li>
                 <li class="n4">职工号</li>
                 <li class="n5">密&nbsp;码</li>
                 <?php if(checkRule('Manage/teaEdit',session('nameid'))): ?><li class="n6">编&nbsp;辑</li><?php endif; ?>
                 <?php if(checkRule('Manage/teaDel',session('nameid'))): ?><li class="n7">删&nbsp;除</li><?php endif; ?>
              </ul>
              <?php $num = '1'; ?>
              <?php if(is_array($result)): $i = 0; $__LIST__ = $result;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><ul class="dm_nrli">
                 <li class="n1"><?php echo ($num++); ?></li>
                 <li class="n2"><?php echo ($vo["nikename"]); ?></li>
                 <li class="n3"><a href="/admin/manage/classDetail/id/<?php echo ($vo["id"]); ?>">分配班级</a></li>
                 <li class="n4"><?php echo ($vo["user"]); ?></li>
                 <li class="n5"><?php echo substr_replace($vo.pwd,'******',0);?></li>
                 <?php if(checkRule('Manage/teaEdit',session('nameid'))): ?><li class="n6">
                  <a href="#" onclick="edit(this)"><input type="hidden" value="<?php echo ($vo["id"]); ?>" /><img src="/Public/images/edit.png" ></a>
                 </li><?php endif; ?>
                 <?php if(checkRule('Manage/teaDel',session('nameid'))): ?><li  class="n7"><a href="<?php echo U('Manage/teaDel',array('id'=>$vo['id']));?>" onclick="return confirm('您确定删除吗?此操作将不能恢复!');"><img src="/Public/images/del.png" ></a>
                 </li><?php endif; ?>
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
  // $("#hidden").show();
  var tea_name=$(obj).parent().prev().prev().prev().prev().text();//遍历老师名
  var tea_no=$(obj).parent().prev().prev().text();//遍历用户名
  var password=$(obj).parent().prev().text();//遍历密码
  var teaId=$(obj).find("input:hidden").val();//遍历id
  $("input[name='tea_no']").val(tea_no).css("display");
  $("input[name='password']").val(password).css("display");
  $("input[name='tea_name']").val(tea_name);
  $("input[name='editid']").val(teaId);
  $("#blk").attr("action","<?php echo U('Manage/teaEdit');?>");
  $("#blk").find(":submit").val("修改");

}
function teaAdd() {
  if ($("#tea_name").val().length<2) {
    alert('请输入姓名,姓名不少于两位！');
    $("#tea_name").focus(); //定光标
    return false;
  }
  if ($("#jobnum").val().length<5) {
    alert('请输入用户名，用户名不少于五位！');
    $("#jobnum").focus();
    return false;
  }
  return true;
}
</script>
</body>
</html>