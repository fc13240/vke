<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/11/15
 * Time: 16:33
 */

namespace app\admin\controller;
use app\common\controller\Base;
use think\Request;

class Sharedata extends Base
{
    /**
     * 一周晒单数据 - 20171115
     */
    public function shareData()
    {
        //接收开始日期和结束日期
        $start_day = Request::instance()->post('start');
        $end_day = Request::instance()->post('end');
        auto_validate('ShareData',['start'=>$start_day,'end'=>$end_day],'select');
        //根据开始结束日期,查询这期间每天的晒单情况
        $dateArray = getDateFromRange($start_day,$end_day);
        $map['examine_status'] = 1;
        //dump($dateArray);
        $detail_data = [];
        //晒单个数
        foreach($dateArray as $key => $value){
            $start = $value['date'].' 00:00:00';
            $end = $value['date'].' 23:59:59';
            $map['create_time'] = ['between',[$start,$end]];
            $map['examine_status'] = 1;
            $count = model('MemberEvaluate')->getEvaluateCount($map);
            $dateArray[$key]['count'] = $count/100;
            $detail_data[] = [
                'week' => $value['week'],
                'count' => $count
            ];
        }
        $detail = wpjam_array_multisort($detail_data,'count');
        $result = [
            'data' => [
                'week_data' => $dateArray,
                'detail' => $detail
            ]
        ];
        return resultArray($result);
    }

    /**
     * 晒单数据-日期 - 20171115
     */
    public function date()
    {
        $year = [];
        //查询当年所有月份的星期情况
        for($i = 1; $i <= 12; $i++){
            $date = date('Y-m',time());
            $month = month($date);
            foreach($month as $key => $value){
                $week = [
                    'start' => reset($value),
                    'end' => end($value)
                ];
                $month[$key] = $week;
            }
            $year[] = $month;
        }
        $result = [
            'data' => [
                'date' => $year
            ]
        ];

        return resultArray($result);
    }

    /**
     * 晒单数据-当月数据 - 20171116
     */
    public function monthData()
    {
        //根据月份获取每月信息
        //默认为当前月
        $month = Request::instance()->post('month');
        if(empty($month)){
            $month = date('Y-m',time());
        }
        //获得一个月每周日期
        $month_week = month($month);
        $month_new = [];
        $total_count = 0;
        foreach($month_week as $key => $value){
            $value_month = [];
            $week_count = 0;
            //查询每天的签到数量
            foreach($value as $k => $v){
                $start = $v.' 00:00:00';
                $end = $v.' 23:59:59';
                $map['create_time'] = ['between',[$start,$end]];
                $count = model('MemberEvaluate')->getEvaluateCount($map);
                $value_day = [
                    'week' => $k,
                    'time' => $v,
                    'count' =>$count
                ];
                $week_count += $count;
                $value_month['week_list'][] = $value_day;
                $value_month['week_count'] = $week_count;
                $month_new[$key] = $value_month;
            }
            $total_count += $week_count;
        }

        //计算每周签到数占总数的百分比
        foreach($month_new as $key => $value){
           if(!empty($total_count)){
               $percent = round($value['week_count']/$total_count*100,1);
           }else{
               $percent = 0;
           }

            $month_new[$key]['week_percent'] = $percent;
        }
        $result = [
            'data' => [
                'month_list' => $month_new,
                'total_count' => $total_count
            ]
        ];
        return resultArray($result);
    }
}