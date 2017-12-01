<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/11/9
 * Time: 10:22
 */

namespace app\admin\model;
use app\admin\model\Base;
use think\Db;

class AuthGroupAccess extends Base
{
    /**
     *
     * @param $group_id
     * @return array
     */
    public function getGroupUsers($map)
    {
        $admin_id = Db::name('auth_group_access')
            ->where($map)
            ->column('uid');
        return $admin_id;
    }

    /**
     * 查询该管理员所在分组
     * @param $admin 管理员id
     */
    public function getGroupId($admin){
        $group_id = Db::name('auth_group_access')
            ->where('uid',$admin)
           // ->fetchsql(true)
            ->column('group_id');
        return $group_id;
    }

    public function getGroup($admin)
    {
        $group_id = Db::name('auth_group_access')
            ->where('uid',$admin)
            // ->fetchsql(true)
            ->field('group_id')
            ->select();
        return $group_id;
    }
}