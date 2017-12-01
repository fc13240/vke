<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/11/8
 * Time: 17:59
 */

namespace app\admin\validate;
use think\Validate;

class Group extends Validate
{
    protected $rule = [
        'id' => 'require|number',
        'id_del' => 'require|number',
        'id_allot' => 'require',
        'title' => 'require'
    ];
    protected $message = [
        'id.require' => '请选择要修改的分组',
        'id.number' => '请选择要修改的分组',
        'title.require' => '请输入分组名称',
        'id_del.require' => '请选择要删除的分组',
        'id_del.number' => '请选择要删除的分组',
        'id_allot.require' => '请选择要分组',
    ];
    protected $scene = [
        'edit' => ['id','title'],
        'del' => ['id_del'],
        'allot' => ['id_allot']
    ];
}