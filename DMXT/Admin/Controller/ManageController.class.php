<?php
namespace Admin\Controller;
class ManageController extends AdminController {
    //教师信息显示
    public function teaDetail() {
        //管理员
        if (session("nameid") == C('USER_ADMINISTRATOR')) {
            $pagecount = 20;//每页100条数据
            $count = M('teacher') -> where('id<>'.C('USER_ADMINISTRATOR'))-> count();//数据总条数
            $page = new \Think\Page($count,$pagecount);
            $page->setConfig('header','<span class="rows">'.$pagecount.' 条/页 共 %TOTAL_ROW% 条</span>');
            $page->setConfig('theme','%UP_PAGE% %FIRST% %LINK_PAGE% %END% %DOWN_PAGE% %HEADER% ');
            $show = $page -> show();
            $result = M('teacher') -> where('id<>'.C('USER_ADMINISTRATOR'))-> limit($page->firstRow.','.$page->listRows)-> select();
            $this -> assign('result',$result);
            $this -> assign('page', $show);
            $this -> display();
        } else {
            //普通教师
            $result=M("teacher")->select(session("nameid"));
            $this -> assign('result',$result);
            $this -> display();
        }
    }
    //教师信息添加
    public function teacherAdd() {
        if (session("nameid") == C('USER_ADMINISTRATOR')) {
            $tea['nikename'] = I('post.tea_name');
            $tea['user'] = I('post.tea_no');
            $tea['pwd'] = md5(I('post.tea_no'));
            M('teacher') -> where($tea) -> add($tea);
            $msg = M('teacher') -> where(array('user' => I('post.tea_no'))) -> find();
            $map['uid'] = $msg['id'];
            M('auth_group_access') -> where(array('uid' => $msg['id'])) -> add($map);  
            $this -> success();
        } else {
            $this -> error('没有权限,如需操作请联系管理员！');
        }  
    }
    //教师信息修改
    public function teaEdit() {
        if (session("nameid") == C('USER_ADMINISTRATOR')) {
            $map['nikename'] = I('post.tea_name');
            $map['user'] = I('post.tea_no');
            $map['pwd'] = md5(I('post.password'));
            M('teacher') -> where(array('id' => I('post.editid'))) -> save($map);
            $this -> success();
        } else {
            $this -> error('没有权限,如需操作请联系管理员！');
        }
    }
    //教师查看班级详情
    public function classDetail() {
        // if (session("nameid") == C('USER_ADMINISTRATOR')) {
            //所有班级
            $listALL = M('class') -> select();
            $id = I('get.id');
            $result = M('teacher') -> where('id='.$id) -> find();   
            $classid = explode(",",$result['class_id']);
            //dump($result['class_id']);
            $this->assign('id',$id);
            $this->assign('classid',$classid);
            $this -> assign('list',$listALL);
            $this -> display();
      /*  } else {
            $res=M("teacher")->find(session("nameid"));
            $listALL = M('class') -> where(array('id' => array('in',$res['class_id']))) -> select();
            $id = I('get.id');
            $result = M('teacher') -> where('id='.$id) -> find();   
            $classid = explode(",",$result['class_id']);
            //dump($result['class_id']);
            $this->assign('id',$id);
            $this->assign('classid',$classid);
            $this -> assign('list',$listALL);
            $this -> display();
        } */
    }
    //教师勾选添加班级
    public function addClass() {
        $ids = I('post.id');
        $teacid = I('post.teacid');
        $ids=implode(",",$ids);
        $data['class_id'] = $ids;
        M('teacher') -> where('id='.$teacid) -> save($data);
        $this->success('选择班级成功','stuMsg');
    }
    //修改班级名称
    public function edit() {
        if ($_POST) {
            $map['name'] = I('post.cls_name');
            M('class') -> where(array('id' => I('post.cls_id'))) -> save($map);
            $list = M('class') -> where(array('id' => I('post.cls_id'))) -> find();
            $msg['class_name'] = $list['name'];
            M('stu') -> where(array('class_id' => $list['id'])) -> save($msg);
            M('state') -> where(array('cls_id' => $list['id'])) -> save($msg);
            $this -> success();
        }
    }
    //删除班级信息
    public function classDel() {
        $msg = M('class') -> where(array('id' => I('get.id'))) -> find();
        M('stu') -> where(array('class_name' => $msg['name'])) -> delete();
        M('class') -> where(array('id' => I('get.id'))) -> delete();
        M('state') -> where(array('class_name' => $msg['name'])) -> delete();
        $this -> success('删除班级成功！',U('Manage/banji'),2);
    }
    //删除教师信息
    public function teaDel() {
        if (session("nameid") == C('USER_ADMINISTRATOR')) {
            $teaToAccess = M('teacher') -> where(array('id' => I('get.id'))) -> find();
            M('auth_group_access') -> where(array('uid' => $teaToAccess['id'])) -> delete(); 
            M('teacher') -> where(array('id' => I('get.id'))) -> delete();
            $this -> success('删除成功',U('Manage/teaDetail'),2);
        } else {
            $this -> error('没有权限,如需操作请联系管理员！');
        }
    }
    //显示所有班级
    public function banji() {
        //管理员显示
        if (session("nameid") == C('USER_ADMINISTRATOR')) {
            $list = M('class') -> select($res['class_id']);
            $this -> assign('list',$list);
            $this -> display();
        } else {
            //普通教师显示
            $res=M("teacher")->find(session("nameid"));
            $list = M('class') -> where(array('id' => array('in',$res['class_id']))) -> select();
            $this -> assign('list',$list);
            $this -> display();
        }
    }
    //填写表单添加班级
    public function handAdd() {
        $name['name'] = I('post.className');
        M('class') -> add($name);
        $this -> success('添加班级成功！');
    }
    //学生信息列表
	public function stuMsg() {
        if (session("nameid") == C('USER_ADMINISTRATOR')) {
            $pagecount = 30;//每页100条数据
            $count = M('Stu') -> count();//数据总条数
            $page = new \Think\Page($count,$pagecount);
            $page->setConfig('header','<span class="rows">'.$pagecount.' 条/页 共 %TOTAL_ROW% 条</span>');
            $page->setConfig('theme','%UP_PAGE% %FIRST% %LINK_PAGE% %END% %DOWN_PAGE% %HEADER% ');
            $show = $page -> show();
            $result = M('Stu') -> order('mp3') -> limit($page->firstRow.','.$page->listRows)-> select();
            $this -> assign('result',$result);
            $this -> assign('page', $show);
            $this -> display();
        } else {
            $res=M("teacher")->find(session("nameid"));
            if ($res['class_id']) {
                $t_class = M('class') -> select($res['class_id']);
                foreach ($t_class as $value) {
                    $clsname[] = $value['name'];
                }
                if (empty($clsname)) {
                    $this -> display();
                    die();
                }
                $pagecount = 50;//每页100条数据
                $count = M('Stu') -> where(array('class_name' => array('in',$clsname))) -> count();//数据总条数
                $page = new \Think\Page($count,$pagecount);
                $page->setConfig('header','<span class="rows">'.$pagecount.' 条/页 共 %TOTAL_ROW% 条</span>');

                $page->setConfig('theme','%UP_PAGE% %FIRST% %LINK_PAGE% %END% %DOWN_PAGE% %HEADER% ');
                $show = $page -> show();
                $result = M('Stu') -> where(array('class_name' => array('in', $clsname))) -> order('mp3') -> limit($page->firstRow.','.$page->listRows)-> select();
                $this -> assign('result',$result);
                $this -> assign('page', $show);
                $this -> display();
            }
        }
    }
  	//批量删除
    public function delAll() {
        $del = M('stu');
        $ids = I('post.idno'); //复选框选中的id
        M('state') -> where(array('sid' => array('in',$ids))) -> delete();
        $result = $del -> where(array('id' => array('in', $ids))) -> delete();
        if ($result) {
          $this -> success('删除成功',U('Manage/stuMsg'),2);
          exit();
        } else {
          $this -> error('请重新尝试！','javascript:history.back(-1);');
        }
    }
    //批量生成音频
    public function mp3All() {
        set_time_limit(0);
        $cuid = "msm";
        $curlobj = curl_init();
        curl_setopt($curlobj, CURLOPT_URL, "http://openapi.baidu.com/oauth/2.0/token");
        curl_setopt($curlobj, CURLOPT_RETURNTRANSFER, true);
        $data=array(
            'grant_type' => 'client_credentials', 
            'client_id' => 'PTBi5T54TRYfN3no03BEiGGz',
            'client_secret'=>'07d3c163eddff4b6fba7828b1d9c5d68'
        );
        curl_setopt($curlobj, CURLOPT_POST, 1);
        curl_setopt($curlobj, CURLOPT_POSTFIELDS, $data); 
        $response=curl_exec($curlobj);
        if(curl_errno($curlobj)) {
            print curl_error($curlobj);
        }
        curl_close($curlobj);
        $response = json_decode($response, true);
        $token = $response['access_token'];
        $ids = I('post.idno'); //复选框选中id
        if (empty($ids)) {
            $result = M('stu') -> select();
        } else {
            $result = M('stu') -> where(array('id' => array('in', $ids))) -> select();//批量生成音频
        }
        
        foreach ($result as $k => $v) {
            //判断本地是否存在同名文件夹，不存在创建
            if(!is_dir(C('AUDIO_PATH').mb_substr($v['no'],0,4).'/')){
                mkdir(C('AUDIO_PATH').mb_substr($v['no'],0,4).'/');
            }
            $msc=fopen(C('AUDIO_PATH').mb_substr($v['no'],0,4).'/'.$v['no'].'.mp3','w');
            $mp['mp3'] = 1; //音频状态
            //拼一个MP3路径
            $mp['mp3_path'] = '/Public/mp3/'.mb_substr($v['no'],0,4).'/'.$v['no'].'.mp3';
            M('stu') -> where(array('id' => $v['id'])) -> save($mp);
            $obj=curl_init();
            curl_setopt($obj, CURLOPT_URL, "http://tsn.baidu.com/text2audio?tex=".$v['name']."&lan=zh&ctp=1&cuid=".$cuid."&tok=".$token);     
            curl_setopt($obj, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($obj, CURLOPT_FILE,$msc);
            $result=curl_exec($obj);
            if(curl_errno($obj)) {
              print curl_error($obj);
            }             
            curl_close($obj);
            fclose($msc);  
        }
        $this -> success('音频生成成功！');
    }

    //单个生成音频
    public function one_mp3() {
        $cuid = "msm";
        $curlobj = curl_init();
        curl_setopt($curlobj, CURLOPT_URL, "http://openapi.baidu.com/oauth/2.0/token");
        curl_setopt($curlobj, CURLOPT_RETURNTRANSFER, true);
        $data=array(
            'grant_type' => 'client_credentials', 
            'client_id' => 'PTBi5T54TRYfN3no03BEiGGz',
            'client_secret'=>'07d3c163eddff4b6fba7828b1d9c5d68'
        );
        curl_setopt($curlobj, CURLOPT_POST, 1);
        curl_setopt($curlobj, CURLOPT_POSTFIELDS, $data); 
        $response=curl_exec($curlobj);
        if (curl_errno($curlobj)) {
            print curl_error($curlobj);
        }
        curl_close($curlobj);
        $response = json_decode($response, true);
        $token = $response['access_token'];
        $id = I('get.id');
        $v = M('stu') -> where(array('id' => $id)) -> find();
        if(!is_dir(C('AUDIO_PATH').mb_substr($v['no'],0,4).'/')){
            mkdir(C('AUDIO_PATH').mb_substr($v['no'],0,4).'/');
        }
        $msc=fopen(C('AUDIO_PATH').mb_substr($v['no'],0,4).'/'.$v['no'].'.mp3','w');
        $mp['mp3'] = 1; //音频状态    
        //拼一个MP3路径
        $mp['mp3_path'] = '/Public/mp3/'.mb_substr($v['no'],0,4).'/'.$v['no'].'.mp3';
        M('stu') -> where(array('id' => $v['id'])) -> save($mp);
        $obj=curl_init();
        curl_setopt($obj, CURLOPT_URL, "http://tsn.baidu.com/text2audio?tex=".$v['name']."&lan=zh&ctp=1&cuid=".$cuid."&tok=".$token);     
        curl_setopt($obj, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($obj, CURLOPT_FILE,$msc);
        $result=curl_exec($obj);
        if(curl_errno($obj)) {
            print curl_error($obj);
        }             
        curl_close($obj); 
        fclose($msc);  
        $data = '音频生成成功';
        $this -> ajaxReturn($data);
    }
    //搜索
    public function search() {
        if (session("nameid") == C('USER_ADMINISTRATOR')) {
            $map['no|name'] = I('post.searchWord');
            $result = M('stu') -> where($map) -> select();
            if ($result) {
                $this -> assign('result',$result);
                $this -> display('stumsg');
            } else {
                $this -> error('没有该学生信息！');
            }
        } else {
            $res=M("teacher")->find(session("nameid"));
            $map['no|name'] = I('post.searchWord');
            $result = M('stu') -> where(array('tea_no' => $res['user'])) -> where($map) -> select();
            if ($result) {
                $this -> assign('result',$result);
                $this -> display('stumsg');
            } else {
                $this -> error('没有该学生信息！');
            }
        }   

        // if($_POST) {
        //     $result = M('Stu') -> where(array('no' => I('post.searchWord'))) -> select();
        //     if($result) {
        //         $this -> assign('result',$result);
        //         $this -> display('stumsg');           
        //     } else {
        //         $this -> error('没有该学生信息！');
        //     }
        // } else {
        //     $this -> display();
        // }
    	
    }
    //学生信息修改
    public function stuEdit() {
        $msg['no'] = I('post.stu_no');
        $msg['name'] = I('post.stu_name');
        $msg['class_name'] = I('post.stu_class');
        $list = M('stu') -> where('id<>' .I('post.hidden_id')) -> select();
        foreach ($list as $value) {
            if ($value['no'] == I('post.stu_no')) {
                $this -> error('该学号'.$value['no'].'已存在，请仔细核对后修改',U('Manage/stuMsg'));
            }
        }
        M('stu') -> where(array('id' => I('post.hidden_id'))) -> save($msg);
        //把修改后学生生成新的音频文件
        $cuid = "msm";
        $curlobj = curl_init();
        curl_setopt($curlobj, CURLOPT_URL, "http://openapi.baidu.com/oauth/2.0/token");
        curl_setopt($curlobj, CURLOPT_RETURNTRANSFER, true);
        $data=array(
            'grant_type' => 'client_credentials', 
            'client_id' => 'PTBi5T54TRYfN3no03BEiGGz',
            'client_secret'=>'07d3c163eddff4b6fba7828b1d9c5d68'
        );
        curl_setopt($curlobj, CURLOPT_POST, 1);
        curl_setopt($curlobj, CURLOPT_POSTFIELDS, $data); 
        $response=curl_exec($curlobj);
        if (curl_errno($curlobj)) {
            print curl_error($curlobj);
        }
        curl_close($curlobj);
        $response = json_decode($response, true);
        $token = $response['access_token'];
        $id = I('post.hidden_id');
        $v = M('stu') -> where(array('id' => $id)) -> find();
        if(!is_dir(C('AUDIO_PATH').mb_substr($v['no'],0,4).'/')){
            mkdir(C('AUDIO_PATH').mb_substr($v['no'],0,4).'/');
        }
        $msc=fopen(C('AUDIO_PATH').mb_substr($v['no'],0,4).'/'.$v['no'].'.mp3','w');
        $mp['mp3'] = 1; //音频状态    
        //拼一个MP3路径
        $mp['mp3_path'] = '/Public/mp3/'.mb_substr($v['no'],0,4).'/'.$v['no'].'.mp3';
        M('stu') -> where(array('id' => $v['id'])) -> save($mp);
        $obj=curl_init();
        curl_setopt($obj, CURLOPT_URL, "http://tsn.baidu.com/text2audio?tex=".$v['name']."&lan=zh&ctp=1&cuid=".$cuid."&tok=".$token);     
        curl_setopt($obj, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($obj, CURLOPT_FILE,$msc);
        $result=curl_exec($obj);
        if(curl_errno($obj)) {
            print curl_error($obj);
        }             
        curl_close($obj); 
        fclose($msc);  
       //修改stu表之后，修改state表
        $map['stu_id'] = I('post.stu_no');
        $map['stu_name'] = I('post.stu_name');
        $map['class_name'] = I('post.stu_class');
        M('state') -> where(array('sid' => I('post.hidden_id'))) -> save($map);
        $this -> success('修改信息成功',U('Manage/stuMsg'));
    }
}