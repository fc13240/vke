<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/11/14
 * Time: 18:03
 */

namespace app\admin\controller;
use app\common\controller\Base;
use think\Request;

class Sign extends Base
{
    /**
     * 管理-签到管理-一周签到情况 - 20171114
     */
    public function weekSign()
    {
        $week = getWeekTime();
        foreach ($week as $key => $value) { //根据start 和 end查询签到情况
            $map['sign_time'] = ['between', [$value['start'], $value['end']]];
            $signCount = model('SignNotes')->getSignCount($map);
            $week[$key]['sign_count'] = $signCount;
            if ($value['week'] == 0) {
                $week[$key]['week'] = 7;
            }
            unset($week[$key]['start']);
            unset($week[$key]['end']);
        }
        $result = [
            'data' => [
                'week' => $week
            ]
        ];
        return resultArray($result);
    }

    /**
     * 用户单次签到奖励元宝设置 - 20171115
     */
    public function onceSignReward()
    {
        $request = Request::instance();
        if($request->method() == 'GET'){ //查询当前设置
            $acer = db('sign_acer')->value('reward_acer');
            $result = [
                'data' => [
                    'acer' => $acer
                ]
            ];
            return resultArray($result);
        }
        elseif($request->method() == 'POST'){ //设置元宝参数
            //接收新的元宝数量
            $acer = $request->post('sign_acer');
            auto_validate('Acer',['acer'=>$acer],'acer');
            //执行修改
            $result_edit = db('sign_acer')->where('id',1)->update(['reward_acer'=>$acer]);
            if($result_edit !== false){
                $result = [
                    'data' => [
                        'message' => '设置成功'
                    ]
                ];
            }else{
                $result = [
                    'error' => '设置失败'
                ];
            }
            return resultArray($result);
        }
    }

    /**
     * 连续签到奖励 - 20171115
     */
    public function continueSignReward(){
        if(Request::instance()->method() == 'GET'){ //查询七次奖励设置
            $weekReward = model('SignReward')->getWeekReward();
            $result = [
                'data' => [
                    'week_reward' => $weekReward
                ]
            ];
            return resultArray($result);
        }
        elseif(Request::instance()->method() == 'POST'){ //执行修改
            //接收一周奖励设置情况
            $weekReward = Request::instance()->post('week_reward');
            //执行修改
            $resultReward = model('SignReward')->saveAll($weekReward);
            if($resultReward !== false){
                $result = [
                    'data' => [
                        'message' => '修改成功'
                    ]
                ];
            }else{
                $result = [
                    'error' => '修改失败'
                ];
            }
            return resultArray($result);
        }
    }

    /**
     * 断签重新计算 - 20171115
     */
    public function isStop()
    {
        if(Request::instance()->isGet()){ //查询当前断签后是否重新计算
            $is_stop = db('sign_config')->where('type',1)->value('value');
            if(empty($is_stop)){
                $is_stop = 2;
            }
            $result = [
                'data' => [
                    'is_stop' => $is_stop
                ]
            ];
            return resultArray($result);
        }
        elseif(Request::instance()->isPost()){
            $is_stop = Request::instance()->post('is_stop');
            if(empty($is_stop)){
                $is_stop = 2;
            }
            //执行修改
            $result_edit = db('sign_config')->where('type',1)->update(['value'=>$is_stop]);
            if($result_edit !== false){
                $result = [
                    'data' => [
                        'message' => '修改成功'
                    ]
                ];
            }else{
                $result = [
                    'error' => '修改失败'
                ];
            }
            return resultArray($result);
        }
    }
}