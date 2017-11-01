<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/10/27 0027
 * Time: 10:30
 */
namespace app\weke\model;

use think\Model;

class ExchangeOrder extends Model
{
    public function productAcer()
    {
        return $this->hasOne('product_acer','product_id','product_id');
    }
}