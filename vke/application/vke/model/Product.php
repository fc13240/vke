<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/11/2
 * Time: 16:03
 */
namespace app\vke\model;
use think\Model;
use think\Db;

class Product extends Model
{
    public function getGoodsList($goods_id)
    {
        $goods_list = $this
            ->where('id','in',$goods_id)
            ->order('zk_final_price','asc')
            ->field('id,title,pict_url,small_images,reserve_price,volume,zk_final_price,cat_name')
            ->select();
        if(empty($goods_list)){
            return [];
        }else{
            return $goods_list;
        }

    }

    /**
     * 根据store_type查询商品
     */
    public function getIndexGoods($product_type="",$store_type="",$fields="",$limit="",$order_field='id',$sorts='asc')
    {
        $map['on_sale']= 1;
        if(!empty($product_type)){
            $map['product_type'] = $product_type;
        }
        if(!empty($store_type)){
            $map['store_type'] = $store_type;
        }
        if(empty($limit)){
            $goodsList = Db::name('product')
                ->where($map)
                ->field($fields)
                ->order($order_field,$sorts)
                ->select();
        }else{
            $goodsList = Db::name('product')
                ->where($map)
                ->limit($limit)
               ->field($fields)
                ->order($order_field,$sorts)
                ->select();
        }

        return $goodsList;
    }

    /**
     * 根据关键词搜索商品
     */
    public function getProductListByKeywords($keywords)
    {
        $map = [
            'title' => ['like',"%$keywords%"],
            'on_sale' => 1
        ];

        $productList = DB::table('vke_product')
            ->where($map)
            ->order('zk_final_price','asc')
            ->field('id,title,pict_url,reserve_price,zk_final_price,volume')
            ->select();
        return $productList;

    }

}