<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/11/2
 * Time: 15:58
 */
namespace app\vke\model;
use think\Model;

class ProductStore extends Model
{
    /**
     * @param $type_id
     * 获得相应分类的商品id数组
     */
    public function getGoodsIdList($type_id)
    {
        $goodsId = $this->where('type_id',$type_id)->column('product_id');
        return $goodsId;
    }
}