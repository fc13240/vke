<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/10/27 0027
 * Time: 16:13
 */
namespace app\weke\model;
use think\Model;

class MemberFootprint extends Model
{
    /**
     * 获得该条浏览记录id
     */
    public function getFootId($user_id,$goods_id)
    {
        $footId = $this
        ->where('member_id',$user_id)
        ->where('product_id',$goods_id)
        ->value('id');
        return $footId;
    }
}