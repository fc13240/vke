<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/11/8
 * Time: 16:00
 */

namespace app\admin\validate;
use think\Validate;

class Rule extends Validate
{
    protected $rule = [
        'id' => 'require|number',
        'id_del' => 'require|number',
        'id_add' => 'require|number',
        'title' => 'require',
        'name' => 'require',

    ];

    protected $message = [
        'title.require' => '请填写权限名称',
        'name.require' => '请填写模块/控制器/方法',
        'id.require' => '请选择要修改的权限',
        'id.number' => '请选择要修改的权限',
        'id_del.require' => '请选择要删除的权限',
        'id_del.number' => '请选择要删除的权限',
        'id_add.require' => '请选择父级权限',
        'id_add.number' => '请选择父级权限',
    ];
    protected $scene = [
        'add' => ['title','name'],
        'edit' => ['id','title','name'],
        'del' => ['id_del'],
        'add_child' => ['id_add','title','name']
    ];
}