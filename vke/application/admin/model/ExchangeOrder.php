<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/11/13
 * Time: 15:12
 */

namespace app\admin\model;
use app\admin\model\Base;
use think\Db;

class ExchangeOrder extends Base
{

    /**
     * 查询订单列表
     * @param $map 查询条件
     * @return false|\PDOStatement|string|\think\Collection
     */
    public function getOrderList($map)
    {
        $map['is_able'] = 1;
        $list = Db::view('exchange_order','order_id,address_id,order_num,exchange_num,alipay,telephone,express_status,is_able,exchange_time,product_type')
            ->view('product_acer','product_type,product_image,product_name','exchange_order.product_id = product_acer.product_id')
            ->view('member','wechat_nickname','exchange_order.member_id = member.member_id')
            ->where($map)
            ->select();
        //整理数组
        foreach($list as $key => $value){
            if(!empty($value['address_id'])){
                //查询地址信息
                $address = model('Address')
                    ->where('address_id',$value['address_id'])
                    ->field('province,country,district,address,person_name,telephone')
                    ->select();
                $list[$key]['address'] = $address;
            }
            if($value['product_type'] == 1) {
                $list[$key]['product_type'] = '虚拟类';
            }
            elseif($value['product_type'] == 2){
                $list[$key]['product_type'] = '实物类';
            }
            unset($list[$key]['address_id']);
            unset($list[$key]['is_able']);
        };
        return $list;
    }

    /**
     * 获得订单信息
     */
    public function getOrderInfo($map,$fields)
    {
        $info = Db::name('exchange_order')
            ->where($map)
            ->field($fields)
            ->select();
        return $info;
    }

    /**
     * 获得未发货的订单的数量 - 20171124
     */
    public function getNumber()
    {
        $map = [
            'status' => 1,
            'express_status' => 1,
            'is_able' => 1
        ];
        $number = Db::name('exchange_order')
            ->where($map)
            ->count();
        return $number;
    }
}