<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/11/13
 * Time: 11:58
 */

namespace app\admin\validate;
use think\Validate;

class Goods extends Validate
{
    protected $rule = [
        'goods_id' => 'require',
        'cate_id' => 'require|number',
        'store_id' => 'require|number',
    ];
    protected $message = [
        'goods_id.require' => '未选择商品',
        'cate_id.require' => '未选择分类',
        'cate_id.number' => '未选择分类',
        'store_id.require' => '未选择分类',
        'store_id.number' => '未选择分类',
    ];
    protected $scene = [
        'cate' => ['goods_id','cate_id'],
        'store' => ['goods_id','store_id'],
        'fans' => ['goods_id']
    ];
}