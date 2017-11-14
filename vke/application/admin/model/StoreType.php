<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/11/13
 * Time: 11:44
 */

namespace app\admin\model;
use app\admin\model\Base;
use think\Db;

class StoreType extends Base
{
    /**
     * 获得商店分类 - 20171113
     */
    public function getStoreList($fields)
    {
        $map = [
            'status' => 1
        ];
        $list = Db::name('store_type')
            ->where($map)
            ->order('sorts','desc')
            ->field($fields)
            ->select();
        return $list;

    }

    /**
     * 获得粉丝福利返元宝数量 - 20171113
     */
    public function getFansAcer()
    {
        $acer = Db::name('store_type')
            ->where('id',2)
            ->value('number');
        return $acer;
    }
}