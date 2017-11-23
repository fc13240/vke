<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/11/16
 * Time: 15:01
 */

namespace app\admin\model;
use app\admin\model\Base;
use think\Db;

class SearchHistory extends Base
{
    /**
     * 查询热搜词前20 - 20171116
     */
    public function getHotWords()
    {
        $list = Db::name('search_history')
            ->order('number','desc')
            ->group('keywords')
            ->limit(20)
            ->field('keywords,sum(number)')
            ->select();
        return $list;
    }

    /**
     * 查询相应日期内的搜索词次数 - 20171120
     */
    public function getHistory($map,$limit=10)
    {
        $list = Db::name('search_history')
            ->where($map)
            ->order('number','desc')
            ->limit($limit)
            ->field('keywords,number')
            ->select();
        return $list;
    }

    /**
     * 查询期间内的搜索次数 - 20171120
     */
    public function getSerachCount($map)
    {
        $count = Db::name('search_history')
            ->where($map)
            ->count('number');
        return $count;
    }
}