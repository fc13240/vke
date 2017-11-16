<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/11/15
 * Time: 17:54
 */

namespace app\admin\validate;
use think\Validate;

class ShareData extends Validate
{
    protected $rule = [
        'start' => 'require|date',
        'end' => 'require|date'
    ];
    protected $message = [
        'start.require' => '请选择开始日期',
        'start.date' => '日期格式不正确',
        'end.require' => '请选择结束日期',
        'end.date' => '日期格式不正确'
    ];
    protected $scene = [
        'select' => ['start','end']
    ];
}