<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/11/7
 * Time: 11:30
 */

namespace app\vke\model;
use think\Model;
use think\Db;

class SearchKeywords extends Model
{
    /**
     * 获得默认搜索词
     */
    public function getDefaultWords()
    {
        $defaultWords = Db::table('vke_search_keywords')
            ->where(['status'=>1])
            ->column('keywords');
        $count = count($defaultWords);
        return ['words'=>$defaultWords,'count'=>$count];
    }
}