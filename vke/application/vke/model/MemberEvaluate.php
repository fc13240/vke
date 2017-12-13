<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/11/6
 * Time: 16:22
 */

namespace app\vke\model;
use think\Model;
use think\Db;

class MemberEvaluate extends Model
{
    /**
     * 我的晒单
     */
    public function myShareOrder($user_id)
    {
        $map = [
            'member_id' => $user_id,
            'is_del' => '2'
        ];
        $my_order = Db::table('vke_member_evaluate')
            ->where($map)
            ->field('evaluate_id,evaluate_detail,evaluate_url,create_time,examine_status')
            ->order('create_time','desc')
            ->select();
        return $my_order;
    }

    /**
     * 晒单广场
     */
    public function getOrderSquare()
    {
        $map = [
            'e.examine_status' => '1',
            'e.is_del' => '2',
            'e.is_square' => '1'
        ];
        $square = Db::table('vke_member_evaluate')
            ->alias('e')
            ->join('vke_member m','e.member_id = m.member_id')
            ->where($map)
            ->field('m.wechat_nickname,m.wechat_head_image,e.evaluate_detail,e.evaluate_url,e.create_time')
            ->order('e.create_time','desc')
            ->select();
        return $square;
    }
}