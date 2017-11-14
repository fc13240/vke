<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/11/13
 * Time: 13:53
 */

namespace app\admin\validate;
use think\Validate;

class Affordable extends Validate
{
    protected $rule = [
        'store_id' => 'require|number',
        'image' => 'require',
        'store_name' => 'require'
    ];
    protected $message = [
        'store_id.require' => '请选择专场',
        'store_id.number' => '请选择专场',
        'image.require' => '请上传图片',
        'store_name' => '请填写专场名称'
    ];
    protected $scene = [
        'save' => ['store_id','image','store_name']
    ];
}