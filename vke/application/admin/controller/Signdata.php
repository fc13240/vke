<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/11/15
 * Time: 13:17
 */

namespace app\admin\controller;
use app\common\controller\Base;
use think\Request;

class Signdata extends Base
{
    /**
     * 月签到数据 - 20171115
     */
    public function monthData()
    {
        //默认为当前月
        $month = Request::instance()->post('month');
        if(empty($month)){
            $month = date('m',time());
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
                $map['sign_time'] = ['between',[$start,$end]];
                $count = model('SignNotes')->getSignCount($map);
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
            $percent = round($value['week_count']/$total_count*100,1);
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