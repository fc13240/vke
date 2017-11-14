<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/11/8
 * Time: 15:37
 */

namespace app\admin\model;
use app\admin\model\Base;
use think\Db;

class AuthGroup extends Base
{
    /**
     * 获得所有分组
     * @return false|\PDOStatement|string|\think\Collection
     */
    public function getGroupList()
    {
        $map = [
            'status' => 1
        ];
        $list = Db::name('auth_group')
            ->where($map)
            ->order('id','asc')
            ->field('id,title')
            ->select();
        return $list;
    }

    /**
     * 获得该组所拥有的权限
     */
    public function getGroupRule($group_id)
    {
        $map = [
            'id' => $group_id
        ];
        $rule = Db::name('auth_group')
            ->where($map)
            ->value('rules');
        $rule_array = explode(',',$rule);
        return $rule_array;
    }

    /**
     * 获得分组名称
     * @param $group_id 分组id
     */
    public function getGroupName($group_id)
    {
        $group_name = Db::name('auth_group')
            ->where('id',$group_id)
            ->value('title');
        return $group_name;
    }
}