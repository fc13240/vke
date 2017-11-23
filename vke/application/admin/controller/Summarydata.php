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
        for($i=0;$i<=22;$i+=2){
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

    /**
     *用户数据(新增人数) - 20171122
     */
    public function memberData()
    {
        $data_type = input('post.type');
        if(empty($data_type)){
            return resultArray(['error'=>'请选择查看时间']);
        }
        switch($data_type){
            case 1:
                $data = $this->yesterdayMember();
                break;
            case 2:
                $data = $this->weekMember();
                break;
            case 3:
                $data = $this->monthMember();
                break;
        }
        $result = [
            'data' => $data
        ];
        return resultArray($result);
    }
    /**
     * 用户新增数据-昨日数据 - 20171122
     */
    public function yesterdayMember()
    {
        $date = date('Y-m-d',strtotime('-1 days'));
        for($i=0;$i<=22;$i+=2){
            $startDate = $date.' '.$i.':00:00';
            $endDate = $date.' '.($i+1).':59:59';
            //查询这期间新增人数
            $map['create_time'] = ['between',[$startDate,$endDate]];
            $count = model('Member')->getLoginCount($map);
            $login_arr[] = [
                'time' => $i,
                'count' => $count
            ];
        }
        return $login_arr;
    }

    /**
     * 用户新增数据-周数据 - 20171122
     */
    public function weekMember()
    {
        //获取本周日期
        $week =  getWeekTime();
        foreach($week as $key => $value){
            //查询每天的登录人数
            $map['create_time'] = ['between',[$value['start'],$value['end']]];
            $count = model('Member')->getLoginCount($map);
            $login_arr[] = [
                'time' => $value['week'] == 0 ? 7 : $value['week'],
                'count' => $count
            ];
        }
        return $login_arr;
    }

    /**
     *用户新增数据-月数据 - 20171122
     */
    public function monthMember()
    {
        $month = date('Y-m');
        $month_week = month($month);
        foreach($month_week as $key => $value){
            $startDate = reset($value).' 00:00:00';
            $endDate = end($value).' 23:59:59';
            $map['create_time'] = ['between',[$startDate,$endDate]];
            $count = model('Member')->getLoginCount($map);
            $login_arr[] = [
                'time' => $key+1,
                'count' => $count
            ];
        }
        return $login_arr;
    }

    /**
     * 搜索数据(搜索词) - 20171122
     */
    public function searchData()
    {
        $data_type = input('post.type');
        if(empty($data_type)){
            return resultArray(['error'=>'请选择查看时间']);
        }
        switch($data_type){
            case 1:
                $data = $this->yesterdaySearch();
                break;
            case 2:
                $data = $this->weekSearch();
                break;
            case 3:
                $data = $this->monthSearch();
                break;
        }
        $result = [
            'data' => $data
        ];
        return resultArray($result);
    }

    /**
     *搜索数据-昨日数据 - 20171122
     */
    public function yesterdaySearch()
    {
        $date = date('Y-m-d',strtotime('-1 days'));
        for($i=0;$i<=22;$i+=2){
            $startDate = $date.' '.$i.':00:00';
            $endDate = $date.' '.($i+1).':59:59';
            //查询这期间新增人数
            $map['create_time'] = ['between',[$startDate,$endDate]];
            $count = model('SearchHistory')->getSerachCount($map);
            $login_arr[] = [
                'time' => $i,
                'count' => $count
            ];
        }
        return $login_arr;
    }

    /**
     * 搜索数据-周数据 - 20171122
     */
    public function weekSearch()
    {
        //获取本周日期
        $week =  getWeekTime();
        foreach($week as $key => $value){
            //查询每天的登录人数
            $map['create_time'] = ['between',[$value['start'],$value['end']]];
            $count = model('SearchHistory')->getSerachCount($map);
            $login_arr[] = [
                'time' => $value['week'] == 0 ? 7 : $value['week'],
                'count' => $count
            ];
        }
        return $login_arr;
    }

    /**
     *搜索数据-月数据 - 20171122
     */
    public function monthSearch()
    {
        $month = date('Y-m');
        $month_week = month($month);
        foreach($month_week as $key => $value){
            $startDate = reset($value).' 00:00:00';
            $endDate = end($value).' 23:59:59';
            $map['create_time'] = ['between',[$startDate,$endDate]];
            $count = model('SearchHistory')->getSerachCount($map);
            $login_arr[] = [
                'time' => $key+1,
                'count' => $count
            ];
        }
        return $login_arr;
    }

    /**
     * 元宝消耗(赠送元宝数)
     */
    public function acerData()
    {
        $data_type = input('post.type');
        if(empty($data_type)){
            return resultArray(['error'=>'请选择查看日期']);
        }
        switch($data_type){
            case 1:
                $data = $this->yesterdayAcer();
                break;
            case 2:
                $data = $this->weekAcer();
                break;
            case 3:
                $data = $this->monthAcer();
                break;
        }
        $result = [
            'data' => $data
        ];
        return resultArray($result);
    }

    /**
     * 元宝消耗-昨日数据 - 20171122
     */
    public function yesterdayAcer()
    {
        $date = date('Y-m-d',strtotime('-1 days'));
        for($i=0;$i<=22;$i+=2){
            $startDate = $date.' '.$i.':00:00';
            $endDate = $date.' '.($i+1).':59:59';
            //查询这期间新增人数
            $map['add_time'] = ['between',[$startDate,$endDate]];
            $count = model('AcerNotes')->getAcerNumber($map);
            $login_arr[] = [
                'time' => $i,
                'count' => $count
            ];
        }
        return $login_arr;
    }

    /**
     * 搜索数据-周数据 - 20171122
     */
    public function weekAcer()
    {
        //获取本周日期
        $week =  getWeekTime();
        foreach($week as $key => $value){
            //查询每天的登录人数
            $map['add_time'] = ['between',[$value['start'],$value['end']]];
            $count = model('AcerNotes')->getAcerNumber($map);
            $login_arr[] = [
                'time' => $value['week'] == 0 ? 7 : $value['week'],
                'count' => $count
            ];
        }
        return $login_arr;
    }

    /**
     *搜索数据-月数据 - 20171122
     */
    public function monthAcer()
    {
        $month = date('Y-m');
        $month_week = month($month);
        foreach($month_week as $key => $value){
            $startDate = reset($value).' 00:00:00';
            $endDate = end($value).' 23:59:59';
            $map['add_time'] = ['between',[$startDate,$endDate]];
            $count = model('AcerNotes')->getAcerNumber($map);
            $login_arr[] = [
                'time' => $key+1,
                'count' => $count
            ];
        }
        return $login_arr;
    }


    /**
     * 数据导出 - 20171122
     */
    public function export()
    {
        $data_type = input('get.type');
        $data_arr = explode('_',$data_type);
        if(empty($data_type) || count($data_arr) < 2){
            return resultArray(['error'=>'请选择导出数据类型']);
        }
        $action = '';
        //根据类型获取数据

        $name = '首页-';
        switch($data_arr[1]){
            case 1:
                $action .= 'yesterday';
                $name .= '昨日';
                break;
            case 2:
                $action .= 'week';
                $name .= '周';
                break;
            case 3:
                $action .= 'month';
                $name .= '月';
                break;
        }
        switch($data_arr[0]){
            case 1:
                $action .= 'Login';
                $name .= '访问数据';
                break;
            case 2:
                $action .= 'Member';
                $name .= '用户数据';
                break;
            case 3:
                $action .= 'Search';
                $name .= '搜索数据';
                break;
            case 4:
                $action .= 'Acer';
                $name .= '元宝消耗';
                break;
        }
        $list = $this->$action();
        $title = ['时间','次数'];
        put_csv($name, $list, $title);
    }
}