<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/11/7
 * Time: 11:09
 */

namespace app\vke\model;
use think\Model;
use think\Db;

class SearchHistory extends Model
{
    /**
     * 会员搜索历史
     * @param $user_id
     * @return array
     */
    public function getSearchHistory($user_id)
    {
        $map = [
            'member_id' => $user_id
        ];
        $history = DB::table('vke_search_history')
            ->where($map)
            ->order('number','desc')
            ->column('keywords');
        return $history;
    }

    /**
     * 热门推荐
     */
    public function getHotSearch($limit = 5)
    {
        $hot = DB::table('vke_search_history')
            ->group('keywords')
            ->order('number','desc')
            ->column('keywords');
        return $hot;
    }

}