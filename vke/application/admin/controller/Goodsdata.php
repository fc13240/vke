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
        $sortType = $this->searchData1($month);
        $result = [
            'data' => [
                'more_data' => $sortType
            ]
        ];
        return resultArray($result);
    }

    public function searchData1($month)
    {
        $month_date = getMonth($month);
        //查询这期间所有商品的浏览记录,找出前十名的类别
        $map['time'] = ['between',[$month_date['start'],$month_date['end']]];
        $topType = model('MemberFootprint')->getType($map);

        //排序
        $sortType = wpjam_array_multisort($topType,'total_number');
        return $sortType;
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
        $result = $this->searchData2($startDate,$endDate);
        return resultArray($result);
    }

    public function searchData2($startDate,$endDate)
    {
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
        return $result;
    }

    /**
     *商品浏览量统计导出 - 20171122
     */
    public function export1()
    {
        //接收年月
        $month = Request::instance()->post('month');
        if(empty($month)){
            $month = date('Y-m');
        }
        $list = $this->searchData1($month);
        $title = ['id','商品名称','浏览次数'];
        $name = $month.'商品浏览次数统计';
        put_csv($name, $list, $title);
    }

    /**
     * 商品调取量数据导出 - 20171122
     */
    public function export2()
    {
        //接收日期区间
        $startDate = Request::instance()->get('start');
        $endDate = Request::instance()->get('end');
        auto_validate('ShareData',['start'=>$startDate,'end'=>$endDate],'select');
        $result = $this->searchData2($startDate,$endDate);
        $list = $result['data']['list'];
        $name = '商品调取量数据导出'.$startDate.'至'.$endDate;
        $title = ['商品id','商品图片','商品标题','调取次数','所占百分比'];
        put_csv($name, $list, $title);
    }
}