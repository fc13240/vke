<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/10/27 0027
 * Time: 10:04
 */
namespace app\weke\model;

use think\Model;

class CateType extends Model
{
    public function getGoodsType()
    {
        $goodsType = $this
            ->where('status','eq','1')
            ->order('sorts','desc')
            ->field('cate_id,cate_name')
            ->select();
        return $goodsType;
    }
}