<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/11/3
 * Time: 16:30
 */
namespace app\vke\controller;
use app\vke\controller\Common;
use app\vke\model\Member;
class Sign extends Common
{
    protected $week = ['0'=>'周日','1'=>'周一','2'=>'周二','3'=>'周三','4'=>'周四','5'=>'周五','6'=>'周六'];
    public function _initialize()
    {
        parent::_initialize(); // TODO: Change the autogenerated stub
        $this->checkLogin();
    }


    /**
     * 签到页面
     */
    public function signPage()
    {
        $user_id = $this->user_id;
        $signAcer = model('MemberSign')->com_get_sign_ubb($user_id);
        $member_model = Member::get(['member_id'=>$user_id]);
        $member_acer = $member_model->member_acer;




       $result = [
           'data' => [
               'acer' => $signAcer['sign_acer'],
               'is_sign' => $signAcer['is_sign'],
               'member_acer' => $member_acer,

           ]
       ];
        return resultArray($result);
    }

    /**
     * 兑换记录
     */
    public function signPageHistory()
    {
        //兑换记录
        $exchangeOrder = model('ExchangeOrder')->getOrderAcerList($this->user_id,'',2);
        $result = [
            'data' => [
                'exchange_order' => $exchangeOrder
            ]
        ];
        return resultArray($result);
    }

    /**
     * 一周签到记录
     */
    public function signPageWeek()
    {
        $week = getWeekTime();
        $continue = 0;
        //一周七日的日期
        $week_han = $this->week;
        foreach($week as $key => $value){
            //查询签到记录表sign_notes
            $map['sign_time'] = ['between',[$value['start'],$value['end']]];
            $sign = db('sign_notes')->where($map)->field('note_id,sign_acer')->find();
            if($sign){
                $is_sign = 1; //已签到
                $continue++;
            }else{
                $is_sign = 2; //未签到
            }
            $week[$key]['sign'] = $is_sign;
            $week[$key]['week'] = $week_han[$value['week']];
            $week[$key]['sign_acer'] = $sign['sign_acer'] ? $sign['sign_acer'] : 0;
            unset($week[$key]['start']);
            unset($week[$key]['end']);
            //unset($week[$key]['day']);
        }
        $result = [
            'data' => [
                'week' => $week,
                'continue_days' => $continue,
            ]
        ];
        return resultarray($result);
    }


    /**
     * 签到*2017.10.31*freedom
     * @return array
     */
    public function doSign()
    {
        $user_id = $this->user_id;

        //进行签到
        $result =  model('MemberSign')->com_do_sign($user_id);
        return resultArray($result);
    }
}