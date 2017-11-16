<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/11/16
 * Time: 11:04
 */

namespace app\admin\model;
use app\admin\model\Base;
use think\Db;

class MemberFootprint extends Base
{
    /**
     * 查询浏览记录 - 20171116
     */
    public function getType($map)
    {
        $map['pid'] = ['neq',0];
        $history = Db::view('MemberFootprint','number')
            ->view('Product','product_type','MemberFootprint.product_id = Product.id')
            ->view('CateType','id,cate_name','Product.product_type = CateType.id')
            ->where($map)
            ->group('id')
            ->field('sum(number) total_number')
            ->limit(10)
            ->select();
        foreach($history as $key => $value){
            unset($history[$key]['number']);
            unset($history[$key]['product_type']);
        }
        return $history;
    }

    /**
     * 查询商品浏览次数top10
     */
    public function getProduct($map,$limit)
    {
        $list = Db::view('MemberFootprint','number')
            ->view('Product','pict_url,title','MemberFootprint.product_id = Product.id')
            ->where($map)
            ->order('number','desc')
            ->limit($limit)
            ->select();
        return $list;
    }
}