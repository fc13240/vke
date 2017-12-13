<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/11/17
 * Time: 16:03
 */

namespace app\admin\controller;
use app\common\controller\Base;
use think\Request;
use think\Db;

class Shareorder extends Base
{


    public function getOrderList()
    {
        //查询日期
        $start_date = Request::instance()->post('start');
        $end_date = Request::instance()->post('end');
        if(empty($start_date) || empty($end_date)){
            $start_date = date('Y-m-d',time());
            $end_date = date('Y-m-d',time()-7*86400);
        }

        //晒单状态- 0全部1广场中 2未加入
        $is_square = Request::instance()->post('is_square');

        //状态- 0全部 1审核通过 2未审核 3审核拒绝
        $examine_status = Request::instance()->post('status');

        $map['create_time'] = ['between',[$start_date,$end_date]];
        if(!empty($is_square)){
            $map['is_square'] = $is_square;
        }

        if(!empty($examine_status)){
            $map['examine_status'] = $examine_status;
        }

        $order_list = model('MemberEvaluate')->getShareList($map);
        $result = [
            'data' => [
                'order_list' => $order_list,
                'start' => $start_date,
                'end' => $end_date
            ]
        ];
        return resultArray($result);
    }

    /**
     * 验证订单
     */
    public function checkOrder($share_id)
    {
        //晒单id
        if(empty($share_id)){
            return resultArray(['error'=>'请选择查看的晒单']);
        }
        //根据晒单id查询是否存在
        $value = db('member_evaluate')->where('evaluate_id',$share_id)->value('evaluate_id');
        if(empty($value)){
            return resultArray(['error'=>'该订单不存在']);
        }
    }

    /**
     * 晒单详情 - 20171117
     */
    public function shareOrderInfo()
    {
        $share_id = Request::instance()->post('share_id');
        $this->checkOrder($share_id);
        //查询晒单详情
        $share_info = model('MemberEvaluate')->getEvaluateInfo($share_id);
        $share_info['update_time'] = substr($share_info['update_time'],0,10);
        $url = explode(',',$share_info['evaluate_url']);
        if(!empty($url)){
            foreach($url as $key => $value){
                $share_url[] = [
                    'image' => $value
                ];
            }
        }
        $share_info['evaluate_url'] = $share_url;
        $result = [
            'data' => [
                'share_info' => $share_info
            ]
        ];
        return resultArray($result);
    }

    /**
     * 设置晒单奖励元宝数 - 20171117
     */
    public function setShareConfig()
    {
        if(Request::instance()->isGet()){
            $acer = db('acer_reward')->where('type',2)->value('acer_number');
            $brief = db('share_config')->where('id',1)->value('value');
            $result = [
                'data' => [
                    'acer' => $acer,
                    'brief' => $brief
                ]
            ];
        }
        elseif(Request::instance()->isPost()){
            //新设元宝数
            $new_acer = Request::instance()->post('acer');
            $brief = Request::instance()->post('brief');
            if(!empty($brief)){
                return resultArray(['error'=>'请输入晒单规则说明']);
            }
            if(!is_numeric($new_acer)){
                return resultArray(['error'=>'请输入正确的元宝数量']);
            }
            //执行修改
            Db::startTrans();
            try{
                Db::name('acer_reward')->where('type',2)->update(['acer_number'=>$new_acer]);
                Db::name('share_config')->where('type',1)->update(['value'=>$brief]);
                Db::commit();
                $result = [
                    'data' => [
                        'message' => '修改成功'
                    ]
                ];
            }catch(\Exception $e){
                Db::rollback();
                $result = [
                    'error' => '修改失败'
                ];
            }
        }
        return resultArray($result);
    }

