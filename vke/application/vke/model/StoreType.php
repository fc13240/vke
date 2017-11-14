<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/11/2
 * Time: 17:10
 */
namespace app\vke\model;
use think\Model;
use think\Db;
class StoreType extends Model
{
    /**
     * 获取商店分类图片
     */
    public function getIndexStoreList()
    {
        return Db::table('vke_store_type')->where('status',1)
            ->where('status','1')
            ->where('id','in','1,2,5')
            ->order('sorts','desc')
            ->field('id,image')
            ->select();
    }

    /**
     * 获得分类名称
     */
    public function getTypeName($type_id)
    {
        return Db::table('vke_store_type')
            ->where('status',1)
            ->where('id',$type_id)
            ->field('store_name,image')
            ->find();
    }
}