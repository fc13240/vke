<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/10/26 0026
 * Time: 16:53
 */
return [
    'cache'  => [
        'type'   => 'Memcache',
        'path'   => APP_PATH . 'runtime/cache/',
        'prefix' => '',
        'expire' => 1800,
    ],
    // 默认输出类型
    'default_return_type'    => 'html',
    // 默认AJAX 数据返回格式,可选json xml ...
    'default_ajax_return'    => 'json',
    'image_url' => 'http://47.96.164.141/uploads/vk/',
    'appkey' => 'Test',
    'secret' => 'Test',
    'app_secret' => '661ce03856db494c1cc1e948809586ac',
    //661ce03856db494c1cc1e948809586ac
    'app_key_ali' => '24728042',
    'app_secret_ali' => '3c7abf7f28e0acbc7f9f9df544ba5d86',
    'adzone_id' => '165466109',
];