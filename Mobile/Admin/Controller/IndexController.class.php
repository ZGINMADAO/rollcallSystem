<?php
namespace Admin\Controller;
use Think\Controller;
class IndexController extends Controller{
  protected function _initialize(){
    if(empty(session('nameid'))) {
        $this->error('当前用户未登录或登录超时，请重新登录',U('Login/login'));
    }
  }
	//登陆跳转显示页面
    public function index() {
      if (session('nameid') == C('USER_ADMINISTRATOR')) {
        $class_list = M('class') -> select();
        $this -> assign('class_list',$class_list);
        $this -> display();
      } else {
        //通过用户id来查询该id所有信息
        $res=M("teacher")->find(session("nameid"));
        //通过从教师表里面获取班级ID（class_id）来查询班级表里面的数据
        $class_list = M('class')-> select($res['class_id']);
        //dump($class_list);
        $this -> assign('class_list',$class_list);//将从班级表查询出来的数据渲染到rollCall.html页面
        $this -> assign('res',$res);
        $this -> display();
      }
    }
    //获取点名信息
    public function stu() {
      //接收前台下拉框获取的班级名称（class_name）查询学生表里面的信息
      $result = M('Stu') -> where(array('class_name' => I('get.class_name'))) -> select();
      if (empty($result)) {
        $this -> error('获取学生信息失败，请检查该班学生信息是否存在');
      } else {
        $this->ajaxReturn($result);
      }
    }
    //保存学生上课状态
  public function statesave() {
    $res=M("teacher")->find(session("nameid"));
    $dataList = I('post.dataList');//接收前台json数据
    $arr=json_decode(htmlspecialchars_decode($dataList));//去除html符号编码，并解析json数据
    $state = M('state');
    $state->startTrans();
    $flag=[];
    foreach ($arr as $value) {
      $data['state'] = $value->state;
      $data['stu_id'] = $value->no;
      $data['stu_name'] = $value->name;
      $data['create_time'] = time();
      $data['teacher_name'] = $res['nikename'];
      $data['tea_no'] = $res['user'];
      $data['class_name'] = $value->class_name;
      $data['cls_id'] = $value->class_id;
      $data['sid'] = $value->id;
      $refalse=$state -> add($data);
      $flag[]=$refalse;
    }
    if (in_array(fasle, $flag)){
      $state->rollback();
      $this->error('学生点名插入错误，回滚成功','',3);
    }else{
      $state->commit();
      $this -> success('学生点名信息云保存成功，请开始上课');
    }
  }
}
    