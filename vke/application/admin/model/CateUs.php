<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/11/17
 * Time: 9:21
 */

namespace app\admin\model;
use app\admin\model\Base;
use think\Db;

class CateUs extends Base
{
    /**
     * 查询所有分类及图标 - 20171117
     */
    public function getAllType()
    {
        $type_list = Db::name('cate_us')
            ->where('status',1)
            ->field('id,cate_name,image_url')
            ->order('sorts','desc')
            ->select();
        return $type_list;
    }

    /**
     * 根据id查询分类信息 - 20171117
     */
    public function getTypeInfo($type_id)
    {
        $info = Db::name('cate_us')
            ->where('id',$type_id)
            ->field('id,cate_name,image_url')
            ->find();
        return $info;
    }
}