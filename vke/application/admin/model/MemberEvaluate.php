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
        $count = Db::name('member_evaluate')
            ->where($map)
            ->count();
        return $count;
    }

    /**
     * 查询晒单详情 - 20171117
     */
    public function getEvaluateInfo($share_id)
    {
        $info = Db::view('MemberEvaluate','evaluate_detail,evaluate_url,update_time')
            ->view('Member','wechat_nickname,member_id','MemberEvaluate.member_id = Member.member_id')
            ->where('evaluate_id',$share_id)
            ->find();
        return $info;
    }

    /**
     * 获得批量晒单的会员id - 20171117
     */
    public function getMemberId($map)
    {
        $member_id = Db::name('member_evaluate')
            ->where($map)
            ->column('member_id');
    }
}