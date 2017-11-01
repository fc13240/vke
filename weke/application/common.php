<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------
// 应用公共文件
function build_order_no(){
    return date('Ymd').substr(implode(NULL, array_map('ord', str_split(substr(uniqid(), 7, 13), 1))), 0, 8);
}

/**
 * 记录无效的订单信息
 */
function addErrorOrder($member_id,$order_num,$msg)
{
    $data = [
        'member_id' => $member_id,
        'order_num' => $order_num,
        'msg'        => $msg,
        'add_time'  =>  date('Y-m-d H:i:s')
    ];
    db('order_error')->insert($data);
}

