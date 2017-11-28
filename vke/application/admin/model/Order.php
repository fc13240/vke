<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/11/27
 * Time: 13:57
 */

namespace app\admin\model;
use app\admin\model\Base;
use think\Db;

class Order extends Base
{
    /**
     * 未处理的返利订单个数 - 20171127
     */
    public function getOrderNumber()
    {
        $map = [
            'back_status' => 2
        ];
        $number = Db::name('order')
            ->where($map)
            ->count();

        return $number;
    }

    /**
     * 返利订单数 - 20171127
     */
    public function getOrderList($map='')
    {
        $list = Db::view('Order','order_num,create_time,back_status,back_acer')
            ->view('Member','wechat_nickname','Order.member_id = Member.member_id')
            ->view('Product','pict_url,title','Order.num_iid = Product.num_iid')
            ->order('back_status','desc')
            ->where($map)
            ->select();
        return $list;
    }

    /**
     * 获得订单的会员id - 20171127
     */
    public function getMemberId($order_num)
    {
        $map = [
            'order_num' => ['in',$order_num]
        ];
        $member_id = Db::view('Order','member_id,back_acer')
            ->view('Member','member_acer','Order.member_id = Member.member_id')
            ->where($map)
            ->select();

        return $member_id;
    }

}