    /**
     * 晒单审核未通过 - 20171117
     */
    public function examineOrder()
    {
        $examine_status = Request::instance()->post('type');
        $is_square = Request::instance()->post('is_square');

        if($examine_status == 2){
            $status = 1;
        }
        elseif($examine_status == 3){
            $status = 3;
        }
        //未通过的订单id
        $share_id = Request::instance()->post('share_id/a');
        if(empty($share_id)){
            return resultArray(['error'=>'请选择审核的订单']);
        }
        if(is_array($share_id)){
            foreach($share_id as $key => $value){
                $check_result = $this->checkOrder($value);
                if($check_result){
                    return $check_result;
                }
            }
        }else{
            $check_result = $this->checkOrder($share_id);
            if($check_result){
                return $check_result;
            }
        }

        $map['evaluate_id'] = ['in',$share_id];
        //查询未通过通知内容,发送通知
        $member_id = model('MemberEvaluate')->getMemberId($map);
        //发送内容
        $msg = db('share_config')->where('type',2)->where('id',$examine_status)->find();
        //修该晒单状态,发送未通过通知
        $data = [];
        Db::startTrans();
        try{
            if(!empty($status)){
                $edit_data = [
                    'examine_status'=>$status
                ];
                foreach($member_id as $key => $value){
                    $data[] = [
                        'member_id' => $value,
                        'msg' => $msg['value'],
                        'title' => $msg['title'],
                        'add_time' => date('Y-m-d H:i:s',time())
                    ];
                }
                Db::name('message')->insertAll($data);
            }

            if(!empty($is_square)){
                $edit_data['is_square'] = $is_square;
            }

            Db::name('member_evaluate')->where('evaluate_id','in',$share_id)->update($edit_data);

            if($examine_status == 2){ //通过审核后,奖励用户元宝数
                //判断当日所赠送元宝是否已达上限,如果到达上限,提醒后台
                $day_limit = $this->isDayLimit();
                $month_limit = $this->isMonthLimit();
                if(!$day_limit && !$month_limit) {
                    $reward_acer = db('acer_reward')->where('type',2)->value('acer_number');
                    Db::name('member')->where('member_id','in',$member_id)->setInc('member_acer',$reward_acer);
                    $this->rewardAcer($member_id,$reward_acer);
                }else{
                    return resultArray(['error'=>'奖励元宝总数量']);
                }
            }

            Db::commit();
            $result = [
                'data' => [
                    'message' => '操作成功'
                ]
            ];
        }catch(\Exception $exception){
            dump($exception->getMessage());
            Db::rollback();
            $result = [
                'error' => '操作失败'
            ];
        }
        return resultArray($result);
    }

    /**
     * 晒单通过审核够奖励元宝 - 20171120
     * @param $member_id
     * @param $reward_acer
     */
    public function rewardAcer($member_id,$reward_acer)
    {

        //根据id查询会员当前已有元宝
        $member_acer = model('Member')->memberAcer($member_id);
        foreach($member_acer as $key => $value){
            //记录元宝记录
            $before =  $value['member_acer'] - $reward_acer;
            inserAcerNotes($value['member_id'],1,$reward_acer,$before,$value['member_acer'],4,'晒单通过获得元宝');
        }
    }

    /**
     * 判断是否到达日赠送元宝上限 - 20171120
     */
    public function isDayLimit()
    {
        $up_limit = db('acer_config')->where('id',1)->value('day_limit');
        if(!empty($up_limit)){
            //判断当天赠送的元宝数量
            $today = date('Y-m-d',time());
            $start = $today.' 00:00:00';
            $end = $today.' 23:59:59';
            $map['add_time'] = ['between',[$start,$end]];
            $map['type'] = 1;
            $total_number = db('acer_notes')->where($map)->sum('number');
            if($total_number >= $up_limit) {
                return true;
            }else{
                return false;
            }
        }
        return false;
    }

    /**
     * 判断是否到达月赠送元宝上限 - 20171120
     */
    public function isMonthLimit()
    {
        $up_limit = db('acer_config')->where('id',1)->value('month_limit');
        if(!empty($up_limit)){
            //判断当天赠送的元宝数量
            $month = date('Y-m',time());
            $to_month = month_s_e($month);
            $map['add_time'] = ['between',[$to_month[0],$to_month[1]]];
            $map['type'] = 1;
            $total_number = db('acer_notes')->where($map)->sum('number');
            if($total_number >= $up_limit) {
                return true;
            }else{
                return false;
            }
        }
        return false;
    }
}