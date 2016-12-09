<?php
namespace Admin\Controller;
class RoleController extends AdminController {
    //权限添加
    public function addAuth() {
        if ($_POST) {
            $map['name'] = I('post.auth_fun');
            $map['title'] = I('post.auth_name');
            $map['level'] = I('post.auth_level');
            $map['type'] = 1;
            $map['status'] = 1;
            M('auth_rule') -> add($map);
            $this -> success('addAuth');
        } else {
            $this -> selectAll();
            $this -> display();
        }
    }
    //查询所有权限
    public function selectAll() {
       $listAll = M('auth_rule') -> order('id') -> select();
       $this -> assign('listAll',$listAll);
    }
    //权限修改
    public function authEdit() {
        $map['name'] = I('post.auth_fun');
        $map['title'] = I('post.auth_name');
        $map['level'] = I('post.auth_level');
        $map['type'] = 1;
        $map['status'] = 1;
        M('auth_rule') -> where(array('id' => I('post.auth_id'))) -> save($map);
        $this -> success();
    }
    //权限删除
    public function authDel() {
        M('auth_rule') -> where(array('id' => I('get.id'))) -> delete();
        $this -> success();
    }
    //权限列表
	private function authList() {
		$this -> display();
	}
    //角色列表
	public function roleList() {
		$role = M('auth_group') -> where('id<>'.C('USER_ADMINISTRATOR')) -> select();
        //dump($role);
		$this -> assign('role',$role);
		$this -> display();
	}
    //角色信息添加
    public function roleAdd() {
        if (empty($_POST)) {
            $this -> error();
        } else {
            $role_add = M('auth_group');
            $role_add -> title=I('post.role_name');
            $role_add -> status=1;
            $role_add -> add();
            $msg = $role_add -> where(array('title' => I('post.role_name'))) -> find();
            //dump($msg);
            $this -> success();
        }
    }
    //角色名修改
    public function edit() {
        $map['title'] = I('post.role_name');
        $relust = M('auth_group') -> where(array('id' => I('post.role_id'))) -> save($map);
        if (!$relust) {
            $this -> error();
            exit();
        }
        $this -> success();
    }
    //角色删除
    public function del() {
       
        M('auth_group') -> where(array('id' => I('get.id'))) -> delete();

        $this -> success();
    }
    //分配权限
	public function assignAuth() {
		$authOne = M('auth_rule') -> where("level = 0") -> field('id,title') -> select();
        $authSec = M('auth_rule') -> where("level != 0") -> field('id,level,title') -> select();
		//$id = I('get.id');
		$group = M('auth_group') -> find(I('get.id'));
		$roleAuth=explode(",",$group['rules']);
		$this->assign('id',I('get.id'));
		$this -> assign('authOne',$authOne);
        $this -> assign('authSec',$authSec);
		$this -> assign('roleAuth',$roleAuth);
		$this -> display('authlist');
	}
    //修改权限
	public function changeAuth() {
        // $authids = I('post.authid');
        // //dump($authids);
        // $roleid = I('post.roleid');
        $authids=implode(",",I('post.authid'));
        $data['rules'] = $authids;
        M('auth_group') -> where('id='.I('post.roleid')) -> save($data);
        $this->success('权限修改成功');
    }
    //分配角色
    public function assignRole() {
    	// $id = I('post.hideid');
        //$role = I('post.roleSelect');
        $map['group_id'] = I('post.roleSelect');
        $GroupAccess = M('auth_group_access') -> where('uid='.I('post.hideid')) -> save($map);
    	$this -> success('分配角色成功！');
    }
    //教师列表
    public function teacherList() {
    	// $map['id']  = array('neq',C('USER_ADMINISTRATOR'));
    	// $teac_list = M('teacher')-> where($map)-> select();
    	// $teacher = M('teacher');
    	// $result = $teacher->relation(true)->select();
    	$teacherRole=$this->tech_to_role();
    	$roleAll = M('auth_group') -> where('id<>'.C('USER_ADMINISTRATOR')) -> select();
        //dump($roleAll);
        //dump($teacherRole);
		$this -> assign('roleAll',$roleAll);   	
  		$this -> assign('teacherRole',$teacherRole);
    	$this -> display();
    }
    //教师指向角色
    private function tech_to_role() {
    	$m=M();
    	$result=$m->query("select d.*,c.title from (select * from dm_teacher as a left join dm_auth_group_access as b on a.id=b.uid where id<>".C('USER_ADMINISTRATOR').") as d left join dm_auth_group as c on d.group_id= c.id");
    	return $result;
    }
}