<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/12/12
 * Time: 15:39
 */

namespace app\vke\controller;
use think\Request;
use think\Db;
use app\vke\controller\Common;
use \traits\sdk\top\request\TbkTpwdCreateRequest;
use \traits\sdk\top\TopClient;
use \traits\sdk\top\request\TbkJuTqgGetRequest;
use \traits\sdk\top\request\TbkUatmEventGetRequest;
use \traits\sdk\top\request\JuItemsSearchRequest;
use \traits\sdk\top\domain\TopItemQuery;
use \traits\sdk\top\request\TbkSpreadGetRequest;
use \traits\sdk\top\domain\TbkSpreadRequest;
use \traits\sdk\top\request\TbkDgItemCouponGetRequest;

class Sdkproduct extends Common
{
    /**
     *超值线报
     */
    public  function overflowCoupon()
    {
        $time_id = Request::instance()->get('panic_id');
        $time = Request::instance()->get('time');

        if(empty($time_id) || empty($time)){
            return resultArray(['error'=>'参数错误']);
        }

        if($time_id == 1){
            $start = $time_id;
            $end = $start + 12;
        }else{
            $start = $time_id + 12;
            $end = $start+12;
        }

        $tao = cache($time_id.$time);
        if(empty($tao)){
            $tao = [];
            $adzone_id = config('adzone_id');
            $req = new TbkDgItemCouponGetRequest;
            $req->setAdzoneId($adzone_id);
            $req->setPlatform("2");
            $req->setPageSize("100");
            for($i=$start; $i<=$end; $i++){
                $req->setPageNo($i);
                $controller = \think\Loader::controller('common/aliapi');
                $resp = $controller->requestApi($req);
                $tao = array_merge($tao,$this->createTao($resp));
            }
            cache($time_id.$time,$tao,1800);
        }

        $result = [
            'data' => [
                'goods_list' => $tao
            ]
        ];
        return resultArray($result);
    }

    /**
     * 将符合条件的商品放入数组 - 20171213
     * @param $resp
     * @return array
     */
    protected function createTao($resp)
    {
        $tomorrow = date('Y-m-d',time() + 86400);
        foreach ($resp['results']['tbk_coupon'] as $key => $value){
            $coupon_amount = 0;
            if(!empty($value['coupon_info'])){
                $str = $value['coupon_info'];
                $isMatch = preg_match('/\d*元$/', $str, $matches);
                $coupon_amount = (int)$matches[0];
            }
            if($value['coupon_end_time'] <= $tomorrow && $coupon_amount>=20){
                //剩余时间
                $have_time = strtotime($value['coupon_end_time'].' 23:59:59')-time();

                $list = [
                    'num_iid' => $value['num_iid'],
                    'title' => $value['title'],
                    'pict_url' => $value['pict_url'],
                    'coupon_number' => $coupon_amount,
                    'volume' => $value['volume'],
                    'zk_final_price' => $value['zk_final_price'],
                    'reserve_price' => $coupon_amount + $value['zk_final_price'],
                    'click_url' => $value['coupon_click_url'],
                    'stock' => $value['coupon_remain_count'],
                    'surplus' => $this->changeTimeType($have_time)
                ];
                if(!empty($value['small_images'])){
                    $list['small_images'] = explode(',',$value['small_images']);
                }
                $tao[] = $list;
            }
        }
        return $tao;
    }

    /**
     * 计算剩余时间 - 20171213
     */
    protected function changeTimeType($seconds)
    {
            if ($seconds > 3600){
                $hours = intval($seconds/3600);
                $minutes = $seconds % 3600;
                $time = $hours.":".gmstrftime('%M:%S', $minutes);
            }else{
                $time = gmstrftime('%H:%M:%S', $seconds);
            }
            return $time;
    }




    /**
     * 商品关联查询 (猜你喜欢) - 20171212
     */
    public function relevance()
    {
        //接收商品类型
        $product_type = Request::instance()->post('product_type');
       /* if(empty($product_type)){
            return resultArray(['error'=>'参数错误']);
        }*/
       if(empty($product_type)){
           $product_type = 1;
       }

        $relevance = cache($product_type.date('Y-m-d'));
        if(empty($goods_list)){
            //查询该分类下商品
            $relevance = model('Product')->getRelevance($product_type);
            if(empty($relevance)){
                $relevance = [];
            }
            cache($product_type.date('Y-m-d'),$relevance,1800);
        }

        $result = [
            'data' => [
                'goodsList' => $relevance
            ]
        ];

        return resultArray($result);
    }

