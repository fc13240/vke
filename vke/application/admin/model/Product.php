<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/11/13
 * Time: 10:03
 */

namespace app\admin\model;
use app\admin\model\Base;
use think\Db;


class Product extends Base
{
    /**
     * 获得菜单列表 - 20171113
     * @param $map 查询条件
     * @param $fields 查询字段
     * @return false|\PDOStatement|string|\think\Collection
     */
    public function getGoodsList($map,$fields)
    {
        $list = Db::name('product')
            ->where($map)
            ->field($fields)
            ->order('create_time','desc')
            ->select();
        foreach($list as $key => $value){
            $list[$key]['discount'] = round($value['zk_final_price']/$value['reserve_price']*10,1);
        }
        return $list;
    }

    /**
     * 查询数据库内商品总数
     */
    public function getGoodsCount()
    {
        $count = Db::name('product')
            ->count();
        return $count;
    }

}