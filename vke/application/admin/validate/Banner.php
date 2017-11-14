<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/11/14
 * Time: 15:10
 */

namespace app\admin\validate;
use think\Validate;

class Banner extends Validate
{
    protected $rule = [
        'banner_image' => 'require'
    ];

    protected $message = [
        'banner_image.require' => '请上传图片'
    ];

}