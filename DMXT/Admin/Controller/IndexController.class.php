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
      $res=M("teacher")->find(session("nameid"));
      $list = M('auth_group_access') -> where(array('uid' => session("nameid"))) -> find();
      // dump($list);
      $role = M('auth_group') -> where(array('id' => $list['group_id'])) -> find();
      // dump($role);
      $this -> assign('role',$role);
      $this -> assign('res',$res);
      $this -> display();
    }
    //欢迎页
    public function welcome() {
      $this -> display();
    }
    public function edit() {
      if (empty($_POST)) {

        $this -> display();
      } else {
        $map['pwd'] = md5(I('post.new_pwd'));

        $msg['user'] = I('post.tea_no');
        $msg['pwd'] = md5(I('post.pwd'));
        $msg['id'] = session("nameid");
        
        $list = M('teacher') -> where($msg) -> find();
        if ($list) {
          M('teacher') -> where(array('id' => session("nameid"))) -> save($map);
            $this -> success('修改密码成功！');
        } else {
          $this -> error('用户名或旧密码输入错误');
        }
      }
    }
    private function tech_to_role() {
      $m=M();
      $result=$m->query("select d.*,c.title from (select * from dm_teacher as a left join dm_auth_group_access as b on a.id=b.uid where id<>".C('USER_ADMINISTRATOR').") as d left join dm_auth_group as c on d.group_id= c.id");
      return $result;
    }
   
}