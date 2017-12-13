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
            ->field('product_id,product_image,product_type,type,product_name,market_price,exchange_acer,stock,is_sale')
            ->select();
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
        $small_images = explode(',',$info['small_images']);
        if($info['product_type'] == 2){
            $info['goods_type'] = 3;
        }
        elseif($info['product_type'] == 1 && $info['type'] == 1){
            $info['goods_type'] = 1;
        }
        elseif($info['product_type'] == 1 && $info['type'] == 2){
            $info['goods_type'] = 2;
        }
        unset($info['product_type']);
        unset($info['type']);
        $info['small_images'] = $small_images;
        $info['market_price'] = $info['market_price'];
        return $info;
    }
}