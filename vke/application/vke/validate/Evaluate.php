<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/11/6
 * Time: 16:23
 */

namespace app\vke\validate;
use think\Validate;

class Evaluate extends Validate
{
    protected $rule = [
        'evaluate_detail' => 'require',
        'order_num' => 'require'
    ];

    protected $message = [
        'evaluate_detail.require' => '晒单信息不能为空',
        'order_num.require' => '请选择订单'
    ];
}