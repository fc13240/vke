<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/11/15
 * Time: 9:12
 */

namespace app\admin\model;
use app\admin\model\Base;
use think\Db;

class SignNotes extends Base
{
    public function getSignCount($map)
    {
        //根据日期查询当前签到的数据条数
        $count = Db::name('sign_notes')
            ->where($map)
            ->count();
        return $count;
    }
}