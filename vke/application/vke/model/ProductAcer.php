<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/10/27 0027
 * Time: 10:11
 */
namespace app\vke\model;

use think\Model;
use think\Db;
class ProductAcer extends Model
{
    public function getAcerGoodsList()
    {
        //查询积分商城商品
        $acerGoodsList = $this
            ->where('is_sale','eq','1')
            ->order('sorts','desc')
            ->field('product_id,product_name,product_image,title,market_price,exchange_acer,stock')
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

    /**
     * 查询积分商品详情
     */
    public function getProductAcerInfo($product_id,$fields)
    {
        $map = [
            'product_id' => $product_id,
            'stock'=>['gt',0],
            'is_sale' => 1
        ];
        $productInfo = Db::table('vke_product_acer')
            ->where($map)
            ->field($fields)
            ->find();
        return $productInfo;
    }
}