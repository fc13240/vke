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
    public function getGoodsList($map,$fields,$path,$limit=10)
    {
        $count = model('Product')->where($map)->count();
        $list = Db::name('product')
            ->where($map)
            ->field($fields)
            ->order('create_time','desc')
            ->paginate($limit,$count,['path'=>$path]);
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