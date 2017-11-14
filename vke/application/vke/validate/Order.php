<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/11/6
 * Time: 10:45
 */
namespace app\vke\validate;
use think\Validate;

class Order extends Validate
{
    protected $rule = [
        'order_num' => 'require|number'
    ];
    protected $message = [
        'order_num.require' => '订单号不能为空',
        'order_num.number' => '订单号格式错误'
    ];
}