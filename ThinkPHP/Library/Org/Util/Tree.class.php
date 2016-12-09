<?php
/**
 * [无限分级类]
 * @Author xiaohao
 * @version v1.0
 * @time    2014-12-5
 */
// +----------------------------------------------------------------------
namespace Org\Util;

class Tree {

    static public function findChild(&$data, $pid = 0, $col_pid = 'parent') {
        $rootList = array();
        foreach ($data as $key => $val) {
            if ($val[$col_pid] == $pid) {
                $rootList[]   = $val;
                unset($data[$key]);
            }
        }
        return $rootList;
    }

    /**
     * 无限分级
     * @access  public
     * @param   array     &$data      数据库里取得的结果集 地址引用
     * @param   integer   $pid        父级id的值
     * @param   string    $col_id     自增id字段名（对应&$data里的字段名）
     * @param   string    $col_pid    父级字段名（对应&$data里的字段名）
     * @param   string    $col_cid    是否存在子级字段名（对应&$data里的字段名）
     * @return  array     $childs     返回整理好的数组
     */
    static public function getTree(&$data, $pid = 0, $col_id = 'id', $col_pid = 'parent', $col_cid = 'haschild') {
        $childs = self::findChild($data, $pid, $col_pid);
        if (empty($childs)) {
            return null;
        }
        foreach ($childs as $key => $val) {
            if ($val[$col_cid]) {
                $treeList = self::getTree($data, $val[$col_id], $col_id, $col_pid, $col_cid);
                if ($treeList !== null) {
                    $childs[$key]['childs'] = $treeList;
                }
            }
        }
        return $childs;
    }
}