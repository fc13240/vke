<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/11/13
 * Time: 15:30
 */

namespace app\admin\model;
use app\admin\model\Base;
use think\Db;

class ProductAcer extends Base
{
    /**
     * 查询积分商城商品 - 20171114
     * @param $map 查询条件
     */
    public function getProductAcer($map)
    {
        $count = Db::name('product_acer')->where($map)->count();
        $list = Db::name('product_acer')
            ->where($map)
            ->order('add_time','desc')
            ->field('product_id,product_image,product_type,product_name,market_price,exchange_acer,stock,is_sale')
            ->paginate(1,$count,['path'=>'http://192.168.1.101/admin/Acerstore/acerList']);
        return $list;
    }

    /**
     * 查询积分商品信息
     */
    public function getProductInfo($map,$fields)
    {
        $info = Db::name('product_acer')
            ->where($map)
            ->field($fields)
            ->find();
    }
}