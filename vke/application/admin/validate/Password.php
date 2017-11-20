<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/11/20
 * Time: 14:33
 */

namespace app\admin\validate;
use think\Validate;

class Password extends Validate
{
    protected $rule = [
        'old_password' => ['require','regex'=>'^(?![0-9]+$)(?![a-zA-Z]+$)[0-9A-Za-z]{6,14}$'],
        'new_password' => ['require','regex'=>'^(?![0-9]+$)(?![a-zA-Z]+$)[0-9A-Za-z]{6,14}$'],
        'sure_password' => ['require','regex'=>'^(?![0-9]+$)(?![a-zA-Z]+$)[0-9A-Za-z]{6,14}$'],
    ];
    protected $message = [
        'old_password.require' => '请输入原密码',
        'old_password.regex' => '密码格式不正确',
        'new_password.require' => '请输入新密码',
        'new_password.regex' => '密码格式不正确',
        'sure_password.require' => '请输入确认密码',
        'sure_password.regex' => '密码格式不正确',
    ];
    protected $scene = [
        'edit_password' => ['old_password','new_password','sure_password']
    ];
}