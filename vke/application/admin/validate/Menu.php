<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/11/8
 * Time: 13:44
 */

namespace app\admin\validate;
use think\Validate;

class Menu extends Validate
{
    protected $rule = [
        'pid' => 'require|number',
        'name' => 'require',
        'mca' => 'require'
    ];

    protected $message = [
        'pid.require' => '请选择菜单',
        'pid.number' => '请选择菜单',
        'name.require' => '请填写菜单名称',
        'mca.require' => '请填写模块/控制器/方法'
    ];
    protected $scene = [
        'add_1' => ['name','mca'],
        'add_2' => ['pid','name','mca'],
        'edit' => ['pid'],
    ];
}