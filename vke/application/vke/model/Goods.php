<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/11/6
 * Time: 9:48
 */
namespace app\vke\model;
use think\Model;
use think\Db;


class Goods extends Model
{
    public function getProductInfo($product_id,$fields)
    {
        $map = [
            'id' => $product_id,
            'on_sale' => 1
        ];
        $productInfo = Db::table("vke_product")
            ->where($map)
            ->field($fields)
            ->find();
        return $productInfo;
    }
}