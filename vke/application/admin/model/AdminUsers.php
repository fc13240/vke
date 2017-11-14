<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/11/8
 * Time: 10:41
 */

namespace app\admin\model;
use app\admin\model\Base;
use think\Db;

class AdminUsers extends Base
{
    /**
     * 查询所有管理员
     */
    public function getUserList()
    {
        $list = Db::name('admin_users')
            ->field('id,username,telephone,last_login_time,last_login_ip,status')
            ->select();
        return $list;
    }

    /**
     * 查询管理员信息
     */
    public function getUserInfo($admin_id,$fields)
    {
        $map = [
            'id' => $admin_id
        ];
        $info = Db::name('admin_users')
            ->where($map)
            ->field($fields)
            ->find();
        return $info;
    }
}