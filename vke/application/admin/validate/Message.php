<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/11/22
 * Time: 11:06
 */

namespace app\admin\validate;
use think\Validate;

class Message extends Validate
{
    protected $rule = [
        'title' => 'require',
        'msg' => 'require'
    ];
    protected $message = [
        'title.require' => '请输入通知标题',
        'msg.require' => '请输入通知内容'
    ];
    protected $scene = [
        'mass' => ['title','msg']
    ];
}