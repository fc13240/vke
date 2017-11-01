<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/10/26 0026
 * Time: 16:30
 */
namespace app\weke\controller;

class Index
{

    //首页，不需要参数
    public function index()
    {
        //判断缓存
        $indexBanner = cache('index_banner');
        if(empty($indexBanner)){
            //查询首页banner图   1、首页banner
            $indexBanner = model('Banner')->getBannerList(1);
            cache('index_banner',$indexBanner);
        }
        //商品分类
        $goodsType = cache('goods_type',null);
        if(empty($goodsType)){
            //查询商品分类名称
            $goodsType = model('cate_type')->getGoodsType();
            cache('goods_type',$goodsType);
        }
        //商品列表(调用淘宝客api接口)

        $goods = [];
        return [
            'status' => '1',
            'message' => '请求成功',
            'data' => [
                'indexBanner'=>$indexBanner,
                'goodsType'=>$goodsType,
                'goods'=>$goods
            ]
        ];
    }



}