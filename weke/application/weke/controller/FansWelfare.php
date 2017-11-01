<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/10/27 0027
 * Time: 13:36
 */
namespace app\weke\controller;
use app\weke\model\Banner;
class FansWelfare
{
    protected $sorts = ['1'=>'asc','2'=>'desc'];
    protected $sortsType = ['1'=>'after_price','2'=>'saled_number','3'=>'acer_member','4'=>'add_time'];
    protected $type;
    //粉丝福利: 四种排序，粉丝福利顶部banner, 商品
    public function fansWelfare()
    {
        $banner = model('Banner')->getBannerList(2);
//        $banner = model('banner')
//            ->where('type_id','eq','2')
//            ->where('status','eq','1')
//            ->order('sorts','desc')
//            ->select();
        $sorts = 1;
        $type = input('sorts_type');
        //接收排序方式
        if($type){
            if($type != $this->type){
                $sorts_type = $type;
            }else{
                $sorts == 1 ? 2 : 1;
            }
        }else{
            $sorts_type = 1;
        }
        $this->type = $sorts_type;

        $pro_sorts = $this->sorts;
        $pro_sorts_type = $this->sortsType;
        //根据条件查询粉丝商品
        $list = db('other_product')
            ->where('type','eq','2')
            ->where('status','eq','1')
            ->order($pro_sorts_type[$sorts_type],$pro_sorts[$sorts])
            ->select();
        return [
            'status' => '1',
            'message' => '请求成功',
            'data' =>[
                'banner' => $banner,
                'goods_list' => $list,
                'sorts' => ['1'=>'价格排序','2'=>'销量排序','3'=>'积分排序','4'=>'时间排序']
            ]
        ];
    }


    //超值线报
    public function newsPaper()
    {
        //banner
        $banner = model('banner')->getBannerList(3);

        //查询抢购时间
        $time = model('PanicTime')->getPanicTime();

        //判断抢购时间是否已经开启或者结束 status 1未开始 2已经开始 3已经结束
        $nowTime = date('Y-m-d H:i:s',time());
        foreach($time as $key => $value){
            if($value['start_time'] > $nowTime){ //1
                $time[$key]['status'] = 1;
            }elseif($value['start_time'] <= $nowTime && $nowTime <= $value['end_time']){ //2
                $time[$key]['status'] = 2;
            }else{ //3
                $time[$key]['status'] = 3;
            }
        }
        //查询参与抢购的商品信息
        $goods = [];
        return [
            'status' => '1',
            'message' => '请求成功',
            'data' => [
                'banner' =>  $banner,
                'time' => $time,
                'goods' => $goods
            ]
        ];
    }
}