<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/11/9
 * Time: 10:59
 */

namespace app\admin\validate;
use think\Validate;

class GroupUser extends Validate
{
    protected $rule = [
        'uid' => 'require|number',
        'group_id' => 'require|number'
    ];
    protected $message = [
        'uid.require' => '请选择添加的管理员',
        'uid.number' => '请选择添加的管理员',
        'group_id.require' => '请选择分组',
        'group_id.number' => '请选择分组'
    ];
}