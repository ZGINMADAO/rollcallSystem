<?php
namespace Admin\Controller;
use Think\Upload;
use Org\Util;
class BatchesController extends AdminController {
	public function index() {
		$this -> display();
	}
	public function upload() {
    	if (!empty($_FILES)) {
           	$config = array(
                'exts' => array('xlsx','xls'),
                'maxSize' => 3145728,
                'rootPath' =>"./Public/",
                'savePath' => 'Uploads/',
                'subName' => array('date','Ymd'),
            );
            $upload = new \Think\Upload($config);   
            if (!$info = $upload->upload()) {
            	$this->error($upload->getError());
            } else{
                $excelName = $info['photo']['name'];
                 if(M('class')->getFieldByName(filteExcel($excelName))){
                    $this -> error('数据库已存在该班给信息');
                    exit();
                 }
            }        
            //引入PHPExcel
            vendor("PHPExcel.PHPExcel");
          	$file_name=$upload->rootPath.$info['photo']['savepath'].$info['photo']['savename'];
         	$extension = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));//判断导入表格后缀格式
            if ($extension == 'xlsx') {
                $objReader =\PHPExcel_IOFactory::createReader('Excel2007');
                $objPHPExcel =$objReader->load($file_name, $encode = 'utf-8');
            } else if ($extension == 'xls') {
                $objReader =\PHPExcel_IOFactory::createReader('Excel5');
                $objPHPExcel =$objReader->load($file_name, $encode = 'utf-8');
            }
            $sheet =$objPHPExcel->getSheet(0);
            $highestRow = $sheet->getHighestRow();//取得总行数
        	$highestColumn =$sheet->getHighestColumn(); //取得总列数
            $stu = D('Stu');
            $stu->startTrans(); //开启事务
            for ($i = 2; $i <= $highestRow; $i++) {
                $data['name'] = $objPHPExcel -> getActiveSheet() -> getCell("A".$i) -> getValue();
                $data['no'] = $objPHPExcel -> getActiveSheet() -> getCell("B".$i) -> getValue();
                $data['class_name'] = $objPHPExcel->getActiveSheet()->getCell("C".$i)->getValue();
                $data['input_time'] = date('Y-m-d H:i:s');
                $data1 = space($data);//把excel中的空格替换成空
                $list = $stu -> create($data1);
                if($list) {
                    $stu -> add();
                }else{
                    $this -> error(($stu->getError().'姓名：'.$data['name'].'学号'.$data['no']),U('Batches/index'),5);
                    die();         
                }
            }
            $stu->commit(); //事务提交
            /**
             * 此处可以写在导入的同时生成音频的代码
             */
            $map['name'] = filteExcel($excelName);
            M('class') -> add($map);//添加数据到class表
            $idList = M('class') -> where(array('name' => $data['class_name'])) -> find();
            $clsid['class_id'] = $idList['id'];
            M('stu') -> where(array('class_name' => $idList['name'])) -> save($clsid);
            $this -> redirect('Manage/stuMsg','上传信息成功');
        } else {
            $this->error("请选择上传的文件");
        }
    }
    //预览学生状态页
    public function export() {
        if (session('nameid') == C('USER_ADMINISTRATOR')) {
            $pagecount = 10;//每页100条数据
            $count = M('State') -> count();//数据总条数
            $page = new \Think\Page($count,$pagecount);
			$page->setConfig('header','<span class="rows">'.$pagecount.' 条/页 共 %TOTAL_ROW% 条</span>');
            $page->setConfig('theme','%UP_PAGE% %FIRST% %LINK_PAGE% %END% %DOWN_PAGE% %HEADER% ');
            $show = $page -> show();
            $state_list = M('State') -> order('id') -> limit($page->firstRow.','.$page->listRows)-> select();
            $state_all = M('state') -> select();//所有学生状态数据
            foreach($state_all as &$v){
                $v['create_time']=date("Y-m-d",$v['create_time']);//时间戳转日期格式
            }
            S('stateExcel',$state_all,300);
            $this -> arrSelect();
            $this -> assign('page', $show);
            $this -> assign('state_list',$state_list);
            $this -> display();
        } else {
            $state_list = M('state') -> where(array('tea_no' => session('user'))) -> select();
            $pagecount = 10;//每页100条数据
            $count = M('State') -> where(array('tea_no' => session('user'))) -> count();//数据总条数
            $page = new \Think\Page($count,$pagecount);
            $page->setConfig('header','<span class="rows">'.$pagecount.' 条/页 共 %TOTAL_ROW% 条</span>');
            $page->setConfig('theme','%UP_PAGE% %FIRST% %LINK_PAGE% %END% %DOWN_PAGE% %HEADER% ');
            $show = $page -> show();
            $state_list = M('state') -> where(array('tea_no' => session('user'))) -> order('id') -> limit($page->firstRow.','.$page->listRows)-> select();
            $state_all = M('state') -> where(array('tea_no' => session('user'))) -> select();//所有学生状态数据
            foreach($state_all as &$v){
                $v['create_time']=date("Y-m-d",$v['create_time']);//时间戳转日期格式
            }
            S('stateExcel',$state_all,300);//设置缓存
            $this -> teaSelect();
            $this -> assign('page', $show);
            $this -> assign('state_list',$state_list);
            $this -> display();
            
        }
    }
    //筛选状态
    public function selectState() {
        /*
        管理员 筛选
         */
        if (session('nameid') == C('USER_ADMINISTRATOR')) {
            $this -> arrSelect();
            $arr[]=I('get.teacher');
            $arr[]=I('get.class');
            $this -> assign('arr',$arr);
            if (!empty(I('get.teacher'))){
                $map['tea_no'] = I('get.teacher');
            }
            if (!empty(I('get.class'))){
                $map['class_name'] = I('get.class');
            }
            if ((empty(I('get.beginDate'))) && (empty(I('get.overDate')))){ //日期为空
                $pagecount = 20;
                $count = count(M('state') -> where($map) -> select());//数据总条数
                $page = new \Think\Page($count,$pagecount);
                $page->setConfig('header','<span class="rows">'.$pagecount.' 条/页 共 %TOTAL_ROW% 条</span>');
                $page->setConfig('theme','%UP_PAGE% %FIRST% %LINK_PAGE% %END% %DOWN_PAGE% %HEADER% ');
                $show = $page -> show();
                $state_list = M('State') -> order('id') -> where($map) -> limit($page->firstRow.','.$page->listRows)-> select(); 
                $state_exp_list = M('state') -> where($map) -> select();
                if (!empty($state_list)) {
                    $this -> assign('page', $show);
                    $this -> assign('state_list',$state_list);
                    foreach($state_exp_list as &$v){
                        $v['create_time']=date("Y-m-d",$v['create_time']);//时间戳转日期格式
                    }
                    S('stateExcel',$state_exp_list,300);
                    $this -> display('export');
                } else {
                    $this -> error('未查询到点名状态');
                    exit();
                }  
            } else { //日期不为空
                $begin_date = I('get.beginDate');
                $over_date = I('get.overDate');

                $this -> assign('begin_date',$begin_date);
                $this -> assign('over_date',$over_date);
                
                $pagecount = 20;//每页100条数据
                $count = count(M('state') -> where($map) ->where("FROM_UNIXTIME(create_time,'%Y-%m-%d') >= DATE_FORMAT('".$begin_date."','%Y-%m-%d') and FROM_UNIXTIME(create_time,'%Y-%m-%d') <= DATE_FORMAT('".$over_date."','%Y-%m-%d')") -> select());//数据总条数
                $page = new \Think\Page($count,$pagecount);
                $page->setConfig('header','<span class="rows">'.$pagecount.' 条/页 共 %TOTAL_ROW% 条</span>');
                $page->setConfig('theme','%UP_PAGE% %FIRST% %LINK_PAGE% %END% %DOWN_PAGE% %HEADER% ');
                $show = $page -> show();
                $state_list = M('State') -> where($map)->where("FROM_UNIXTIME(create_time,'%Y-%m-%d') >= DATE_FORMAT('".$begin_date."','%Y-%m-%d') and FROM_UNIXTIME(create_time,'%Y-%m-%d') <= DATE_FORMAT('".$over_date."','%Y-%m-%d')") -> limit($page->firstRow.','.$page->listRows)-> select(); 
                $state_exp_list = M('state') -> where($map) ->where("FROM_UNIXTIME(create_time,'%Y-%m-%d') >= DATE_FORMAT('".$begin_date."','%Y-%m-%d') and FROM_UNIXTIME(create_time,'%Y-%m-%d') <= DATE_FORMAT('".$over_date."','%Y-%m-%d')") -> select();
                if (!empty($state_list)) {
                    $this -> assign('page', $show);
                    $this -> assign('state_list',$state_list);
                    foreach($state_exp_list as &$v){
                        $v['create_time']=date("Y-m-d",$v['create_time']);//时间戳转日期格式
                    }
                    S('stateExcel',$state_exp_list,300);
                    $this -> display('export');
                } else {
                    $this -> error('未查询到点名状态');
                    exit();
                } 
            }
        } else {
            /*
            普通教师筛选
             */
            $this -> teaSelect();
            $arr[]=I('get.teacher');
            $arr[]=I('get.class');
            $this -> assign('arr',$arr);
            
            $tea_list = M('teacher') -> find(session("nameid"));
            $tea = array('tea_no' => session('user'));
            if (!empty(I('get.teacher'))){
                $map['tea_no'] = I('get.teacher');
            }
            if (!empty(I('get.class'))){
                $map['class_name'] = I('get.class');
            }
            //判断日期是否为空
            if ((empty(I('get.beginDate'))) && (empty(I('get.overDate')))){   
                $pagecount = 10;
                $count = count(M('state') -> where($map) -> where($tea) -> select());//数据总条数
                $page = new \Think\Page($count,$pagecount);
                $page->setConfig('header','<span class="rows">'.$pagecount.' 条/页 共 %TOTAL_ROW% 条</span>');
                $page->setConfig('theme','%UP_PAGE% %FIRST% %LINK_PAGE% %END% %DOWN_PAGE% %HEADER% ');
                $show = $page -> show();
                $state_list = M('State') -> where($map) -> where($tea) -> limit($page->firstRow.','.$page->listRows)-> select(); 
                $state_exp_list = M('state') -> where($map) -> where($tea) -> select();
                if (empty($state_list)) {
                    $this -> error('未查询到点名状态');
                    exit();
                } else {
                    S('stateExcel',$state_exp_list,300);
                    $this -> assign('page',$show);
                    $this -> assign('state_list',$state_list);
                    $this -> display('export');
                }   
            } else {
                $begin_date = I('get.beginDate');
                $over_date = I('get.overDate');

                $this -> assign('begin_date',$begin_date);
                $this -> assign('over_date',$over_date);
                $pagecount = 10;//每页100条数据
                $count = count(M('state') -> where($map)->where($tea) ->where("FROM_UNIXTIME(create_time,'%Y-%m-%d') >= DATE_FORMAT('".$begin_date."','%Y-%m-%d') and FROM_UNIXTIME(create_time,'%Y-%m-%d') <= DATE_FORMAT('".$over_date."','%Y-%m-%d')") -> select());//数据总条数
                $page = new \Think\Page($count,$pagecount);
                $page->setConfig('header','<span class="rows">'.$pagecount.' 条/页 共 %TOTAL_ROW% 条</span>');
                $page->setConfig('theme','%UP_PAGE% %FIRST% %LINK_PAGE% %END% %DOWN_PAGE% %HEADER% ');
                $show = $page -> show();

                $state_list = M('State') -> where($map)->where($tea)->where("FROM_UNIXTIME(create_time,'%Y-%m-%d') >= DATE_FORMAT('".$begin_date."','%Y-%m-%d') and FROM_UNIXTIME(create_time,'%Y-%m-%d') <= DATE_FORMAT('".$over_date."','%Y-%m-%d')") -> limit($page->firstRow.','.$page->listRows) -> select(); 

                $state_exp_list = M('state') -> where($map) -> where($tea)->where("FROM_UNIXTIME(create_time,'%Y-%m-%d') >= DATE_FORMAT('".$begin_date."','%Y-%m-%d') and FROM_UNIXTIME(create_time,'%Y-%m-%d') <= DATE_FORMAT('".$over_date."','%Y-%m-%d')") -> select();

                $this -> assign('page',$show);
                $this -> assign('state_list',$state_list);
                foreach($state_list as &$v){
                    $v['create_time']=date("Y-m-d",$v['create_time']);//时间戳转日期格式
                }
                if (empty($state_list)) {
                    $this -> error('未查询到点名状态');
                    exit();
                } else {
                    S('stateExcel',$state_exp_list,300);
                    $this -> display('export');
                }
            }
        }
    }
    /*
    管理员查询教师班级日期
     */
    protected function arrSelect(){
        $cls_list = M('class') -> select();
        $tea_list = M('teacher') -> where("id !=".session('nameid') ) -> select();
        $this -> assign('cls_list',$cls_list);
        $this -> assign('tea_list',$tea_list);
    }
    //教师查询班级日期
    protected function teaSelect() {
        $tea_list = M('teacher') -> select(session("nameid"));
        foreach ($tea_list as $value) {
            $cls_name[] = $value['class_id'];
        }
        $clsName = implode(",",$cls_name);//数组转字符串
        $where = array('cls_id' => array('in',$clsName));
        $cls_list = M('class') -> where(array('id' => array('in',$clsName))) -> select();
        $this -> assign('tea_list',$tea_list);
        $this -> assign('cls_list',$cls_list);
    }
      /**方法**/

    protected function exportExcel($expTitle,$expCellName,$expTableData){
        $xlsTitle = iconv('utf-8', 'gb2312', $expTitle);//文件名称
        $cellNum = count($expCellName);
        $dataNum = count($expTableData);
        vendor("PHPExcel.PHPExcel");
        $objPHPExcel = new \PHPExcel();
        $cellName = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z','AA','AB','AC','AD','AE','AF','AG','AH','AI','AJ','AK','AL','AM','AN','AO','AP','AQ','AR','AS','AT','AU','AV','AW','AX','AY','AZ');
        $objPHPExcel->getActiveSheet(0)->mergeCells('A1:'.$cellName[$cellNum-1].'1');//合并单元格
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', $expTitle.'  Export time:'.date('Y-m-d H:i:s'));  
        for($i=0;$i<$cellNum;$i++){
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($cellName[$i].'2', $expCellName[$i][1]); 
        } 
          // Miscellaneous glyphs, UTF-8   
        for($i=0;$i<$dataNum;$i++){
          for($j=0;$j<$cellNum;$j++){
            $objPHPExcel->getActiveSheet(0)->setCellValue($cellName[$j].($i+3), $expTableData[$i][$expCellName[$j][0]]);
          }             
        }  
        header('pragma:public');
        header('Content-type:application/vnd.ms-excel;charset=utf-8;name="'.$xlsTitle.'.xls"');
        header('Content-Disposition:attachment;filename="'.$xlsTitle.'.xls"');//attachment新窗口打印inline本窗口打印
        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');  
        $objWriter->save('php://output'); 
        exit;   
    }
    /**
     *
     * 导出Excel
     */
    function expUser(){//导出Excel
        foreach (S('stateExcel') as $value) {
           
        }
        // dump($value['class_name']);
        // die;
        $xlsName  = $value['class_name'];
        $xlsCell  = array(
        array('stu_id','学号'),
        array('stu_name','名字'),
        array('state','状态'),
        array('class_name','班级'),
        array('teacher_name','教师'),
        array('create_time','点名时间')
        );
        if (empty(S('stateExcel'))){
            $this->error('导出失败');
        }else{
            $this->exportExcel($xlsName,$xlsCell,S('stateExcel'));
        }
    }
}
