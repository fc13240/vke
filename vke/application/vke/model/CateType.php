<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/10/27 0027
 * Time: 10:04
 */
namespace app\vke\model;
use think\Db;
use think\Model;

class CateType extends Model
{
    /**
     * 获取一级分类
     * @param string $fields
     * @return false|\PDOStatement|string|\think\Collection
     */
    public function getGoodsType($fields='getGoodsType')
    {
        $goodsType = Db::name('cate_type')
            ->where('status','eq','1')
            ->where('type',1)
            ->where('pid',0)
            ->order('sorts','desc')
            ->field($fields)
            ->select();
        return $goodsType;
    }

    /**
     * 获取二级分类
     */
    public function getChildGoodsType($pid)
    {
        $map = [
            'status' => 1,
            'type' => 1,
            'pid' => $pid
        ];
        $goodsType = Db::name('cate_type')
            ->where($map)
            ->order('sorts','desc')
            ->field('id,cate_name')
            ->select();
        return $goodsType;
    }

    /**
     * 获取商店分类
     * @return false|\PDOStatement|string|\think\Collection
     */
    public function getIndexStoreList()
    {
        $storeType = Db::name('cate_type')
            ->where('status','eq','1')
            ->where('type',2)
            ->order('sorts','desc')
            ->field('id,image_url')
            ->select();
        return $storeType;
    }
}