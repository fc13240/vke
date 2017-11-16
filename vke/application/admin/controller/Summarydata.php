<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/11/16
 * Time: 13:07
 */

namespace app\admin\controller;
use app\common\controller\Base;
use think\Request;

class Summarydata extends Base
{
    /**
     * 首页-总数据-访问数据 - 20171116
     */
    public function visitData()
    {
        //接收时间
        $date_type = Request::instance()->get('date_type');
        if(empty($date_type)){
            return resultArray(['error'=>'请选择查看时间']);
        }
        switch ($date_type){
            case 1:
                $login_arr = $this->yesterdayLogin();
                break;
            case 2:
                $login_arr = $this->weekLogin();
                break;
            case 3:
                $login_arr = $this->monthLogin();
                break;
        }
        $result = [
            'data'=>[
                'login_list' => $login_arr
            ]
        ];
        return resultArray($result);
    }

    /**
     * 昨日登录人数 - 20171116
     */
    protected function yesterdayLogin()
    {
        $date = date('Y-m-d',strtotime('-1 days'));
        for($i=2;$i<=22;$i+=2){
            $startDate = $date.' '.$i.':00:00';
            $endDate = $date.' '.($i+1).':59:59';
            //查询这期间登录过的人数
            $map['last_login_time'] = ['between',[$startDate,$endDate]];
            $count = model('Member')->getLoginCount($map);
            $login_arr[] = [
                'time' => $i,
                'count' => $count
            ];
        }
        return $login_arr;
    }

    /**
     * 本周登录人数情况 - 20171116
     */
    public function weekLogin()
    {
        //获取本周日期
        $week =  getWeekTime();
        foreach($week as $key => $value){
            //查询每天的登录人数
            $map['last_login_time'] = ['between',[$value['start'],$value['end']]];
            $count = model('Member')->getLoginCount($map);
            $login_arr[] = [
                'time' => $value['week'] == 0 ? 7 : $value['week'],
                'count' => $count
            ];
        }
        return $login_arr;
    }

    /**
     * 本月登录人数情况 - 20171116
     */
    public function monthLogin()
    {
        $month = date('Y-m');
        $month_week = month($month);
        foreach($month_week as $key => $value){
            $startDate = reset($value).' 00:00:00';
            $endDate = end($value).' 23:59:59';
            $map['last_login_time'] = ['between',[$startDate,$endDate]];
            $count = model('Member')->getLoginCount($map);
            $login_arr[] = [
                'time' => $key+1,
                'count' => $count
            ];
        }
        return $login_arr;
    }

    /**
     * 热门商品top30 - 20171116
     */
    public function productTop30()
    {
        //查询点击次数醉的的30名
        $list = model('MemberFootprint')->getProduct('',30);
        $result = [
            'data' => [
                'product_list' => $list
            ]
        ];
        return resultArray($result);
    }

    /**
     * 新增用户top20 - 20171116
     */
    public function newMemberTop20()
    {
        //查询新增的20位用户
        $member_list = model('Member')->getNewMember();
        foreach($member_list as $key => $value){
            $member_list[$key]['create_time'] = substr($value['create_time'],0,10);
        }
        $result = [
            'data' => [
                'member_list' => $member_list
            ]
        ];
        return resultArray($result);
    }

    /**
     * 热搜词top20 - 20171116
     */
    public function hotWordsTop20()
    {
        $words_list = model('SearchHistory')->getHotWords();
        $result = [
            'data' => [
                'words_list' => $words_list
            ]
        ];
        return resultArray($result);
    }

}