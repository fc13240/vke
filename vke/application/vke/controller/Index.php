<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/10/26 0026
 * Time: 16:30
 */
namespace app\vke\controller;
use app\vke\controller\Common;
use think\Loader;
use app\vke\controller\Test;
Loader::import('sdk.request.TbkJuTqgGetRequest');
Loader::import('sdk.TopClient');
Loader::import('sdk.request.TbkRebateOrderGetRequest');

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
            cache('goods_type', $goodsType,86400);
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
        $storeType = cache('store_type');
        if (empty($storeType)) {
            $storeType = model('CateType')->getIndexStoreList();
            cache('store_type', $storeType,86400);
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
		$goods_cache = cache('goods_cache');
		if(empty($goods_cache)){
			$fields = "id,title,pict_url,reserve_price,coupon_number,volume,zk_final_price";
			$goods_cache = model('Product')->getIndexGoods('',1,$fields);
			cache('goods_cache',$goods_cache,86400);
		}
        

        $result = [
            'data' => [
                'goods'=>$goods_cache
            ]
        ];
        return resultArray($result);
    }

    public function apiProducts()
    {
        \think\Loader::import('sdk.request.TbkItemGetRequest');
        $req = new \TbkItemGetRequest;
        $arr = [
            'setFields' => 'click_url,pic_url,reserve_price,zk_final_price,total_amount,sold_num,title,category_name,start_time,end_time',
            'setQ' => '女装',
        ];
       $result = getApiRequest($req,$arr);
    }

    public function sdk()
    {
        $c = new \TopClient;
        $c->appkey = 'Test';
        $c->secretKey = 'Test';
        $req = new \TbkJuTqgGetRequest;
        $req->setAdzoneId("1");
        $req->setFields("click_url,pic_url,reserve_price,zk_final_price,total_amount,sold_num,title,category_name,start_time,end_time");
        $req->setStartTime("2017-11-24 13:00:00");
        $req->setEndTime("2017-11-24 15:00:00");
        $req->setPageNo("1");
        $req->setPageSize("40");
        $resp = $c->execute($req);
        dump($resp);
    }

    public function apiOrder()
    {
        $c = new \TopClient;
        $c->appkey = 'Test';
        $c->secretKey = 'Test';
        $req = new \TbkRebateOrderGetRequest;
        $req->setFields("tb_trade_parent_id,tb_trade_id,num_iid,item_title,item_num,price,pay_price,seller_nick,seller_shop_title,commission,commission_rate,unid,create_time,earning_time");
        $req->setStartTime("2017-11-23 13:52:08");
        $req->setSpan("600");
        $req->setPageNo("1");
        $req->setPageSize("20");
        $resp = $c->execute($req);
        dump($resp);
    }
}