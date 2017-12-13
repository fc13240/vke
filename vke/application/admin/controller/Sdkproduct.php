<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/12/12
 * Time: 9:14
 */

namespace app\admin\controller;
use app\common\controller\Base;
use think\Request;
use \traits\sdk\top\TopClient;
use \traits\sdk\top\request\TbkItemGetRequest;
use \traits\sdk\top\request\TbkDgItemCouponGetRequest;
use \traits\sdk\top\request\TbkItemInfoGetRequest;
use \traits\sdk\top\request\TbkCouponGetRequest;
use \traits\sdk\top\request\TbkItemConvertRequest;
use think\Db;


class Sdkproduct extends Base
{

    /**
     * tbkapi - 商品查询 - 20171212
     */
    public function selectProduct()
    {
        $c = new TopClient;
        $c->appkey = config('app_key');
        $c->secretKey = config('app_secret');
        $req = new TbkItemGetRequest;
        $req->setFields("num_iid,title,pict_url,small_images,reserve_price,zk_final_price,user_type,provcity,item_url,seller_id,volume,nick");
        $req->setQ("全部");
        //$req->setCat("16,18");
        $req->setStartTkRate('2000');
        $req->setEndTkRate('5000');
        $resp = $c->execute($req);
        dump($resp);
    }

    /**
     * 好券清单api - 20171212
     */
    public function selectCoupon()
    {
        $adzone_id = config('adzone_id');

        $c = new TopClient;
        $c->appkey = config('app_key');
        $c->secretKey = config('app_secret');
        $req = new TbkDgItemCouponGetRequest;
        $req->setAdzoneId($adzone_id);
        $req->setPlatform("2");
        //$req->setCat("16,18");
        $req->setPageSize("100");
        $req->setQ("食品");
        $resp = $c->execute($req);
        foreach ($resp['results']['tbk_coupon'] as $key => $value){
            $coupon_amount = 0;
            if(!empty($value['coupon_info'])){
                $str = $value['coupon_info'];
                $isMatch = preg_match('/\d*元$/', $str, $matches);
                $coupon_amount =$matches[0];
            }
            $array = [
                'num_iid' => $value['num_iid'],
                'title' => $value['title'],
                'item_url' => $value['item_url'],
                'click_url' => $value['coupon_click_url'],
                'pict_url' => $value['pict_url'],
                'reserve_price' => $coupon_amount + $value['zk_final_price'],
                'zk_final_price' => $value['zk_final_price'],
                'coupon_number' => $coupon_amount,
                    'stock' => $value['coupon_remain_count'],
                'brokerage' => $value['commission_rate'],
                'user_type' => $value['user_type'],
                'nick' => $value['nick'],
                'seller_id' => $value['seller_id'],
                'volume' => $value['volume'],
                'create_time' => date('Y-m-d',time()),
                'item_description' => $value['item_description']
            ];
            if(!empty($value['small_images']['string'])){
                $array['small_images'] = implode(',',$value['small_images']['string']);
            }
            $edit_data[] = $array;
        }
        dump($edit_data);die;
        $add_result = model('Product')->saveAll($edit_data);
    }

    /**
     * 商品详情 - 20171212
     */
    public function productInfo()
    {
        $c = new TopClient;
        $c->appkey = config('app_key');
        $c->secretKey = config('app_secret');
        $req = new TbkItemInfoGetRequest;
        $req->setFields("num_iid,title,pict_url,small_images,reserve_price,zk_final_price,user_type,provcity,item_url");
        $req->setPlatform("2");
        $req->setNumIids('4789679');
        $resp = $c->execute($req);
        dump($resp);
    }

    /**
     * 推广券信息查询 - 20171212
     */
    public function couponInfo()
    {
//        Q%2BdJoQ8Vii8GQASttHIRqcvPpdHr5hox5p%2FsnQ6uK52m%2FPqYSC%2BIljFcHZCgAl3MhLpkuZmiQvL%2FvPimJwafoEHF3IbQ04hYDfqEFBOhTcztQEe8AbF7aXDGZu1r1ns%2FUqp23J%2BHFUDNzTZuFLB0TmPfrr0N2WBe76NEy%2FtpwjDk92%2BM7h46c6J7%2BkHL3AEW
        $c = new TopClient;
        $c->appkey = config('app_key');
        $c->secretKey = config('app_secret');
        $req = new TbkCouponGetRequest;
        $req->setMe("Q%2BdJoQ8Vii8GQASttHIRqcvPpdHr5hox5p%2FsnQ6uK52m%2FPqYSC%2BIljFcHZCgAl3MhLpkuZmiQvL%2FvPimJwafoEHF3IbQ04hYDfqEFBOhTcztQEe8AbF7aXDGZu1r1ns%2FUqp23J%2BHFUDNzTZuFLB0TmPfrr0N2WBe76NEy%2FtpwjDk92%2BM7h46c6J7%2BkHL3AEW");
        $resp = $c->execute($req);
        dump($resp);
    }

    /**
     * https://uland.taobao.com/coupon/edetail?e=u8zh6ooE0SAGQASttHIRqSFKUfOYNDbQ2JGVEd6AiQPGVWvbOqykrt8hLZYon%2BtemmhfjHgmQpqUTEbqRCoVlqI8dpLrKklGDfqEFBOhTcztQEe8AbF7aXDGZu1r1ns%2FUqp23J%2BHFUDNzTZuFLB0TmPfrr0N2WBe76NEy%2FtpwjDk92%2BM7h46c6J7%2BkHL3AEW&traceId=0ab3102d15131562265433424e
     * 连接转换
    */
    public function zhuanlian()
    {
        $req = new TbkItemConvertRequest;
        $req->setFields("num_iid,click_url");
        $req->setNumIids("544695279467");
        $req->setAdzoneId(config('adzone_id'));
        $req->setUnid("1");
        $req->setDx("1");
        $resp = \think\Loader::controller('common/Aliapi')->requestApi($req);
        dump($resp);
    }
}