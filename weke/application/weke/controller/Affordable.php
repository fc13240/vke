<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/10/27 0027
 * Time: 16:33
 */
namespace app\weke\controller;

class Affordable
{
    //查询应季必备的banner
    public function seasonIndex()
    {
        $banner = model('Banner')->getBannerList(4);
        //查询应急必备的商品信息
        $seasonProducts = model('other_product')->getProductList();

        return [
            'status' => '1',
            'message' => '请求成功',
            'banner' => $banner,
            'season_products' => $seasonProducts
        ];
    }

    //聚折扣  调用商品查询api查询6折以下的商品展示在此
    public function discount()
    {

    }

    //9.9专区  调用商品查询api查找价格在9.9的商品
    public function nine()
    {

    }

    //19.9专区   调用商品查询api查找价格在19.9左右的商品
    public function nineteen()
    {

    }
}