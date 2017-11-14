<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/10/27 0027
 * Time: 11:30
 */
namespace app\vke\validate;
use think\Validate;

class User extends Validate
{
    protected $rule = [
        'product_id' => 'require|integer',
        'number' => "require|integer",
        'telephone' => ['require','regex'=>"^((13[0-9])|(14[5|7])|(15([0-3]|[5-9]))|(18[0,5-9]))\\d{8}$"],
    ];
    protected $message = [
        'product_id.require' => '请选择兑换的商品',
        'product_id.integer' => '选择正确的积分商品',
        'number.require' => '请输入兑换数量',
        'number.integer' => '兑换数量应为整数',
        'telephone.require' => '请输入手机号',
        'telephone.regex' => '手机号输入不正确'
    ];
    protected $scene = [
        'acer'  =>  ['number','telephone'],
        'order' => ['order_num']
    ];
}