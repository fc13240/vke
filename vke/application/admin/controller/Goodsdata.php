<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/11/16
 * Time: 10:00
 */

namespace app\admin\controller;
use app\common\controller\Base;
use think\Request;

class Goodsdata extends Base
{
    /**
     * 每月浏览次数前十的商品分类 - 20171116
     */
    public function productTypeData()
    {
        //接收年月
        $month = Request::instance()->post('month');
        if(empty($month)){
            $month = date('Y-m');
        }
        $month_date = getMonth($month);
        //查询这期间所有商品的浏览记录,找出前十名的类别
        $map['time'] = ['between',[$month_date['start'],$month_date['end']]];
        $topType = model('MemberFootprint')->getType($map);

        //排序
        $sortType = wpjam_array_multisort($topType,'total_number');
        foreach($topType as $key => $value){
            $topType[$key]['total_number'] = $value['total_number']/100;
        }
        $result = [
            'data' => [
                'type_data' =>  $topType,
                'more_data' => $sortType
            ]
        ];
        return resultArray($result);
    }

    /**
     * 商品调取量 - 20171116(查询日期区间内的商品浏览统计前十名)
     */
    public function productData()
    {
        //接收日期区间
        $startDate = Request::instance()->post('start');
        $endDate = Request::instance()->post('end');
        auto_validate('ShareData',['start'=>$startDate,'end'=>$endDate],'select');
        //查询该日期内商品的浏览次数top10
        $map['time'] = ['between',[$startDate,$endDate]];
        $list = model('MemberFootprint')->getProduct($map,10);
        $total_count = 0;
        foreach($list as $key => $value){
            $total_count += $value['number'];
        }
        foreach($list as $key => $value){
            $list[$key]['percent'] = round($value['number']/$total_count,1);
        }
        $result = [
            'data' => [
                'list' => $list,
                'total_number' => $total_count
            ]
        ];
        return resultArray($result);
    }
}