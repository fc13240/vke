<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/10/26 0026
 * Time: 16:30
 */
namespace app\vke\controller;
use app\vke\controller\Common;
class Index extends Common
{
    public function index()
    {
        return view('index',['msg'=>'132465']);
    }
    //首页，不需要参数
    public function index_banner()
    {
        //判断缓存
        $indexBanner = cache('index_banner');
        if (empty($indexBanner)) {
            //查询首页banner图   1、首页banner
            $indexBanner = model('Banner')->getBannerList(1);
            cache('index_banner', $indexBanner);
        }
        $result = [
            'data' => [
                'index_banner' => $indexBanner,
            ]
        ];
        return resultArray($result);
    }


    /**
     * 商品分类
     * @return array|\think\response\Json
     */
    public function index_type()
    {
        //商品分类
        $goodsType = cache('goods_type');
        if (empty($goodsType)) {
            //查询商品分类名称
            $fields = 'id,cate_name,image_url';
            $goodsType = model('CateType')->getGoodsType($fields);
            cache('goods_type', $goodsType);
        }
        $result = [
            'data' => [
                'goods_type_up'=>$goodsType,
            ]
        ];
        return resultArray($result);
    }

    public function index_store_type()
    {
        //商店分类(应季必备,粉丝福利,超值线报)
        //$storeType = cache('store_type');
        if (empty($storeType)) {
            $storeType = model('CateType')->getIndexStoreList();
            cache('store_type', $storeType);
        }
        $result = [
            'data' => [
                'goods_type_down' => $storeType,
            ]
        ];
        return resultArray($result);
    }
    public function index_goods()
    {
        //商品列表,查询属于普通商品的 store_type = 1;
        $fields = "id,title,pict_url,small_images,reserve_price,volume,zk_final_price";
        $goods = model('Product')->getIndexGoods('',1,$fields);

        $result = [
            'data' => [
                'goods'=>$goods
            ]
        ];
        return resultArray($result);
    }
}