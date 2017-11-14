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
    'image_url' => 'http://192.168.1.101/uploads/vk/'
];