<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/11/16
 * Time: 13:23
 */

namespace app\admin\model;
use app\admin\model\Base;
use think\Db;

class Member extends Base
{
    /**
     * 查询一段时间内登录过的人数 - 20171116
     */
    public function getLoginCount($map)
    {
        $count = Db::name('member')
            ->where($map)
            ->count();
        return $count;
    }

    /**
     * 查询新增的用户 - 20171116
     */
    public function getNewMember()
    {
        $list = Db::name('member')
            ->order('create_time','desc')
            ->limit(20)
            ->field('wechat_head_image,wechat_nickname,create_time')
            ->select();
        return $list;
    }

    /**
     * 查询用户当前已有的元宝 - 20171120
     */
    public function memberAcer($member_id)
    {
        $acer = Db::name('member')
            ->where('member_id','in',$member_id)
            ->field('member_acer,member_id')
            ->select();
        return $acer;
    }

    /**
     * 当前所有用户的id - 20171122
     */
    public function getMemberId()
    {
        $map = [
            'is_del' => 2
        ];
        $member_id = Db::name('member')
            ->where($map)
            ->column('member_id');
        return $member_id;
    }

    /**
     * 新增人数 - 20171122
     */
    public function getNewCount($map)
    {
        $count = Db::name('member')
            ->where($map)
            ->count();
        return $count;
    }
}