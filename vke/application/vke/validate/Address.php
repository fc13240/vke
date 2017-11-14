<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/11/6
 * Time: 14:58
 */

namespace app\vke\validate;
use think\Validate;

class Address extends Validate
{
    protected $rule = [
        'person_name' => 'require',
        'telephone' => ['require','regex'=>"^((13[0-9])|(14[5|7])|(15([0-3]|[5-9]))|(18[0,5-9]))\\d{8}$"],
        'province' => 'require',
        'country' => 'require',
        'district' => 'require',
        'address' => 'require',
        'id' => 'require|number'

    ];
    protected $message = [
        'person_name.require' => '收货人不能为空',
        'telephone.require' => '联系方式不能为空',
        'telephone.regex' => '联系方式格式不正确',
        'province.require' => '省份不能为空',
        'country.require' => '市区不能为空',
        'district.require' => '县镇不能为空',
        'address.require' => '详细地址不能为空',
        'id.require' => '请选择要修改的地址地址',
        'id.number' => '地址信息不存在'
    ];

    protected $scene = [
        'add' => ['person_name','telephone','province','country','district','address'],
        'edit_id' => ['id'],
    ];
}