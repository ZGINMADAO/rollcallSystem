// JavaScript Document

$(document).ready(function(){

//==========�б�ҳ��=========//
	//�б�˵������л�ɫ
    $(".list_table tr:even").addClass("alt_row");
	//�����ˣ��Լ���ʧ��ѡ�����
	$(".shenhe").click(function(){
		$(this).parents(".list_table").find(".shenhe").show();
		$(this).parents(".list_table").find(".hide").hide();
		$(this).hide();
		$(this).next($(".hide")).show();
	});
	
	$(".del").click(function(){
		 if(confirm("ȷ��ɾ����ɾ���󽫲��ɳ���")){
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
		else if(confirm("ȷ��ɾ����ɾ���󽫲��ɳ���")){
		  $("#form1").submit();
		}
		else{
		return false;
		}		
	  });	

//=============��ҳ��==============//	
	//focus�ӱ߿��ע
	$(":text,:password,textarea").bind({
		focus:function(){$(this).addClass("input_focus");},
		blur:function(){$(this).removeClass("input_focus");},
		click:function(){$(this).css("background-color","#FFFFFF")}
	});	
	$("select").bind({
		focus:function(){$(this).css("background-color","#FFFFFF")}		 
	});
	//�ı�������ȥ���ո񣬸���ճ���󴥷�keyup
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
	//�б��ʧȥ���㴥��change
	$("select").bind({
		blur:function(){
			$(this).change();
			$(this).click();
		} 
	})
	
//================��word���ҳ��==============//
    //�س����ŵ���ʧ����ʾ
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
	//����word���ύ
	$("#download").click(function(){
		var txt=$(".middle").html();
		$("input[name='txt']").val(txt);
		$("#form1").submit();
	});
	
//==============ͨ������==============//	
	//��ɫ��ť��꾭��
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
    //�Զ��嵯����ʾ��
	$("#alertbox .yes").click(function(){
		$("#alertbox").css("display","none");
		$("#blackbg").css("display","none");
	});
    //�ر�
    $(".close").click(
			function () {
				$(this).parent().fadeTo(400, 0, function () { // Links with the class "close" will close parent
					$(this).slideUp(400);
				});
				return false;
			}
		);
	//������һ��ҳ��
	$("#back").click(function(){
		window.history.go(-1);				  
	})

	

	
	

	
});//jq����




//�����Ӵ��´���
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


//ҳ����תʱ������ת��ʾ
//window.onbeforeunload = function() { 
//	parent.loadingbox(1);
//	//return "���޸ĵ�������δ���棬ȷ���뿪��";
//}
//window.onload = function(){
//	parent.loadingbox(0);	
//}

function msgbox(txt){
	if(txt==1){txt="�����ɹ�"};
	if(txt==2){txt="δѡ���κμ�¼"};
	if(txt==3){txt="������Ƿ���д��ȷ"};
	txt="<div id='msg'>"+txt+"</div>"
	$("body").prepend(txt);
	$("#msg").stop(true,true).animate({top:'0px'},500).delay(3000).animate({top:'-40px'},500,function(){window.close();});
	
}

//information����
function noti_show(type,txt){
	$("."+type).find("div").html(txt);
	$("."+type).slideDown(400,function(){
			$(this).fadeTo(400,1)				   
	   })

}

