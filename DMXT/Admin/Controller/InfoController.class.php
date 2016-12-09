<?php
namespace Admin\Controller;
use Think\Controller;
use Vender\File;
class InfoController extends Controller {
	//音频目录列表
	public function infoList(){
		
		$dirArray = File::get_dirs(C('AUDIO_PATH'));
		//dump($dirArray);
		$this->assign('dir',$dirArray);
		$this->display('list');
	}
	//音频目录删除
	public function del(){
		$dirName = I('get.dirName');
		File::del_dir(C('AUDIO_PATH').'/'.$dirName);
		$this -> success('删除'.$dirName.'届音频成功');
	}
}