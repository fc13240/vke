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
     * 签到数据-本年日期 - 20171116
     */
    public function getData(){
        $year_month = getYearMonth();
        $result = [
            'data' => [
                'year_month' => $year_month
            ]
        ];
        return resultArray($result);
    }

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

        $week_count_arr = [];
        foreach($month_week as $key => $value){
            $value_month = [];
            $week_count = 0;
            //查询每天的签到数量
            foreach($value as $k => $v){
                $start = $v.' 00:00:00';
                $end = $v.' 23:59:59';
                $map['sign_time'] = ['between',[$start,$end]];
                $count = model('SignNotes')->getSignCount($map);
                $value_day = (string)$count;
//                $value_day = [
//                    'week' => $k,
//                    'time' => $v,
//                    'count' =>$count
//                ];
                $week_count += $count;
                $value_month['week_list'][] = $value_day;
                $value_month['week_count'] = (string)$week_count;
                $month_new['week'.$key] = $value_month;
            }

            switch($key){
                case 0:
                    $name = '第一周';
                    break;
                case 1:
                    $name = '第二周';
                    break;
                case 2:
                    $name = '第三周';
                    break;
                case 3:
                    $name = '第四周';
                    break;
                case 4:
                    $name = '第五周';
                    break;
            }
            $week_count_arr[] = [
                'value' => (string)$week_count,
                'name' => $name
            ];

            $total_count += $week_count;
        }

        //计算每周签到数占总数的百分比
        $monday = 0;
        $tuesday = 0;
        $wednesday = 0;
        $thursday = 0;
        $friday = 0;
        $saturday = 0;
        $sunday = 0;
        foreach($month_new as $key => $value){
            if(!empty($total_count)){
                $percent = round($value['week_count']/$total_count*100,1);
            }else{
                $percent = 0;
            }
            $month_new[$key]['week_percent'] = $percent;

            if(count($value['week_list']) < 7){
                $num = 7-count($value['week_list']);
                for($i=0; $i<$num; $i++){
                    //$month_new[$key]['week_list'][] = 0;
                    array_unshift($month_new[$key]['week_list'],'0');
                }
            }

            //计算每天总数
            foreach($value['week_list'] as $k => $v){
                switch($k){
                    case 0:
                        $monday += $v;
                        break;
                    case 1:
                        $tuesday += $v;
                        break;
                    case 2:
                        $wednesday += $v;
                        break;
                    case 3:
                        $thursday += $v;
                        break;
                    case 4:
                        $friday += $v;
                        break;
                    case 5:
                        $saturday += $v;
                        break;
                    case 6:
                        $sunday += $v;
                        break;

                }
            }
        }

        $week_total = [
            (string)$monday,
            (string)$tuesday,
            (string)$wednesday,
            (string)$thursday,
            (string)$friday,
            (string)$saturday,
            (string)$sunday,
        ];
        $result = [
            'data' => [
                'month_list' => $month_new,
                'week_total' => $week_total,
                'week_count_arr' => $week_count_arr,
                'total_count' => $total_count
            ]
        ];
        return resultArray($result);
    }

    public function export()
    {
        //默认为当前月
        $month = Request::instance()->post('month');
        if(empty($month)){
            $month = date('Y-m',time());
        }
        $month = "2017-11";
        //获得一个月每周日期
        $month_week = month($month);
        foreach($month_week as $key => $value){
            $value_month = [];
            foreach($value as $k => $v){
                $start = $v.' 00:00:00';
                $end = $v.' 23:59:59';
                $map['sign_time'] = ['between',[$start,$end]];
                $count = model('SignNotes')->getSignCount($map);
                $value_day = (string)$count;
                $value_month[$k] = $value_day;
            }
            $month_new[$key+1] = $value_month;
        }
        $name = '签到数据-'.$month;
        $title = "周数,星期一,星期二,星期三,星期四,星期五,星期六,星期日";
        put_csv($name, $month_new, $title);
    }
}