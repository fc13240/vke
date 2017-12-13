<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/12/6
 * Time: 13:15
 */

namespace app\admin\controller;
use \think\Request;
use \think\Db;
use app\common\controller\Base;


class Memberdata extends Base
{
    /**
     * 数据-用户数据-新增用户 - 20171206
     */
    public function newInsertMember()
    {
        $start = Request::instance()->post('start');
        $end = Request::instance()->post('end');
        if(empty($start) || empty($end)){
            $end = date('Y-m-d',time());
            $start = date('Y-m-d',time()-7*86400);
        }
        auto_validate('ShareData',['start'=>$start,'end'=>$end],'select');

        $time_arr = [];
        $count_arr = [];
        //查询日期内新增用户数量
        $date = getDateFromRange($start,$end);
        foreach($date as $key => $value){
            $start_date = $value['date'].' 00:00:00';
            $end_date = $value['date'].' 23:59:59';
            $map = [
                'create_time' => ['between',[$start_date,$end_date]]
            ];
            $count = model('Member')->getNewCount($map);
            $time_arr[] = $value['date'];
            $count_arr[] = (string)$count;
        }

        $result = [
            'data' => [
                'date' => $time_arr,
                'count' => $count_arr,
                'start' => $start,
                'end' => $end
            ]
        ];
        return resultArray($result);
    }

    /**
     * 进入元宝商城未下单用户 - 20171206
     */

    public function vistorPercent()
    {
        //TODO:目前是进入元宝商城未下单用户,应加入进入系统未领券用户
        $start = Request::instance()->post('start');
        $end = Request::instance()->post('end');
        if(empty($start) || empty($end)){
            $start = date('Y-m-d',time()-6*86400);
            $end = date('Y-m-d',time());
        }
        auto_validate('ShareData',['start'=>$start,'end'=>$end],'select');
        $time_arr = [];
        $percent_arr = [];
        //查询日期内新增用户数量
        $date = getDateFromRange($start,$end);
        foreach($date as $key => $value){
            $start_date = $value['date'].' 00:00:00';
            $end_date = $value['date'].' 23:59:59';
            $map = [
                'last_login_time' => ['between',[$start_date,$end_date]]
            ];
            $login_count = model('Member')->getLoginCount($map);
            //下单用户人数
            $map_order = [
                'exchange_time' => ['between',[$start_date,$end_date]]
            ];
            $order_count = count(model('ExchangeOrder')->getSuccessPerson($map_order));
            if($login_count == 0){
                $percent = '0';
            }else{
                $percent = (string)((($login_count-$order_count)/$login_count)*100);
            }

            $time_arr[] = $value['date'];
            $percent_arr[] = $percent;
        }
        $result = [
            'data' => [
                'time' => $time_arr,
                'percent' => $percent_arr,
                'start' => $start,
                'end' => $end
            ]
        ];
        return resultArray($result);
    }

}