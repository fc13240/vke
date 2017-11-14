<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/11/8
 * Time: 14:39
 */

namespace app\admin\model;
use app\admin\model\Base;
use think\Db;

class AuthRule extends Base
{
    public static function getRuleList()
    {
        $map = [
            'status' => 1
        ];
        $list = Db::name('auth_rule')
            ->where($map)
            ->field('id,pid,name,title')
            ->select();
        return $list;
    }
}