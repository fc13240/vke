<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/11/8
 * Time: 10:16
 */

namespace app\admin\validate;
use think\Validate;

class Login extends Validate
{
    protected $rule = [
        'username' => 'require',
        'password' => 'require'
    ];
    protected $message = [
        'username.require' => '请输入账户名',
        'password.require' => '请输入密码'
    ];
}