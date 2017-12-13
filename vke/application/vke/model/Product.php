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
        foreach($goods_list as $key => $value){
            $goods_list[$key]['reserve_price'] = rmb($value['reserve_price']);
            $goods_list[$key]['zk_final_price'] = rmb($value['zk_final_price']);
        }
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
        foreach($goodsList as $key => $value){
            $goodsList[$key]['reserve_price'] = rmb($value['reserve_price']);
            $goodsList[$key]['zk_final_price'] = rmb($value['zk_final_price']);
        }
        return $goodsList;
    }

    /**
     * 根据关键词搜索商品
     */
    public function getProductListByKeywords($keywords,$order='id',$sort='ASC')
    {
        $map = [
            'title' => ['like',"%$keywords%"],
            'on_sale' => 1
        ];


        $productList = DB::table('vke_product')
            ->where($map)
            ->order($order,$sort)
            ->field('id,title,pict_url,reserve_price,zk_final_price,volume')
            ->select();
        foreach($productList as $key => $value){
            $productList[$key]['reserve_price'] = rmb($value['reserve_price']);
            $productList[$key]['zk_final_price'] = rmb($value['zk_final_price']);
        }
        return $productList;

    }

    /**
     * 查询商品详情
     * @param $product_id
     * @param $fields
     * @return array|false|\PDOStatement|string|Model
     */
    public function getProductInfo($product_id,$fields)
    {
        $map = [
            'id' => $product_id,
            'on_sale' => 1
        ];
        $productInfo = Db::name("product")
            ->where($map)
            ->field($fields)
            ->find();
       if(empty($productInfo)){
           return ['error'=>'参数错误'];
       }

       if(!empty($productInfo['reserve_price'])){
           $productInfo['reserve_price'] = rmb($productInfo['reserve_price']);
       }
       if(!empty($productInfo['zk_final_price'])){
           $productInfo['zk_final_price'] = rmb($productInfo['zk_final_price']);
       }
        return $productInfo;
    }


    /**
     * 查询该分类下关联商品 - 20171212
     */
    public function getRelevance($product_type,$limit = 6)
    {
        $map = [
            'product_type'=>$product_type,
            'on_sale' => 1
        ];
        $relevance_list = Db::name('product')
            ->where($map)
            ->limit($limit)
            ->field('id,num_iid,title,pict_url,reserve_price,coupon_number,volume,zk_final_price')
            ->select();
        return $relevance_list;
    }
}