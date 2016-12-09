<?php
namespace Admin\Controller;
use Think\Controller;
class LoginController extends Controller {
   public function login() {
	    $teacher = M('Teacher');
	    if ($_POST) {
	      	$result = $teacher -> where(array('user' => I('post.user'))) -> find();
	      	if ($result['user'] == I('post.user') && $result['pwd'] == md5(I('post.pwd'))) {
	        	$verify = new\Think\Verify();
	          	if ($verify -> check(I('post.verify'))) {
		            session('user',$result['user']);
		            session('nameid',$result['id']);
		            // $this->success('登录成功！',U('Index/index'));
		            //登陆日志
		            \Think\Log::write('用户名：'.session('user').'时间：'.date('Y-m-d H:i:s',time()).' ip地址：'.get_client_ip(),'INFO');
		            // $data['info']   = "登陆成功,正在跳转。。。";
                    $data['status'] = 1;
                    $data['url']    = U('/Index/index');
                    $this->ajaxReturn($data, 'json');
		            exit();
		        } else {
		        	$data['info']   = "验证码错误,请检查重试。。。";
		            $data['status'] = 2;
		            $this->ajaxReturn($data, 'json');
	            	// $this -> error('验证码填写错误','',2);
	            	exit();
	          	}
	      	} else {
	      		$data['info']   = "登录失败，请检查用户或密码。。。";
	            $data['status'] = 3;
	            $data['url']    = U('/Login/login');
	            $this->ajaxReturn($data, 'json');
	        		// $this -> error('登录失败，请检查用户或密码','',2);
	        	exit();
	      	}
	    }else{
	    	$this -> display();
	    }
	    
	}
	//退出
	public function logout()
    {
        // 清楚所有session
        session(null);
        $this -> redirect('/Login/login');
    }
	//验证码
	public function verify() {
	    $config = array(
	      'fontSize' => 18,
	      'length' => 4,
	      'imageW' => 130,
	      // 'bg' => array(57, 179, 215),
	      'imageH' => 32,
	      'useCurve' => false,
	      'useNoise' => false,        
	    );
	    $verify = new \Think\Verify($config);
	    $verify->entry();
	}
	public function welcome(){
		$this->display();
	}
}