<?php
namespace Admin\Model;
use Think\Model;
class StuModel extends Model{
	protected $_validate = array(
        array('no','','帐号名称已经存在！',0,'unique',1),
        array('no','require','存在空学号，请返回检查Excle表！'),
        array('no','number','学号必须为数字！'),
        array('name','require','存在空姓名，请返回检查Excle表！'),
        array('class_name','require','存在空班级，请返回检查Excle表！')
    );
}