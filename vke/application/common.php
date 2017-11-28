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

/**20171115
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

/**
 * 获取当前路径
 * @return string
 */
function getPath()
{
    $request = \think\Request::instance();
    return $request->domain().'/'.$request->path();
}

function getMonth($month)
{
    $date_month = $month;
    $mday = date('t',strtotime($date_month));
    $month_start = $date_month.'-01 00:00:00';
    $month_end = $date_month.'-'.$mday.' 23:59:59';
    return [
        'start' => $month_start,
        'end' => $month_end
    ];

}

/**
 * 根据月份获取该月份始末日期
 */
function month($month)
{
    $date_month = $month;
    $mday = date('t',strtotime($date_month));
    $month_start = $date_month.'-01 00:00:00';
    $month_end = $date_month.'-'.$mday.' 24:00:00';

    return week($month_start,$month_end);
}

/**
 * 根据月份获取该月份始末日期
 */
function month_s_e($month)
{
    $date_month = $month;
    $mday = date('t',strtotime($date_month));
    $month_start = $date_month.'-01 00:00:00';
    $month_end = $date_month.'-'.$mday.' 24:00:00';

    return [$month_start,$month_end];
}
/**
 * 根据星期几获得该星期始末时间
 */
function week($date_start,$date_end)
{
    $time_start = strtotime($date_start);
    $time_end = strtotime($date_end);
    for($i = $time_start; $i <= $time_end; $i += 7*86400){
        $week = date('w',$i);
        for($j = 1; $j <= 7; $j++){
            $weeks[$j] = date('Y-m-d',strtotime( '+'. $j-$week .' days', $i));
            if($weeks[$j] < date('Y-m-d',$time_start) || $weeks[$j] > $date_end){
                unset($weeks[$j]);
            }
        }
        ksort($weeks);
        $weeks_month[] = $weeks;
    }
    return $weeks_month;

}

/**
 * 根据开始日期和结束日期,返回这期间每天的日期 - 20171115
 */
function getDateFromRange($startdate, $enddate){

    $stimestamp = strtotime($startdate);
    $etimestamp = strtotime($enddate);

    // 计算日期段内有多少天
    $days = ($etimestamp-$stimestamp)/86400+1;

    // 保存每天日期
    $date = array();

    for($i=0; $i<$days; $i++){
        $day = date('Y-m-d', $stimestamp+(86400*$i));
        $date[] = [
            'date' => $day,
            'week' => date('w', $stimestamp+(86400*$i)) == 0 ? '7': date('w', $stimestamp+(86400*$i)),
        ];
    }

    return $date;
}

/**
 * 获取本年的所有月份信息
 */
function getYearMonth()
{
    $z = date('Y-m');
    $month = date('m');
    $a = date('Y-m', strtotime('-'.($month-1).' months'));
    $begin = new DateTime($a);
    $end = new DateTime($z);
    $end = $end->modify('+1 month');
    $interval = new DateInterval('P1M');
    $daterange = new DatePeriod($begin, $interval ,$end);
    foreach($daterange as $date){
        $resturn[] = [
            'month'=>$date->format("Y-m")
        ];
    }
    return $resturn;
}

/**
 * 记录元宝记录 - 20171120
 * @param $member_id 会员id
 * @param $type 类型 1收入 2支出
 * @param $number 交易数量
 * @param $before 交易前元宝数
 * @param $after 交易后元宝数
 * @param $class 1粉丝福利商品获得  2每日签到获得 3兑换积分商品支出 4晒单获得元宝
 * @param string $msg
 * @return int|string
 */
function inserAcerNotes($member_id,$type,$number,$before,$after,$class,$msg="")
{
    $data = [
        'member_id' => $member_id,
        'type' => $type,
        'number' => $number,
        'before' => $before,
        'after' => $after,
        'class' => $class,
        'msg' => $msg,
        'add_time' => date('Y-m-d H:i:s',time())
    ];

    $result = \think\Db::name('notes')->insert($data);
    return $result;
}

/**
 * cvs导出 - 20171120
 */
//导出csv文件
function put_csv($name, $list, $title){
    header ( 'Content-Type: application/vnd.ms-excel' );
    header ( 'Content-Disposition: attachment;filename='.$name.".xls" );
    header ( 'Cache-Control: max-age=0' );
    header("Expires: 0");
    $file = fopen('php://output',"a");
    $limit=1000;
    $calc=0;
    foreach ($title as $v){
        $tit[]=iconv('UTF-8', 'GB2312//IGNORE',$v);
    }
    fputcsv($file,$tit,"\t");
    foreach ($list as $v){
        $calc++;
        if($limit==$calc){
            ob_flush();
            flush();
            $calc=0;
        }
        $value_value = [];
        foreach($v as $value){
            $value_value[] = iconv('UTF-8', 'GB2312//IGNORE',$value);
        }
        fputcsv($file,$value_value,"\t");
    }
    unset($list);
    fclose($file);
    exit();
}

/**
 *实例化api,设置api参数
 */
function getApiRequest($req,$arr)
{
    \think\Loader::import('sdk.TopClient');
    $c = new \TopClient;
    $c->appkey = config('appkey');
    $c->secretKey = config('secret');

    foreach($arr as $key => $value)
    {
        $req->$key($value);
    }
    $resp = $c->execute($req);
    return $resp;
}

/**
 * 向后台发送系统消息 - 20171128
 */
function sendMessage($array)
{

    $data = [
        'type' => $array['type'],
        'title' => trim($array['title']),
        'msg' => trim($array['msg']),
        'status' => 1,
        'is_del' => 1,
        'add_time' => date('Y-m-d H:i:s',time())
    ];

    $result = \think\Db::name('admin_message')->insert($data);
    return $result;
}

