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
     * 晒单数据 - 20171115
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
        dump($dateArray);
        //晒单个数
        foreach($dateArray as $key => $value){

        }


//        $map['create_time'] = ['between',[$value['start'],$value['end']]];
//        $count = model('MemberEvaluate')->getEvaluateCount($map);
//        dump($count);
    }

    /**
     * 晒单数据-日期 - 20171115
     */
    public function date()
    {
        $year = [];
        //查询当年所有月份的星期情况
        for($i = 1; $i <= 12; $i++){
            $month = month(2);
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
}