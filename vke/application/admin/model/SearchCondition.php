<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/11/13
 * Time: 10:26
 */

namespace app\admin\model;
use app\admin\model\Base;
use think\Db;

class SearchCondition extends Base
{
    /**
     * 查询数据库查询条件
     * @param $type 条件类型
     * @return false|\PDOStatement|string|\think\Collection
     */
    public function getSearchCondition($type)
    {
        $map = [
            'type' => $type,
            'status' => 1
        ];
        $condition = Db::name('search_condition')
            ->where($map)
            ->order('sorts','desc')
            ->field('id,condition_min,condition_max')
            ->select();
        return $condition;
    }
}