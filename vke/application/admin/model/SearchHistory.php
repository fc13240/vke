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
            ->limit(20)
            ->field('keywords,number')
            ->select();
        return $list;
    }
}