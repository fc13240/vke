<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/10/27 0027
 * Time: 16:13
 */
namespace app\vke\model;
use think\Model;
use think\Db;

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

    /**
     * 我的足迹(获得浏览的商品)
     */
    public function myPrint($user_id)
    {
        $map = [
            'f.member_id' => $user_id,
            'is_del' => 2
        ];
        $print = Db::table('vke_member_footprint')
            ->alias('f')
            ->join('vke_product p','f.product_id = p.id')
            ->where($map)
            ->field('p.id,p.pict_url,small_images,p.title,f.time,p.volume,p.reserve_price')
            ->order(['number'=>'desc','time'=>'desc'])
            ->select();
        return $print;
    }
}