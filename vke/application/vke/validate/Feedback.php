<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/11/3
 * Time: 15:35
 */

namespace app\vke\validate;
use think\Validate;

class Feedback extends Validate
{
    protected $rule = [
        'msg' => 'require',
        'telephone' => 'require'
    ];

    protected $message = [
        'msg.require' => '反馈内容必须填写',
        'telephone' => '手机号必须填写'
    ];
}
