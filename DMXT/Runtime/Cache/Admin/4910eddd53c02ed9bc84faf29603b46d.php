<?php if (!defined('THINK_PATH')) exit();?><html>
<head>
<meta charset="UTF-8" />
<title></title>
<script src="/Public/js/echarts.js"></script>
<script src="/Public/js/jquery-1.9.1.min.js" language="javascript"></script>
<script src="/Public/js/calendar.js" language="javascript"></script>
<link type="text/css" href="/Public/css/style.css" rel="stylesheet" />
</head>
<body>

<style type="text/css">
.dm_content{
	width:96%;
	margin:20px auto;
	}
.export{width:96%; height:30px; margin:30px auto; text-align:center;}
.exportli li{ height:30px; float:left; margin:0 10px;}
.exportli li .ramin{ font-size:14px; padding-right:3px;}
.exportli select{ width:160px; height:26px; margin:2px 5px 0px 5px;}
.exportli .A_text{ width:160px;}
.export2{width:96%; height:50px; line-height:50px; margin:40px auto; text-align:center; font-size:20px; }
.export2 b{ margin:0 30px;}
.export2 span{ color:#f00;}

</style>
<div class="main">
    <h3>点名分析</h3>
  <div class="dm_main">
    <div class="dm_content">
<!-- 下拉框 -->
   <div class="export">
    <form name="sta_form" method="post" style="float:left;">
    <ul class="exportli"> 
      <li>
        <select name="teacher">
           <option value="">请选择教师</option>
           <?php if(is_array($tea_list)): $i = 0; $__LIST__ = $tea_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vol): $mod = ($i % 2 );++$i;?><option value="<?php echo ($vol["user"]); ?>" <?php if($arr[0] == $vol['nikename']): ?>selected<?php endif; ?> >
           <?php echo ($vol["nikename"]); ?>(<?php echo ($vol["user"]); ?>)
           </option><?php endforeach; endif; else: echo "" ;endif; ?>
        </select>
      </li>
      <li>
        <select name="cls">
           <option value="">请选择班级</option>
           <?php if(is_array($cls_list)): $i = 0; $__LIST__ = $cls_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$val): $mod = ($i % 2 );++$i;?><!-- <option value="<?php echo ($val["name"]); ?>" <?php if($arr[1] == $val['name']): ?>selected<?php endif; ?>><?php echo ($val["name"]); ?></option> -->
           <option value="<?php echo ($val["id"]); ?>" <?php if($arr[1] == $val['name']): ?>selected<?php endif; ?>><?php echo ($val["name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
        </select>
      </li>

      <li>
        <select name="stu">
           <option value="">请选择学生</option>
           <?php if(is_array($stu_list)): $i = 0; $__LIST__ = $stu_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vl): $mod = ($i % 2 );++$i;?><option value="<?php echo ($vl["id"]); ?>" <?php if($arr[1] == $vl['name']): ?>selected<?php endif; ?>><?php echo ($vl["name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
        </select>
      </li>

      <li><span class="ramin">起始日期：</span><input type="text" class="A_text" name="beginDate" id="" onClick="new Calendar().show(this);" readonly ></li>
      <li><span class="ramin">结束日期：</span><input type="text" class="A_text" name="overDate" id="" onClick="new Calendar().show(this);" readonly ></li>
      <li><input type="button" class="A_btn" value="开始分析" onClick="renderChart()" ></li>
     </ul>   
    </form>
    </div>
   
   <div class="export2">
     <b>已到：<span id="arrive"><?php echo ($arrive); ?></span> 次</b>
     <b>请假：<span id="vocation"><?php echo ($absent); ?></span> 次</b>
     <b>旷课：<span id="absent"><?php echo ($vocation); ?></span> 次</b>
   </div>
 <!-- 为ECharts准备一个具备大小（宽高）的Dom -->
   <div id="main" style="width: 600px;height:400px; overflow:hidden; margin:20px auto;"></div>


   <div id="col" style="width: 600px;height:400px;overflow:hidden; margin:20px auto"></div>
   
   </div>
  </div>
</div>


   <script type="text/javascript">
        // 基于准备好的dom，初始化echarts实例
      var myChart = echarts.init(document.getElementById('main'));

        // 使用刚指定的配置项和数据显示图表。
         myChart.setOption({
            title : {
               text: '点名分析',
               subtext: '',
               x:'center'
            },
            tooltip : {
               trigger: 'item',
               formatter: "{a} <br/>{b} : {c} ({d}%)"
            },
            legend: {
               orient: 'vertical',
               left: 'left',
               data: ['已到','请假','旷课']
            },
            series : [{
               name: '上课出勤率',
               type: 'pie',
               radius : '60%',
               center: ['50%', '60%'],
               color: ['green', 'orange', 'red'],
               data:[
                  {value:<?php echo ($arrive); ?>, name:'已到'},
                  {value:<?php echo ($vocation); ?>, name:'请假'},
                  {value:<?php echo ($absent); ?>, name:'旷课'},
               ]
            }],
            itemStyle: {
               emphasis: {
                  shadowBlur: 10,
                  shadowOffsetX: 0,
                  shadowColor: 'rgba(0, 0, 0, 0.5)'
                }
            }
         });

var myCol = echarts.init(document.getElementById('col'));
        // 使用刚指定的配置项和数据显示图表。
        myCol.setOption({
            title: {
                text: '点名分析'
            },
            tooltip: {},
            legend: {
                data:['上课出勤数']
            },
            xAxis: {
               data: ["已到","请假","旷课"]

            },
            yAxis: {},
            series: [{
                name: '上课出勤数',
                type: 'bar',
                data: [<?php echo ($arrive); ?>, <?php echo ($vocation); ?>,<?php echo ($absent); ?>],
                barMaxWidth:"45%"
            }]
        });

  
      function renderChart() {


      
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


         $.ajax({
            type:"get",
            url:"<?php echo U('renderView');?>",
            data:{
               teacher:$("[name='teacher']").val(),
               cls:$("[name='cls']").val(),
               stu:$("[name='stu']").val(),
               beginDate:$("[name='beginDate']").val(),
               overDate:$("[name='overDate']").val()
            },
            success:function(msg){
               if (msg.status===0){
                  alert(msg.info);
                  return;
               }
               console.log(msg);
               myChart.setOption({
                  series : [{
                     data:[
                        {value:msg[0], name:'已到'},
                        {value:msg[1], name:'请假'},
                        {value:msg[2], name:'旷课'},
                     ]
                  }]
               });
               myCol.setOption({
                  series: [{
                     data: [msg[0], msg[1],msg[2]]
                  }]
               });

               if ((msg[0] == 0) && (msg[1] == 0) && (msg[2] == 0)) {
                alert('未查询到点名状态');
               }
               $("#arrive").text(msg[0]);
               $("#vocation").text(msg[1]);
               $("#absent").text(msg[2]);
            },
            error:function(){
               alert('异步请求失败！');
            }

         });
      }
   </script>

</body>
</html>