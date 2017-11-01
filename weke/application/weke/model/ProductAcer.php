<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/10/27 0027
 * Time: 10:11
 */
namespace app\weke\model;

use think\Model;

class ProductAcer extends Model
{
    public function getAcerGoodsList()
    {
        //查询积分商城商品
        $acerGoodsList = $this
            ->where('is_sale','eq','1')
            ->order('sorts','desc')
            ->select();
        return $acerGoodsList;
    }
    public function setDecStock($product_id)
    {
        $result = $this->where('product_id',$product_id)->setDec('stock');
        if($result !== false){
            return true;
        }else{
            return false;
        }
    }
}