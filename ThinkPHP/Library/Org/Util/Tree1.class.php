<?php
/**
 +------------------------------------------------
 * 通用的树型类
 * 请使用的朋友注意 id, name, pid 这三个下标, id的值与数组下标必须吻合 
 +------------------------------------------------
 * @author phpuser@163.com
 +------------------------------------------------
 * @date 2010年11月23日10:09:31
 +------------------------------------------------
 */
namespace Org\Util;
class Tree{
	
	/**
	 * +------------------------------------------------
	 * 生成树型结构所需要的2维数组
	 * +------------------------------------------------
	 * @var Array
	 */
	var $arr = array ();
	
	/**
	 * +------------------------------------------------
	 * 生成树型结构所需修饰符号，可以换成图片
	 * +------------------------------------------------
	 *
	 * @author yangyunzhou@foxmail.com
	 *         +------------------------------------------------
	 * @var Array
	 */
	var $icon = array (
			'│',
			'├─',
			'└─' 
	);
	
	/**
	 *
	 * @access private
	 */
	var $ret = '';
	
	/**
	 * 构造函数，初始化类
	 *
	 * @param
	 * array 2维数组，例如：
	 *    array(
	 *        	1 => array('id'=>'1','pid'=>0,'name'=>'一级栏目一'),
	 *        	2 => array('id'=>'2','pid'=>0,'name'=>'一级栏目二'),
	 *        	3 => array('id'=>'3','pid'=>1,'name'=>'二级栏目一'),
	 *        	4 => array('id'=>'4','pid'=>1,'name'=>'二级栏目二'),
	 *        	5 => array('id'=>'5','pid'=>2,'name'=>'二级栏目三'),
	 *        	6 => array('id'=>'6','pid'=>3,'name'=>'三级栏目一'),
	 *        	7 => array('id'=>'7','pid'=>3,'name'=>'三级栏目二')
	 *    )
	 */
	function tree($arr = array()){
		$this->arr = $arr;
		$this->ret = '';
		return is_array ( $arr );
	}
	
	/**
	 * 得到父级数组
	 * @param
	 * int
	 * @return array
	 */
	function get_parent($myid) {
		$newarr = array ();
		if (! isset ( $this->arr[$myid] ))
			return false;
		$pid = $this->arr [$myid] ['pid'];
		$pid = $this->arr [$pid] ['pid'];
		if (is_array ( $this->arr )) {
			foreach ( $this->arr as $id => $a ) {
				if ($a ['pid'] == $pid)
					$newarr [$id] = $a;
			}
		}
		return $newarr;
	}
	
	/**
	 * 得到子级数组
	 *
	 * @param
	 *        	int
	 * @return array
	 */
	function get_child($myid) {
		$a = $newarr = array ();
		if (is_array ( $this->arr )) {
			foreach ( $this->arr as $id => $a ) {
				if ($a ['pid'] == $myid)
					$newarr [$id] = $a;
			}
		}
		return $newarr ? $newarr : false;
	}
	
	/**
	 * -------------------------------------
	 * 得到树型结构，适应于select下来选择
	 * -------------------------------------
	 * @param $myid 表示获得这个ID下的所有子级	
	 * @param $str 生成树形结构基本代码,
	 *        	例如: "<option value=\$id \$select>\$spacer\$name</option>"
	 *        	这里的$str风格大家可以根据实际使用情况自定义，以便应用于不同的场景
	 * @param $sid 被选中的ID,
	 *        	比如在做树形下拉框的时候需要用到
	 * @param
	 *        	$adds
	 */
	function get_tree($myid, $sid = 0, $str="<option value=\$id \$selected>\$spacer\$name</option>", $adds = ''){
		$number = 1;
		
		$child = $this->get_child ( $myid );
		if (is_array ( $child )) {
			$total = count ( $child );
			foreach ( $child as $id => $a ) {
				$j = $k = '';
				if ($number == $total) {
					$j .= $this->icon [2];
				} else {
					$j .= $this->icon [1];
					$k = $adds ? $this->icon [0] : '';
				}
				
				@extract( $a );
				$spacer = $adds ? $adds . $j : '';
				$selected = $id == $sid ? 'selected' : '';
				eval( "\$nstr = \"$str\";");
				$this->ret .= $nstr;
				$this->get_tree($id, $sid, $str, $adds.$k.'&nbsp;');
				$number ++;
			}
		}
		return $this->ret;
	}
	
	/**
	 * 同上一方法类似,但允许多选
	 * 这里的$str风格大家可以根据实际使用情况自定义，以便应用于不同的场景
	 */
	function get_tree_multi($myid, $sid = 0, $str="<option value=\$id \$select>\$spacer\$name</option>", $adds = ''){
		$number = 1;
		$child = $this->get_child ( $myid );
		if (is_array ( $child )) {
			$total = count ( $child );
			foreach ( $child as $id => $a ) {
				$j = $k = '';
				if ($number == $total) {
					$j .= $this->icon [2];
				} else {
					$j .= $this->icon [1];
					$k = $adds ? $this->icon [0] : '';
				}
				$spacer = $adds ? $adds . $j : '';
				
				$selected = $this->have( $sid, $id ) ? 'selected' : '';
				@extract ( $a );
				eval ( "\$nstr = \"$str\";" );
				$this->ret .= $nstr;
				$this->get_tree_multi ($id, $sid, $str, $adds.$k.'&nbsp;');
				$number ++;
			}
		}
		return $this->ret;
	}
	
	function have($list, $item){
		return (strpos ( ',,' . $list . ',', ',' . $item . ',' ));
	}
	
	/**
	 * +------------------------------------------------
	 * 格式化数组
	 * +------------------------------------------------
	 */
	function getArray($myid = 0, $sid = 0, $adds = '') {
		$number = 1;
		$child = $this->get_child ( $myid );
		if (is_array ( $child )) {
			$total = count ( $child );
			foreach ( $child as $id => $a ) {
				$j = $k = '';
				if ($number == $total) {
					$j .= $this->icon [1];
				} else {
					$j .= $this->icon [1];
					$k = $adds ? $this->icon [0] : '';
				}
				$spacer = $adds ? $adds . $j : '';
				@extract ( $a );
				$a ['name'] = $spacer . ' ' . $a ['name'];
				$this->ret [$a ['id']] = $a;
				$fd = $adds . $k . '&nbsp;&nbsp;&nbsp;&nbsp;';
				$this->getArray ( $id, $sid, $fd );
				$number ++;
			}
		}
		
		return $this->ret;
	}
}
?>