<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/10/27 0027
 * Time: 10:30
 */
namespace app\vke\model;

use think\Model;
use think\Db;
class ExchangeOrder extends Model
{
   public function getOrderAcerList($user_id,$type=3,$limit = "")
   {
       $map = [
           'o.member_id' => $user_id,
           'o.status' => 2,
           'o.is_able' => 1
       ];
       if($type != 3 && $type!=""){
           $map['o.product_type'] = $type;
       }
        $acerList = Db::table('vke_exchange_order')
            ->alias('o')
            ->join('vke_product_acer a','a.product_id = o.product_id')
            ->where($map)
            ->field(['a.product_image','a.product_id','a.product_name','o.update_time'])
            ->order('o.update_time desc')
            ->limit($limit)
            ->select();
        return $acerList;
   }
}