// JavaScript Document

$(document).ready(function(){

//==========列表页面=========//
	//列表菜单奇数行换色
    $(".list_table tr:even").addClass("alt_row");
	//点击审核，自己消失，选项出现
	$(".shenhe").click(function(){
		$(this).parents(".list_table").find(".shenhe").show();
		$(this).parents(".list_table").find(".hide").hide();
		$(this).hide();
		$(this).next($(".hide")).show();
	});
	
	$(".del").click(function(){
		 if(confirm("确定删除吗？删除后将不可撤销")){
			 $(this).parents("tr").find("#chk").attr("checked","checked");
			 $("#form1").submit();
		 }else{
			return false;
		}
	});
	
	$("#del").click(function(){
		 c=$("input[name='chk']:checked");
		if(c.length==0){
			parent.msgbox(2)
			return false;
		}
		else if(confirm("确定删除吗？删除后将不可撤销")){
		  $("#form1").submit();
		}
		else{
		return false;
		}		
	  });	

//=============表单页面==============//	
	//focus加边框标注
	$(":text,:password,textarea").bind({
		focus:function(){$(this).addClass("input_focus");},
		blur:function(){$(this).removeClass("input_focus");},
		click:function(){$(this).css("background-color","#FFFFFF")}
	});	
	$("select").bind({
		focus:function(){$(this).css("background-color","#FFFFFF")}		 
	});
	//文本框内容去掉空格，复制粘贴后触发keyup
		$("input").bind({
			change:function(){			
				var v=$(this).val();
				v=$.trim(v);
				$(this).val(v);
				$(this).keyup();
			},
			blur:function(){
				$(this).keyup();
			}
		})
	//列表框失去焦点触发change
	$("select").bind({
		blur:function(){
			$(this).change();
			$(this).click();
		} 
	})
	
//================仿word表格页面==============//
    //回车符号的消失和显示
	$(".word_table input,.word_table textarea").bind({
		focus:function(){
			$(this).css("background","none");
		},
		blur:function(){
			if($(this).val().length==0){
				$(this).css("background","url(images/enter.png) no-repeat");	
			}	
		},
		change:function(){
			$(this).blur();	
		}
	});
	//导出word表单提交
	$("#download").click(function(){
		var txt=$(".middle").html();
		$("input[name='txt']").val(txt);
		$("#form1").submit();
	});
	
//==============通用设置==============//	
	//蓝色按钮鼠标经过
	$(".button_blue").hover(
		function(){
			var one=$(this).children(":first");
			var two=$(this).children(":first").next();
			one.stop().animate({top:'-25'},300);
			two.stop().animate({top:'0'},300);
			},
		function(){
			var one=$(this).children(":first");
			var two=$(this).children(":first").next();
			one.stop().animate({top:'0'},300);
			two.stop().animate({top:'25'},300);
			}
	);	
    //自定义弹出提示框
	$("#alertbox .yes").click(function(){
		$("#alertbox").css("display","none");
		$("#blackbg").css("display","none");
	});
    //关闭
    $(".close").click(
			function () {
				$(this).parent().fadeTo(400, 0, function () { // Links with the class "close" will close parent
					$(this).slideUp(400);
				});
				return false;
			}
		);
	//返回上一个页面
	$("#back").click(function(){
		window.history.go(-1);				  
	})

	

	
	

	
});//jq结束




//超链接打开新窗口
function openWindow(url,type){
	//alert(url)
	//window.open(url,'','height='+document.body.scrollHeight +',width=1000,top=0,left=200,toolbar=no,menubar=no,scrollbars=yes, resizable=no,location=no, status=no')
	if(type==2){
		window.location.href=(url);
	}else{
		
		window.open(url);
	}
}
//
//function msgbox(){
//	var msg=parent.document.getElementById('msg');
//	msg.animate({top:'0px'},1000);
//	}


//页面跳转时给予跳转提示
//window.onbeforeunload = function() { 
//	parent.loadingbox(1);
//	//return "您修改的设置尚未保存，确定离开吗？";
//}
//window.onload = function(){
//	parent.loadingbox(0);	
//}

function msgbox(txt){
	if(txt==1){txt="操作成功"};
	if(txt==2){txt="未选中任何记录"};
	if(txt==3){txt="请检查表单是否填写正确"};
	txt="<div id='msg'>"+txt+"</div>"
	$("body").prepend(txt);
	$("#msg").stop(true,true).animate({top:'0px'},500).delay(3000).animate({top:'-40px'},500,function(){window.close();});
	
}

//information出现
function noti_show(type,txt){
	$("."+type).find("div").html(txt);
	$("."+type).slideDown(400,function(){
			$(this).fadeTo(400,1)				   
	   })

}

