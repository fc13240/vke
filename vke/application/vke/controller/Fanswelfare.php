<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/10/27 0027
 * Time: 13:36
 */
namespace app\vke\controller;
use app\vke\model\Banner;
use app\vke\controller\Common;
use think\Loader;


class Fanswelfare extends Common
{
    protected $sorts = ['1'=>'asc','2'=>'desc'];
    protected $sortsType;
    protected $type;
    //粉丝福利: 四种排序，粉丝福利顶部banner, 商品
    public function fansWelfare()
    {

        //查询排序类型
        $pro_sorts_type = db('sort')
            ->where(['type_id'=>1,'status'=>1])
            ->order('sorts','desc')
            ->column('id,sort_name');
        //查询排序字段
        $this->sorts_type = db('sort')
            ->where(['type_id'=>1,'status'=>1])
            ->order('sorts','desc')
            ->column('id,field');
        $sorts = 1;
        $type = input('post.sorts_type');
        //接收排序方式
        if($type){
            if($type != $this->type){
                $sorts_type = $type;
            }else{
                $sorts == 1 ? 2 : 1;
            }
        }else{
            $sorts_type = array_keys($pro_sorts_type)[0];
        }
        $this->type = $sorts_type;
        $pro_sorts = $this->sorts;
        //根据条件查询粉丝商品
        $list = db('product')
            ->where('store_type','eq','2')
            ->where('on_sale','eq','1')
            ->order($this->sorts_type[$sorts_type],$pro_sorts[$sorts])
            ->field('id,title,small_images,reserve_price,zk_final_price,volume,fans_acer')
            ->select();

        foreach($list as $key => $value){
            $list[$key]['reserve_price'] = rmb($value['reserve_price']);
            $list[$key]['zk_final_price'] = rmb($value['zk_final_price']);
        }
        $result = [
            'data' => [
                'sorts_type' => $sorts_type,
                'sorts_now' => $pro_sorts[$sorts],
                'goods_list' => $list,
            ]
        ];
        return resultArray($result);
    }

    /**
     * 粉丝福利banner
     */
    public function fansWelfareBanner()
    {
        $banner = model('Banner')->getBannerList(2);
        $result = [
            'data' => [
                'banner' => $banner,
            ]
        ];
        return resultArray($result);
    }

    /**
     * 粉丝福利排序
     * @return array|\think\response\Json
     */
    public function fansWelfareType()
    {
        $sorts = db('sort')
            ->where(['status'=>1,'type_id'=>1])
            ->order('sorts','desc')
            ->field('id,sort_name')
            ->select();
        $result = [
            'data'=>[
                'sorts' => $sorts
            ]
        ];
        return resultArray($result);

    }

    /**
     * 超值线报-banner
     * @return array|\think\response\Json
     */
    public function newsPaperBanner()
    {
        //banner
        $banner = model('banner')->getBannerList(3);
        $result = [
            'data' => [
                'banner' => $banner
            ]
        ];
        return resultArray($result);
    }

    /**
     * 超值线报-商品
     * @return array|\think\response\Json
     */
    public function newsPaperGoods()
    {

        //抢购时间id
        $panic_id = input('post.panic_id');
        if(empty($panic_id)){
            return resultArray(['error'=>'请选择抢购时间']);
        }

        $key = 'panic_id'.$panic_id;
        $data = cache($key);
        if(empty($data)){
            //根据抢购时间id查询时间段
            $panic_time = model('PanicTime')->getTime($panic_id);
            $start_time = date('Y-m-d',time()).' '.$panic_time['start_time'];
            $end_time = date('Y-m-d',time()).' '.$panic_time['end_time'];
            $data = $this->getApiData($start_time,$end_time);
            cache($key,$data,7200);
        }

        $result = [
            'data' => [
                'goods' => $data
            ]
        ];
        return resultArray($result);
    }

    public function getApiData($start_time,$end_time)
    {
        //查询参与抢购的商品信息
        Loader::import('sdk.request.TbkJuTqgGetRequest');
        Loader::import('sdk.TopClient');
        $c = new \TopClient;
        $c->appkey = config('appkey');
        $c->secretKey = config('secret');
        $req = new \TbkJuTqgGetRequest;
        $req->setAdzoneId(config('adzone_id'));
        $req->setFields("click_url,pic_url,reserve_price,zk_final_price,total_amount,sold_num,title,category_name,start_time,end_time");
        $req->setStartTime($start_time);
        $req->setEndTime($end_time);
        $req->setPageNo("1");
        $req->setPageSize("40");
        $resp = $c->execute($req);
        return (array)$resp->results->results;
    }

    //超值线报
    public function newsPaper()
    {
        //查询抢购时间
        $time = model('PanicTime')->getPanicTime();

        //判断抢购时间是否已经开启或者结束 status 1未开始 2已经开始 3已经结束
        $nowTime = date('H:i',time());
        foreach($time as $key => $value){
            if($value['start_time'] > $nowTime){ //1
                $time[$key]['status'] = 1;
                $time[$key]['active'] = 0;
            }elseif($value['start_time'] <= $nowTime && $nowTime <= $value['end_time']){ //2
                $time[$key]['status'] = 2;
                $time[$key]['active'] = 1;
            }else{ //3
                $time[$key]['status'] = 3;
                $time[$key]['active'] = 0;
            }
        }

        $result = [
            'data' => [
                'time' => $time
            ]
        ];
        return resultArray($result);
    }
}