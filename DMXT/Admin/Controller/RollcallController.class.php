<?php
namespace Admin\Controller;
class RollcallController extends AdminController{
    //更改状态页
    public function stateEdit() {
        if (session('nameid') == C('USER_ADMINISTRATOR')) {
              $stateList = M('state') -> where(array('sid' => I('get.sid'))) -> select();
              $this -> assign('stateList',$stateList);
              $this -> display();
        } else {
            $res = M('teacher') -> find(session("nameid"));
            $stateList = M('state') -> where(array('tea_no' => $res['user'],'sid' => I('get.sid'))) -> select();
            $this -> assign('stateList',$stateList);
            $this -> display();
        }
    }
    //更改学生状态
    public function edit() {
      $state = I('get.stu_state');
      if ($state == 1 || $state == 2 || $state == 3) {
        $map['state'] = $state;
        M('state') -> where(array('id' => I('get.hiddenId'))) -> save($map);
        $data = '更改状态成功！';
        $this -> ajaxReturn($data);
      } else {
        $this -> error();
      }
    }
    //学生全部上课记录状态
  /*  public function stateAll() {
      if (session('nameid') == C('USER_ADMINISTRATOR')) {
            $pagecount = 45;//每页100条数据
            $count = M('State') -> count();//数据总条数
            $page = new \Think\Page($count,$pagecount);
            $page->setConfig('header','<span class="rows">'.$pagecount.' 条/页 共 %TOTAL_ROW% 条</span>');
            $page->setConfig('theme','%UP_PAGE% %FIRST% %LINK_PAGE% %END% %DOWN_PAGE% %HEADER% ');
            $show = $page -> show();
            $stuStaDeatil = M('State') -> order('create_time desc') -> limit($page->firstRow.','.$page->listRows)-> select();
            // $this -> arrSelect();
            $this -> assign('page', $show);
            $this -> assign('stuStaDeatil',$stuStaDeatil);
            $this -> display('stustatedeatil');
        } else {
            // $this -> teaSelect();
            $tea_list = M('teacher') -> select(session("nameid"));
            foreach ($tea_list as $value) {
                $cls_name[] = $value['class_id'];
            }
            $clsName = implode(",",$cls_name);//数组转字符串
            $cls_list = M('class') -> where(array('id' => array('in',$clsName))) -> select();
            $stuStaDeatil = M('state') -> where(array('tea_no' => $value['user'])) -> select();
            $timeSel=M('state')->distinct(true)->field("FROM_UNIXTIME(create_time,'%Y-%m-%d') as a_date")->select();
            $pagecount = 45;//每页100条数据
            $count = M('State') -> where(array('tea_no' => $value['user'])) -> count();//数据总条数
            $page = new \Think\Page($count,$pagecount);
            $page->setConfig('header','<span class="rows">'.$pagecount.' 条/页 共 %TOTAL_ROW% 条</span>');
            $page->setConfig('theme','%UP_PAGE% %FIRST% %LINK_PAGE% %END% %DOWN_PAGE% %HEADER% ');
            $show = $page -> show();
            $stuStaDeatil = M('state') -> where(array('tea_no' => $value['user'])) -> order('create_time desc') -> limit($page->firstRow.','.$page->listRows)-> select();
            $this -> assign('page', $show);
            $this -> assign('timeSel',$timeSel);
            $this -> assign('tea_list',$tea_list);
            $this -> assign('cls_list',$cls_list);
            $this -> assign('stuStaDeatil',$stuStaDeatil);
            $this -> display('stustatedeatil'); 
        }
    }*/
    //筛选上课记录状态
    public function findState() {
        /*
        管理员 筛选
         */
        if (session('nameid') == C('USER_ADMINISTRATOR')) {
            if (!empty(I('get.teacher'))){
                $map['tea_no'] = I('get.teacher');
            }
            if (!empty(I('get.cls'))){
                $map['cls_id'] = I('get.cls');
            }
            if (!empty(I('get.stu_state'))){
                $map['state'] = I('get.stu_state');
            }
            if ((empty(I('get.beginDate'))) && (empty(I('get.overDate')))){              
                $pagecount = 45;//每页100条数据
                $count = count(M('state') -> where($map) -> select());//数据总条数
                $page = new \Think\Page($count,$pagecount);
                $page->setConfig('header','<span class="rows">'.$pagecount.' 条/页 共 %TOTAL_ROW% 条</span>');
                $page->setConfig('theme','%UP_PAGE% %FIRST% %LINK_PAGE% %END% %DOWN_PAGE% %HEADER% ');
                $show = $page -> show();
                $state_list = M('State') -> order('create_time desc') -> where($map) -> limit($page->firstRow.','.$page->listRows)-> select();
                
                if (!empty($state_list)) {
                    $this -> assign('page', $show);
                    $this -> assign('stuStaDeatil',$state_list);
                    $this -> display('stuStateDeatil');
                } else {
                    $this -> error('未查询到点名状态');
                    exit();
                }  
            } else {
                $begin_date = I('get.beginDate');
                $over_date = I('get.overDate');
                $pagecount = 45;//每页100条数据
                $count = count(M('state') -> where($map)->where("FROM_UNIXTIME(create_time,'%Y-%m-%d') >= DATE_FORMAT('".$begin_date."','%Y-%m-%d') and FROM_UNIXTIME(create_time,'%Y-%m-%d') <= DATE_FORMAT('".$over_date."','%Y-%m-%d')") -> select());//数据总条数
                $page = new \Think\Page($count,$pagecount);
                $page->setConfig('header','<span class="rows">'.$pagecount.' 条/页 共 %TOTAL_ROW% 条</span>');
                $page->setConfig('theme','%UP_PAGE% %FIRST% %LINK_PAGE% %END% %DOWN_PAGE% %HEADER% ');
                $show = $page -> show();
                
                $state_list = M('state') -> order('create_time desc') -> where($map)->where("FROM_UNIXTIME(create_time,'%Y-%m-%d') >= DATE_FORMAT('".$begin_date."','%Y-%m-%d') and FROM_UNIXTIME(create_time,'%Y-%m-%d') <= DATE_FORMAT('".$over_date."','%Y-%m-%d')") -> limit($page->firstRow.','.$page->listRows)-> select();
                if (!empty($state_list)) {
                    $this -> assign('page',$show);
                    $this -> assign('stuStaDeatil',$state_list);
                    $this -> display('stuStateDeatil');
                } else {
                    $this -> error('未查询到点名状态');
                    exit();
                } 
            }
        } else {
            /*
            普通教师筛选
             */
            if (!empty(I('get.teacher'))){
              $map['tea_no'] = I('get.teacher');
            }
            if (!empty(I('get.cls'))){
              $map['cls_id'] = I('get.cls');
            }
            if (!empty(I('get.stu_state'))) {
              $map['state'] = I('get.stu_state');
            }
            //判断日期是否为空
            if ((empty(I('get.beginDate'))) && (empty(I('get.overDate')))){
                $pagecount = 45;
                $count = count(M('state') -> where($map) -> where(array('tea_no' => session('user'))) -> select());//数据总条数
                $page = new \Think\Page($count,$pagecount);
                $page->setConfig('header','<span class="rows">'.$pagecount.' 条/页 共 %TOTAL_ROW% 条</span>');
                $page->setConfig('theme','%UP_PAGE% %FIRST% %LINK_PAGE% %END% %DOWN_PAGE% %HEADER% ');
                $show = $page -> show();
                $state_list = M('State') -> order('create_time desc') -> where($map) -> where(array('tea_no' => session('user'))) -> limit($page->firstRow.','.$page->listRows)-> select();     

                if (empty($state_list)) {
                    $this -> error('未查询到点名状态');
                    exit();
                } else {
                    $this -> assign('page',$show);
                    $this -> assign('stuStaDeatil',$state_list);
                    $this -> display('stuStateDeatil');
                }   
            } else {
                $begin_date = I('get.beginDate');
                $over_date = I('get.overDate');
                $tea = array('tea_no' => session('user'));
                $pagecount = 45;//每页100条数据
                $count = count(M('state') -> where($map)-> where($tea) -> where("FROM_UNIXTIME(create_time,'%Y-%m-%d') >= DATE_FORMAT('".$begin_date."','%Y-%m-%d') and FROM_UNIXTIME(create_time,'%Y-%m-%d') <= DATE_FORMAT('".$over_date."','%Y-%m-%d')") -> select());//数据总条数

                $page = new \Think\Page($count,$pagecount);
                $page->setConfig('header','<span class="rows">'.$pagecount.' 条/页 共 %TOTAL_ROW% 条</span>');
                $page->setConfig('theme','%UP_PAGE% %FIRST% %LINK_PAGE% %END% %DOWN_PAGE% %HEADER% ');
                $show = $page -> show();

                $state_list = M('state') -> order('create_time desc') -> where($map) -> where($tea) ->where("FROM_UNIXTIME(create_time,'%Y-%m-%d') >= DATE_FORMAT('".$begin_date."','%Y-%m-%d') and FROM_UNIXTIME(create_time,'%Y-%m-%d') <= DATE_FORMAT('".$over_date."','%Y-%m-%d')") -> limit($page->firstRow.','.$page->listRows)-> select();

                if (empty($state_list)) {
                    $this -> error('未查询到点名状态');
                    exit();
                } else {
                    $this -> assign('page',$show);
                    $this -> assign('stuStaDeatil',$state_list);
                    $this -> display('stuStateDeatil');
                }   
            }
        }
    }
    //每个学生的上课状态
    public function oneStaDeatil() {
        if (session('nameid') == C('USER_ADMINISTRATOR')) {
            $StaDeatil = M('state') -> where(array('sid' => I('get.sid'))) -> select();
            if (empty($StaDeatil)) {
                $this -> error('该生无上课记录');
                exit();
            }
            $this -> assign('StaDeatil',$StaDeatil);
            $this -> display();
        } else {
            $StaDeatil = M('state') -> where(array('sid' => I('get.sid'),'tea_no' => session('user'))) -> select();
            if (empty($StaDeatil)) {
                $this -> error('该生无上课记录');
                exit();
            }
            $this -> assign('StaDeatil',$StaDeatil);
            $this -> display();
        }
    }
    //单个学生状态筛选
    public function onefind() {
    	if (session('nameid') == C('USER_ADMINISTRATOR')) {
	        switch (I('get.state')) {
	            case '1':
	                $StaDeatil = M('state') -> where(array('sid' => I('get.sid'),'state' => 1,)) -> select();
	                if (empty($StaDeatil)) {
	                    $this -> error('请提醒该生按时上课！','javascript:history.back(-1);');
	                }
	                $this -> assign('StaDeatil',$StaDeatil);
	                $this -> display('onestadeatil');
	                break;
	            case '2':
	                $StaDeatil = M('state') -> where(array('state' => 2,'sid' => I('get.sid'))) -> select();
	                if (empty($StaDeatil)) {
	                    $this -> success('该生记录良好，无请假记录!','javascript:history.back(-1);');     
	                }
	                $this -> assign('StaDeatil',$StaDeatil);
	                $this -> display('onestadeatil');
	                break;
	            case '3':
	                $StaDeatil = M('state') -> where(array('state' => 3,'sid' => I('get.sid'))) -> select();
	                if (empty($StaDeatil)) {
	                    $this -> success('该生记录优秀，没有旷课记录!','javascript:history.back(-1);');   
	                }
	                $this -> assign('StaDeatil',$StaDeatil);
	                $this -> display('onestadeatil');
	                break;
	            default:
	                $this -> error('请选择状态进行筛选！');
	                break;
	        }
	    } else {
	        switch (I('get.state')) {
	            case '1':
	                $StaDeatil = M('state') -> where(array('sid' => I('get.sid'),'state' => 1,'tea_no' => session('user'))) -> select();
	                if (empty($StaDeatil)) {
	                    $this -> error('请提醒该生按时上课！','javascript:history.back(-1);');
	                }
	                $this -> assign('StaDeatil',$StaDeatil);
	                $this -> display('onestadeatil');
	                break;
	            case '2':
	                $StaDeatil = M('state') -> where(array('state' => 2,'sid' => I('get.sid'),'tea_no' => session('user'))) -> select();
	                if (empty($StaDeatil)) {
	                    $this -> success('该生记录良好，无请假记录!','javascript:history.back(-1);');     
	                }
	                $this -> assign('StaDeatil',$StaDeatil);
	                $this -> display('onestadeatil');
	                break;
	            case '3':
	                $StaDeatil = M('state') -> where(array('state' => 3,'sid' => I('get.sid'),'tea_no' => session('user'))) -> select();
	                if (empty($StaDeatil)) {
	                    $this -> success('该生记录优秀，没有旷课记录!','javascript:history.back(-1);');   
	                }
	                $this -> assign('StaDeatil',$StaDeatil);
	                $this -> display('onestadeatil');
	                break;
	            default:
	                $this -> error('请选择状态进行筛选！');
	                break;
	        }
	    }       
    }
    //显示学生名单
    public function studentList() {
      if (session("nameid") == C('USER_ADMINISTRATOR')) {
            $pagecount = 15;
            $count = count(M('state')->group('stu_id') -> select());//数据总条数
            $page = new \Think\Page($count,$pagecount);
            $page->setConfig('header','<span class="rows">'.$pagecount.' 条/页 共 %TOTAL_ROW% 条</span>');
            $page->setConfig('theme','%UP_PAGE% %FIRST% %LINK_PAGE% %END% %DOWN_PAGE% %HEADER% ');
            $show = $page -> show();
            $result = M('state')->group('sid') -> limit($page->firstRow.','.$page->listRows) -> select();
            $this -> arrSelect();
            $this -> assign('result',$result);
            $this -> assign('page', $show);
            $this -> display();
        } else {
            /*
            通过比对stu表与state表查询条数
             */
            $res=M("teacher")->find(session("nameid"));
            $no_list = M('stu') -> where(array('class_id' => array('in',$res['class_id']))) -> field('no') -> select();
            foreach ($no_list as $value) {
               $stu_id[] = $value['no'];
            }      
            if ($res['user']) {
                $pagecount = 15;
                $count = count(M('state') -> group('sid') -> where(array('stu_id' => array('in',$stu_id),'tea_no' => $res['user'])) -> select());//数据总条数
                $page = new \Think\Page($count,$pagecount);
                $page->setConfig('header','<span class="rows">'.$pagecount.' 条/页 共 %TOTAL_ROW% 条</span>');
                $page->setConfig('theme','%UP_PAGE% %FIRST% %LINK_PAGE% %END% %DOWN_PAGE% %HEADER% ');
                $show = $page -> show();
                $result = M('state')->group('sid') -> where(array('tea_no' => $res['user'])) -> limit($page->firstRow.','.$page->listRows) -> select();
                $this -> teaSelect();
                $this -> assign('result',$result);
                $this -> assign('page', $show);
                $this -> display();
            }
        }
    } 
    //点名分析
    public function analyse() {
      if (session('nameid') == C('USER_ADMINISTRATOR')) {
        $arrive = M('state') -> field('state')->where('state=1') ->count(); //已到
        $vocation = M('state') -> field('state')->where('state=2') ->count(); //请假
        $absent = M('state') -> field('state')->where('state=3') ->count(); //旷课
        $this -> arrSelect();
        $this->assign('arrive',$arrive);
        $this->assign('vocation',$vocation);
        $this->assign('absent',$absent);
        $this -> display();
      } else {
        $this -> teaSelect();
        $no = M('teacher') -> find(session("nameid"));
        $map = array('tea_no' => $no['user']);
        $arrive = M('state') -> field('state')->where('state=1') ->where($map) ->count(); //已到
        $vocation = M('state') -> field('state')->where('state=2') ->where($map) ->count(); //请假
        $absent = M('state') -> field('state')->where('state=3')->where($map) ->count(); //旷课
        $this->assign('arrive',$arrive);
        $this->assign('vocation',$vocation);
        $this->assign('absent',$absent);
        $this -> display();
      }
    }
    //筛选点名状态
    public function renderView(){
        if (session('nameid') == C('USER_ADMINISTRATOR')) {
            $this -> arrSelect();
            if (!empty(I('get.teacher'))){
                $map['tea_no'] = I('get.teacher');
            }
            if (!empty(I('get.cls'))){
                $map['cls_id'] = I('get.cls');
            }
            if (!empty(I('get.stu'))){
                $map['sid'] = I('get.stu');
            }
            //where语句连贯操作，字符串条件只能出现一次
            if ((!empty(I('get.beginDate'))) && (!empty(I('get.overDate')))) {         
              $begin_date = I('get.beginDate');
              $over_date = I('get.overDate');
              $arr[] = M('state') -> where($map) -> where("FROM_UNIXTIME(create_time,'%Y-%m-%d') >= DATE_FORMAT('".$begin_date."','%Y-%m-%d') and FROM_UNIXTIME(create_time,'%Y-%m-%d') <= DATE_FORMAT('".$over_date."','%Y-%m-%d') and state=1") -> count(); //已到
              $arr[] = M('state') -> where($map) -> where("FROM_UNIXTIME(create_time,'%Y-%m-%d') >= DATE_FORMAT('".$begin_date."','%Y-%m-%d') and FROM_UNIXTIME(create_time,'%Y-%m-%d') <= DATE_FORMAT('".$over_date."','%Y-%m-%d') and state=2") -> count(); //请假
              $arr[] = M('state') -> where($map) -> where("FROM_UNIXTIME(create_time,'%Y-%m-%d') >= DATE_FORMAT('".$begin_date."','%Y-%m-%d') and FROM_UNIXTIME(create_time,'%Y-%m-%d') <= DATE_FORMAT('".$over_date."','%Y-%m-%d') and state=3")-> count(); //旷课           
              $this -> ajaxReturn($arr);
            } else {
              $arr[] = M('state') -> where($map) -> where('state=1') -> count(); //已到
              $arr[] = M('state') -> where($map) -> where('state=2') -> count(); //请假
              $arr[] = M('state') -> where($map) -> where('state=3') -> count(); //旷课
              $this -> ajaxReturn($arr);
            }
        } else {
          $this -> teaSelect();
          $no = M('teacher') -> find(session("nameid"));
          $msg = array('tea_no' => $no['user']);
          //$msg['tea_no'] = $no['user'];
          if (!empty(I('get.teacher'))) {
            $map['tea_no'] = I('get.teacher');
          }
          if (!empty(I('get.cls'))) {
            $map['cls_id'] = I('get.cls');
          }
          if (!empty(I('get.stu'))){
            $map['sid'] = I('get.stu');
          }
          //where语句连贯操作，字符串条件只能出现一次
          if ((!empty(I('get.beginDate'))) && (!empty(I('get.overDate')))) {         
            $begin_date = I('get.beginDate');
            $over_date = I('get.overDate');
            $arr[] = M('state') -> where($map) -> where("FROM_UNIXTIME(create_time,'%Y-%m-%d') >= DATE_FORMAT('".$begin_date."','%Y-%m-%d') and FROM_UNIXTIME(create_time,'%Y-%m-%d') <= DATE_FORMAT('".$over_date."','%Y-%m-%d') and state=1") -> where($msg) -> count(); //已到
            $arr[] = M('state') -> where($map) -> where("FROM_UNIXTIME(create_time,'%Y-%m-%d') >= DATE_FORMAT('".$begin_date."','%Y-%m-%d') and FROM_UNIXTIME(create_time,'%Y-%m-%d') <= DATE_FORMAT('".$over_date."','%Y-%m-%d') and state=2") -> where($msg) -> count(); //请假
            $arr[] = M('state') -> where($map) -> where("FROM_UNIXTIME(create_time,'%Y-%m-%d') >= DATE_FORMAT('".$begin_date."','%Y-%m-%d') and FROM_UNIXTIME(create_time,'%Y-%m-%d') <= DATE_FORMAT('".$over_date."','%Y-%m-%d') and state=3")-> where($msg) -> count(); //旷课
            $this -> ajaxReturn($arr);
          } else {
            $arr[] = M('state') -> where($map) -> where('state=1') -> where($msg) -> count(); //已到
            $arr[] = M('state') -> where($map) -> where('state=2') -> where($msg) -> count(); //请假
            $arr[] = M('state') -> where($map) -> where('state=3') -> where($msg) -> count(); //旷课
            $this -> ajaxReturn($arr);
          }
        }
    }
    //管理员显示教师班级日期
    protected function arrSelect(){
        $cls_list = M('class') -> select();
        $timeSel=M('state')->distinct(true)->field("FROM_UNIXTIME(create_time,'%Y-%m-%d') as a_date")->select();
        $tea_list = M('teacher') -> where("id !=".session('nameid') ) -> select();
        $stu_list = M('stu') -> select();
        $this -> assign('timeSel',$timeSel);
        $this -> assign('cls_list',$cls_list);
        $this -> assign('stu_list',$stu_list);
        $this -> assign('tea_list',$tea_list);
    }
    //教师显示班级日期
    protected function teaSelect() {
        $tea_list = M('teacher') -> select(session("nameid"));
        foreach ($tea_list as $value) {
            $cls_name[] = $value['class_id'];
        }
        $clsName = implode(",",$cls_name);//数组转字符串
        $cls_list = M('class') -> where(array('id' => array('in',$clsName))) -> select();
        
        $stu_list = M('stu') -> where(array('class_id' => array('in',$clsName))) -> select();
        $this -> assign('tea_list',$tea_list);
        $this -> assign('stu_list',$stu_list);
        $this -> assign('cls_list',$cls_list);
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
    //点名
    public function rollCall() {
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
  	// //教师信息添加
  	// public function teacherAdd() {
  	// 	$teac=M('teacher');
  	// 	$teac->nikename=I('post.teacherName');
  	// 	$teac->user=I('post.teacherNo');
  	// 	$teac-> add();
  	// 	$this -> success();
  	// }
  	// //删除教师信息
  	// public function teaDel() {
  	// 	$tea = M('teacher');
  	// 	$tea -> where(array('id' => I('get.id'))) -> delete();
  	// 	$this -> success();
  	// }
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
      $this -> success('学生点名信息云保存成功，请开始上课！','/Rollcall/analyse',3);
      //$this->redirect('Rollcall/analyse',3,'学生点名信息云保存成功，请开始上课！');
    }
  }
  //查询学生上课状态
  public function searchState() {
    if (session("nameid") == C('USER_ADMINISTRATOR')) {
            $pagecount = 15;//每页100条数据
            $count = M('State') -> count();//数据总条数
            $page = new \Think\Page($count,$pagecount);
            $page->setConfig('header','<span class="rows">'.$pagecount.' 条/页 共 %TOTAL_ROW% 条</span>');
            $page->setConfig('theme','%UP_PAGE% %FIRST% %LINK_PAGE% %END% %DOWN_PAGE% %HEADER% ');
            $show = $page -> show();
            $stateList = M('State') -> order('create_time desc') -> limit($page->firstRow.','.$page->listRows)-> select();
            $this -> assign('stateList',$stateList);
            $this -> assign('page', $show);
            $this -> display();
        } else {
            $res=M("teacher")->find(session("nameid"));
            if ($res['user']) {
              $pagecount = 15;
              $count = M('state') -> where(array('tea_no' => $res['user'])) -> count();
              $page = new \Think\Page($count,$pagecount);
              $page->setConfig('header','<span class="rows">'.$pagecount.' 条/页 共 %TOTAL_ROW% 条</span>');

              $page->setConfig('theme','%UP_PAGE% %FIRST% %LINK_PAGE% %END% %DOWN_PAGE% %HEADER% ');
              $show = $page -> show();
              $stateList = M('state') -> where(array('tea_no' => $res['user'])) -> order('create_time desc') -> limit($page->firstRow.','.$page->listRows)-> select();  
              $this -> assign('stateList',$stateList);
              $this -> assign('page', $show);
              $this -> display();
            }
        }
      }
  //批量删除学生点名状态信息
    public function delAll() {
        $del = M('state');
        $ids = I('post.idno');
        $result = $del -> where(array('sid' => array('in', $ids))) -> delete();
        if ($result) {
          $this -> success('删除成功');
        } else {
          $this -> error($del -> getError());
        }
    }
    //搜索
    public function search() {
        if (session("nameid") == C('USER_ADMINISTRATOR')) {
            $map['stu_id|stu_name'] = I('post.searchWord');
            $stuStaDeatil = M('state') -> where($map) -> select();
            if ($stuStaDeatil) {
                $this -> assign('stuStaDeatil',$stuStaDeatil);
                $this -> display('stustatedeatil');
            } else {
                $this -> error('没有该学生信息！');
            }
        } else {
            $res=M("teacher")->find(session("nameid"));
            $map['stu_id|stu_name'] = I('post.searchWord');
            $stuStaDeatil = M('state') -> where(array('tea_no' => $res['user'])) -> where($map) -> select();
            if ($stuStaDeatil) {
                $this -> assign('stuStaDeatil',$stuStaDeatil);
                $this -> display('stustatedeatil');
            } else {
                $this -> error('没有该学生信息！');
            }
        }   
    }
}