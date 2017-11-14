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


/**
 * 返回对象
 * @param $array 响应数据
 */
function resultArray($array)
{
    if(isset($array['data'])) {
        $array['error'] = '';
        $code = 200;
    } elseif (isset($array['error'])) {
        $code = 400;
        $array['data'] = '';
    }
    return json([
        'code'  => $code,
        'data'  => $array['data'],
        'error' => $array['error']
    ]);
}



/**
 * 直接返回退出
 */
function ajaxReturn($array)
{
    if(isset($array['data'])) {
        $array['error'] = '';
        $code = 200;
    } elseif (isset($array['error'])) {
        $code = 400;
        $array['data'] = '';
    }
    $data = [
        'code'  => $code,
        'data'  => $array['data'],
        'error' => $array['error']
    ];
    exit(json_encode($data));
}

/**20170815wzz
 * 获取一周每天的时间戳
 * */
function getWeekTime(){
    $arr[0]= time()-((date('w')==0?7:date('w'))-7)*24*3600;
    $arr[1]= time()-((date('w')==0?7:date('w'))-1)*24*3600;
    $arr[2]= time()-((date('w')==0?7:date('w'))-2)*24*3600;
    $arr[3]= time()-((date('w')==0?7:date('w'))-3)*24*3600;
    $arr[4]= time()-((date('w')==0?7:date('w'))-4)*24*3600;
    $arr[5]= time()-((date('w')==0?7:date('w'))-5)*24*3600;
    $arr[6]= time()-((date('w')==0?7:date('w'))-6)*24*3600;

    $new=array();
    foreach($arr as $k=>$v){
        $new[$k]['start']=date("Y-m-d H:i:s",mktime(0,0,0,date("m",$v),date("d",$v),date("Y",$v)));
        $new[$k]['end']= date("Y-m-d H:i:s",mktime(23,59,59,date("m",$v),date("d",$v),date("Y",$v)));
        $new[$k]['day']=date("m-d",strtotime($new[$k]['start']));
        $new[$k]['week']=date("w",strtotime($new[$k]['start']));
    }
    return $new;
}

/**
 * 二维数组排序
 * @param $array
 * @param $orderby
 * @param int $order
 * @param int $sort_flags
 * @return mixed
 */
function wpjam_array_multisort($array, $orderby, $order = SORT_DESC, $sort_flags = SORT_REGULAR ){
    $refer = array();
    foreach ($array as $key => $value) {
        $refer[$key] = $value[$orderby];
    }
    array_multisort($refer, $order, $sort_flags, $array);
    return $array;
}


/**
 * 自动验证封装类*20171106
 */
function auto_validate($class,$data,$scene='')
{
    $validate = validate($class);
    if(!$validate->scene($scene)->check($data)){
        ajaxReturn(['error'=>$validate->getError()]);
    }
}

/**
 * 将元角区分开
 */
function rmb($string)
{
    if(empty($string)){
        return false;
    }
    $stringArray = explode('.',$string);
    $rmb = $stringArray[0];
    $corner = $stringArray[1];
    return [
        'rmb' => $rmb,
        'corner' => $corner
    ];
}

function getPath()
{
    $request = \think\Request::instance();
    return $request->domain().'/'.$request->path();
}