    /**
     * 生成淘口令 - 20171212
     */
    public function createCommand()
    {
        $goods_id = Request::instance()->post('goods_id');
        if(empty($goods_id) || !is_numeric($goods_id)){
            return resultArray(['error'=>'参数错误']);
        }
        //根据商品id查询商品标题,商品跳转连接
        $fields = 'title,click_url,num_iid,pict_url';
        $goods_info = model('Product')->getProductInfo($goods_id,$fields);

        //购买用户id
        $user_id = $this->user_id;
        $command = cache($goods_id.$goods_info['num_iid']);
        if(empty($command)){
            //调取淘口令接口
            $c = new TopClient;
            $c->appkey = config('app_key_ali');
            $c->secretKey = config('app_secret_ali');
            $req = new TbkTpwdCreateRequest;
            $req->setUserId($user_id);
            $req->setText($goods_info['title']);
            $req->setUrl($goods_info['click_url']);
            $req->setLogo($goods_info['pict_url']);
            $req->setExt("{}");
            $resp = $c->execute($req);
            $command = $resp['data']['model'];
            cache($goods_id.$goods_info['num_iid'],$resp['data']['model'],86400);
        }
        $result = [
            'data' => [
                'command' => $command
            ]
        ];
        return resultArray($result);
    }
/****************************************************************************************************/

    /**
     * 超值线报抢购api - 20171212
     */
    public function robApi()
    {

        $c = new TopClient;
        $c->appkey = config('app_key_ali');
        $c->secretKey = config('app_secret_ali');
        $req = new TbkJuTqgGetRequest;
        $req->setAdzoneId(config('adzone_id'));
        $req->setFields("click_url,pic_url,reserve_price,zk_final_price,total_amount,sold_num,title,category_name,start_time,end_time");
        $req->setStartTime("2017-12-13 09:12:00");
        $req->setEndTime("2017-12-13 15:36:00");
        $req->setPageNo("1");
        $req->setPageSize("40");
        $resp = $c->execute($req);
        dump($resp);
    }

    /**
     * 聚划算 - 20171213
     */
    public function discount()
    {
        $c = new TopClient;
        $c->appkey = config('app_key_ali');
        $c->secretKey = config('app_secret_ali');
        $req = new JuItemsSearchRequest;
        $param_top_item_query = new TopItemQuery;
        $param_top_item_query->current_page="1";
        $param_top_item_query->page_size="20";
        $param_top_item_query->pid="-";
        $param_top_item_query->postage="true";
        $param_top_item_query->status="2";
        //$param_top_item_query->taobao_category_id="1000";
        //$param_top_item_query->word="test";
        $req->setParamTopItemQuery(json_encode($param_top_item_query));
        $resp = $c->execute($req);
        dump($resp);
    }

    /**
     * 生成淘口令 - 20171213
     */
    public function testCommand()
    {
        //调取淘口令接口
        $c = new TopClient;
        $c->appkey = config('app_key_ali');
        $c->secretKey = config('app_secret_ali');
        $req = new TbkTpwdCreateRequest;
        //$req->setUserId($user_id);
        $req->setText('测试测试测试');
        $req->setUrl('https://s.click.taobao.com/t?e=m%3D2%26s%3D7jXJIvXqsoocQipKwQzePOeEDrYVVa64yK8Cckff7TVRAdhuF14FMXFbLxPUnM3HMMgx22UI05YSXYVSpmS1cS%2Fm194kEvbspPGjAeLE6%2Fyu4%2ByOxprBcYtgwMO1YqTJ4q%2BRXokHRqv%2F41rxmOzgOWbaJg9MOq%2BFEehMnmO5y6MYa7xmPBoNygQ1iwMPqCWVpPbo0lJ%2FyK6cBnQj1r%2B3uQ%3D%3D');
        //$req->setLogo($goods_info['pict_url']);
        $req->setExt("{}");
        $resp = $c->execute($req);
        dump($resp);
    }

    /**
     * 转链 - 20171213
     */
    public function testTurn()
    {
        $c = new TopClient;
        $c->appkey = config('app_key_ali');
        $c->secretKey = config('app_secret_ali');
        $req = new TbkSpreadGetRequest;
        $requests = new TbkSpreadRequest;
        $requests->url="//detail.ju.taobao.com/home.htm?id=10000065908226&item_id=531265376538";
        $req->setRequests(json_encode($requests));
        $resp = $c->execute($req);
        dump($resp);
    }
}