<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/11/6
 * Time: 17:12
 */

namespace app\vke\model;
use think\Model;
use think\Db;

class Order extends Model
{
    /**
     * 查询我的订单
     */
    public function getMyOrder($map)
    {
        $orderInfo = Db::table('vke_order')
            ->alias('o')
            ->join('vke_product p','o.num_iid = p.num_iid')
            ->where($map)
            ->field('p.title,p.reserve_price,p.zk_final_price,o.back_acer,o.order_num,o.back_status')
            ->order('o.create_time','desc')
            ->select();
        return $orderInfo;

    }
}