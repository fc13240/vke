<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/11/14
 * Time: 17:38
 */

namespace app\admin\validate;
use think\Validate;

class Acer extends Validate
{
    protected $rule = [
        'id' => 'require',
        'acer' => 'require|number'
    ];
    protected $message = [
        'id.require' => '请选择商品',
        'acer.require' => '请输入元宝数量',
        'acer.number' => '请输入正确格式的元吧数量'
    ];
    protected $scene = [
        'edit' => ['acer','id']
    ];
}