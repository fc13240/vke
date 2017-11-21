<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/11/20
 * Time: 15:40
 */

namespace app\admin\controller;
use app\common\controller\Base;
use think\Request;

class Searchdata extends Base
{
    /**
     * 数据-搜索数据-一周搜索关键词 - 20171120
     */
    public function weekSearchTop10()
    {
        $start = input('post.start');
        $end = input('post.end');
        auto_validate('ShareData',['start'=>$start,'end'=>$end]);
        $list = $this->searchWords($start,$end);
        $result = [
            'data' => [
                'search_list' => $list
            ]
        ];
        return resultArray($result);
    }
    public function searchWords($start,$end)
    {
        $map['create_time'] = ['between',[$start,$end]];
        $list = model('SearchHistory')->getHistory($map,10);
        foreach($list as $key => $value){
            $list[$key]['ratio'] = $value['number']/100;
        }
        return $list;
    }

    /**
     * 搜索数据-当月数据 - 20171120
     */
    public function monthData()
    {
        //根据月份获取每月信息
        //默认为当前月
        $month = Request::instance()->post('month');
        if(empty($month)){
            $month = date('Y-m',time());
        }
        $result = $this->searchData($month);
        return resultArray($result);
    }

    public function searchData($month)
    {
        //获得一个月每周日期
        $month_week = month($month);
        $total_count = 0;
        $value_month = [];
        foreach($month_week as $key => $value){


            $start = reset($value).' 00:00:00';
            $end = end($value).' 23:59:59';
            $map['create_time'] = ['between',[$start,$end]];
            $count = model('SearchHistory')->getSerachCount($map);
            $value_month[] = [
                'week' => $key+1,
                'count' => $count
            ];
            $total_count += $count;
        }

        //计算每周签到数占总数的百分比
        foreach($value_month as $key => $value){
            if(!empty($total_count)){
                $percent = round($value['count']/$total_count*100,1);
            }else{
                $percent = 0;
            }

            $value_month[$key]['percent'] = $percent;
        }
        $result = [
            'data' => [
                'month_list' => $value_month,
                'total_count' => $total_count
            ]
        ];
        return $result;
    }
    /**
     * 搜索关键词-一周搜索关键词导出 - 20171121
     */
    public function weekWordsExport()
    {
       /* $start = input('post.start');
        $end = input('post.end');*/
        $start = '2017-11-12';
        $end = '2017-11-21';
        auto_validate('ShareData',['start'=>$start,'end'=>$end]);
        $list = $this->searchWords($start,$end);
        $name = '搜索关键词'.$start.'-'.$end;
        $title = ['关键词','搜索次数','所占百分比'];
        put_csv($name, $list, $title);
    }

    /**
     * 搜索关键词-整月数据导出 - 20171121
     */
    public function monthDataExport()
    {
        //$month = input('post.month');
        $month = '2017-11';
        if(empty($month)){
            return resultArray(['error'=>'请选择日期']);
        }
        $list = $this->searchData($month)['data']['month_list'];
        $title = ['周数','搜索次数','所占百分比'];
        $name = $month."关键词搜索数据";
        put_csv($name, $list, $title);
    }
}