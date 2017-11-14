<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/11/9
 * Time: 10:29
 */

namespace app\admin\validate;
use think\Validate;

class Users extends Validate
{
    protected $rule = [
        'id' => 'require|number',
        'username' => 'require',
        'telephone' => ['require','regex'=>"^((13[0-9])|(14[5|7])|(15([0-3]|[5-9]))|(18[0,5-9]))\\d{8}$"],
        'password' => 'require'

    ];
    protected $message = [
        'id.require' => '请选择管理员',
        'id.number' => '请选择管理员',
        'username.require' => '请输入管理员昵称',
        'telephone.require' => '请输入手机号',
        'telephone.regex' => '手机号格式错误',
        'password.require' => '请输入密码'
    ];

    protected $scene = [
        'add' => ['username','telephone','password'],
        'edit' => ['id'],
        'edit_do' => ['id','username','telephone'],
        'select' => ['username']
    ];
}