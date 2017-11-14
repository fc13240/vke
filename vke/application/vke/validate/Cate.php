<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/11/10
 * Time: 11:45
 */

namespace app\vke\validate;
use think\Validate;

class Cate extends Validate
{
    protected $rule = [
        'cate_id' => 'require|number'
    ];

    protected $message = [
        'cate_id.require' => '请输选择分类'
    ];
}