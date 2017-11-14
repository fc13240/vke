<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/10/27 0027
 * Time: 14:00
 */
namespace app\vke\model;

use think\Model;
class OtherProduct extends Model
{
    public function getProductList()
    {
        $list = $this
        ->where('type','eq','1')
        ->where('status','eq','1')
        ->field('image,title,after_price,surplus_stock,saled_number')
        ->select();
        return $list;
    }
}