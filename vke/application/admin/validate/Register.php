<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/11/8
 * Time: 10:29
 */

namespace app\admin\validate;
use think\Validate;

class Register extends Validate
{
    protected $rule = [
        'username' => 'require',
        'password' => 'require'
    ];
    protected $message = [
        'username.require' => '用户名不能为空',
        'password.require' => '密码不能为空'
    ];
}