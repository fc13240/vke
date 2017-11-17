<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/11/17
 * Time: 11:36
 */

namespace app\admin\validate;
use think\Validate;

class CateType extends Validate
{
    protected $rule = [
        'old_id' => 'require|number',
        'new_id' => 'require|number'
    ];
    protected $message = [
        'old_id.require' => '请选择原分类',
        'old_id.number' => '请选择原分类',
        'new_id.require' => '请选择新分类',
        'new_id.number' => '请选择新分类'
    ];
    protected $scene = [
        'edit' => ['old_id','new_id']
    ];
}