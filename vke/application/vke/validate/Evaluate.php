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
        'evaluate_url' =>'require',
        'order_num' => 'require'
    ];

    protected $message = [
        'evaluate_detail.require' => '晒单感受不能为空',
        'evaluate_url,require' => '请上传晒单图片',
        'order_num.require' => '订单号不能为空'
    ];
}