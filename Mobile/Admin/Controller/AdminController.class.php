<?php
namespace Admin\Controller;
use Think\Controller;
class AdminController extends Controller {
	/**
	 *
     */
	protected function _initialize(){
		
		//CONTROLLER_NAME
		//dump(session('nameuser'));
		//dump(get_defined_constants(true));
		$this->CheckmSession();
		if (session('nameid') == C('USER_ADMINISTRATOR')) {

		} else {
			$auth=new \Think\Auth();
			if($auth->check(CONTROLLER_NAME.'/'.ACTION_NAME,session('nameid'))){
					
			}else{
				$this->error('没有访问权限！');
			}
		}
	}
    private function CheckmSession(){
        if(empty(session('nameid'))) {
            $this->error('当前用户未登录或登录超时，请重新登录',U('Login/login'));
        }
    }
}