var arr;
var int;
var release;
$("#sele2").change(function(){
  if(!$("#sele2 option:selected").val()){
    return;
  }
  $.ajax({
    url:"{:U('Index/stu')}",
    data:{class_name:$("#sele2 option:selected").val()},//获取下拉框班级表（name字段的值）
    error:function(){
      alert("拉取学生名单失败！");
      return;
    },
    success:function(msg){
      console.log(msg);
        arr=msg;
    }
  });
});
function begin(){

}