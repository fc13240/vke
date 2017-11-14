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
        //查询参与抢购的商品信息
        $goods = [];
        $result = [
            'data' => [
                'goods' => $goods
            ]
        ];
        return resultArray($result);
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