<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/11/15
 * Time: 18:02
 */

namespace app\admin\model;
use app\admin\model\Base;
use think\Db;

class MemberEvaluate extends Base
{
    /**
     * 查询晒单评论的条数 - 20171115
     */
    public function getEvaluateCount($map)
    {
        return Db::name('member_evaluate')
            ->where($map)
            ->count();
    }
}