<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>安徽职业技术学院—在线点名系统</title>
    <link type="text/css" href="/Public/css/style.css" rel="stylesheet" />
</head>

<style type="text/css">
.teavodie{
	width:96%;
	margin:20px auto;
	line-height:30px;
	font-size:14px;
	
	color:#444;

	}
.teavodie li{
	height:30px;
	padding:5px 10px;
	border-bottom:1px solid #dadada;
	text-align:right;
	cursor:pointer;
	}
.teavodie li span{
	float:left;
	font-weight:bold;
	}
.teavodie li:hover{
	background:#f7f7f7;
	}
.teavodie li a{
	color:#999;
	}
.teavodie li a:hover{
	color:#aa0615;
	}	
</style>

<body>
<div class="main">
  <h3>音频文件</h3>
  <div class="dm_main">
    <div class="dm_content">
      <div class="teavodie">
        <ul>
          <?php if(is_array($dir)): $i = 0; $__LIST__ = $dir;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$val): $mod = ($i % 2 );++$i;?><li><span><?php echo ($val); ?>年度全部音频信息</span> <a href="<?php echo U('Info/del','dirName='.$val);?>" onclick="return confirm('您确定删除吗?此操作将不能恢复!')"><img src="/Public/images/del.png" title="删除" ></a></li><?php endforeach; endif; else: echo "" ;endif; ?>
        </ul>
      </div>
    </div>
  </div>
</div>
</body>
</html>