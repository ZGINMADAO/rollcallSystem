<?php
/*
检查栏目显示
 */
function checkRule($name,$uid){
	if ($uid == C('USER_ADMINISTRATOR')) {
		return true;
	}
	$auth=new \Think\Auth();
	if($auth->check($name,$uid)){
		return true;
	}else{
		return false;
	}
}

/*
过滤excle表的后缀名 例：机械1521.xls返回值 机械1521
 */
function filteExcel($string){
	$pattern = '/\.[A-Za-z]{3,}/i';
	$replacement = '';
	return trim(preg_replace($pattern, $replacement, $string));
}
/*
过滤字符串中的任何空白字符，包括空格、制表符、换页符等等
 */
function space($string){
	$pattern = '/\s/i';
	$replacement ='';
	return preg_replace($pattern, $replacement, $string);
}
function filterYearByStuNO(){
	$pattern = '/\.[A-Za-z]{3,}/i';
	$replacement = '';
	return trim(preg_replace($pattern, $replacement, $string));
}

