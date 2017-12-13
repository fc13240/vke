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
        $list = Db::view('exchange_order', 'order_id,address_id,order_num,exchange_num,alipay,telephone,express_status,is_able,exchange_time,product_type,alipay')
            ->view('product_acer', 'product_type,type,product_image,product_name', 'exchange_order.product_id = product_acer.product_id')
            ->view('member', 'wechat_nickname', 'exchange_order.member_id = member.member_id')
            ->where($map)
            ->select();
        //整理数组
        foreach ($list as $key => $value) {
                //查询地址信息
                $address = model('Address')
                    ->where('address_id', $value['address_id'])
                    ->field('province,country,district,address,person_name,telephone')
                    ->find();
                if(empty($address)){
                    $address = [
                        'province' => '',
                        'country' => '',
                        'district' => '',
                        'address' => '',
                        'person_name' => '',
                        'person_name' => ''
                    ];
                }
                $list[$key]['address'] = $address;

            if ($value['product_type'] == 1) {
                if($value['type'] == 1){
                    $list[$key]['goods_type'] = 1;
                }elseif($value['type'] == 2){
                    $list[$key]['goods_type'] = 2;
                }
                $list[$key]['product_type'] = '虚拟类';
            } elseif ($value['product_type'] == 2) {
                $list[$key]['goods_type'] = 3;
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
    public function getOrderInfo($map, $fields)
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

    /**
     * 查询某段时间内下单的人数 - 20171206
     */
    public function getSuccessPerson($map)
    {
        $map['status'] = 2;
        $map['is_able'] = 1;
        $people = Db::name('exchange_order')
            ->where($map)
            ->column('member_id');
        return array_unique($people);
    }
}