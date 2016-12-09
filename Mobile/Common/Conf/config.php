<?php
return array(
	//'配置项'=>'配置值'
	
	'MODULE_ALLOW_LIST' => array ('Admin'),
 	'DEFAULT_MODULE' => 'Admin', //默认模块
 	'DEFAULT_CONTROLLER' => 'Login', //默认控制器
 	'DEFAULT_ACTION' => 'login', //默认操作方法
	'ERROR_PAGE'   =>  '/Public/html/404.html', //404页面
    'LOG_RECORD' => true, // 开启日志记录
    'LOG_LEVEL'  =>'EMERG,ALERT,CRIT,ERR,INFO', // 只记录EMERG ALERT CRIT ERR 错误 INFO登陆信息
    'URL_MODEL' => '2',
    'URL_CASE_INSENSITIVE'  =>  true ,//大小写不区分（true）


);