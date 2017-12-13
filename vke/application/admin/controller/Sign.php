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
use think\Db;

class Sign extends Base
{
    /**
     * 管理-签到管理-一周签到情况 - 20171114
     */
    public function weekSign()
    {
        $start = Request::instance()->post('start');
        $end = Request::instance()->post('end');
        if(empty($start) || empty($end)){
            $end = date('Y-m-d',time());
            $start = date('Y-m-d',time()-7*86400);
        }
        auto_validate('ShareData',['start'=>$start,'end'=>$end],'select');

        $time_arr = [];
        $count_arr = [];
        //查询日期内新增用户数量
        $date = getDateFromRange($start,$end);
        foreach($date as $key => $value){
            $start_date = $value['date'].' 00:00:00';
            $end_date = $value['date'].' 23:59:59';
            $map = [
                'sign_time' => ['between',[$start_date,$end_date]]
            ];
            $count = model('SignNotes')->getSignCount($map);
            $time_arr[] = $value['date'];
            $count_arr[] = (string)$count;
        }

        $result = [
            'data' => [
                'date' => $time_arr,
                'count' => $count_arr,
                'start' => $start,
                'end' => $end
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

            //单词签到奖励
            $acer = db('sign_acer')->value('reward_acer');

            //连续签到奖励
            $weekReward = model('SignReward')->getWeekReward();
            $week_reward = [];
            foreach($weekReward as $key => $value){
                $week_reward['sign_day'.$value['sign_days']] = $value;
                unset($week_reward['sign_day'.$value['sign_days']]['sign_days']);
            }

            //断签后是否重新计算
            $is_stop = db('sign_config')->where('type',1)->value('value');
            if(empty($is_stop)){
                $is_stop = 2;
            }
            $result = [
                'data' => [
                    'once_acer' => $acer,
                    'week_reward' => $week_reward,
                    'is_stop' => $is_stop
                ]
            ];
            return resultArray($result);
        }
        elseif($request->method() == 'POST'){ //设置元宝参数

            //接收新的元宝数量
            $acer = $request->post('once_acer');
            auto_validate('Acer',['acer'=>$acer],'acer');
            //连续签到
            $continue_acer = $request->post('week_reward/a');
            if(empty($continue_acer)){
                return resultArray(['error'=>'请输入连续签到奖励']);
            }

            //断签后是否重新计算
            $is_stop = $request->post('is_stop'); //1重记 2不重记

            //执行修改
            Db::startTrans();
            try{
                //修改单次奖励
                Db::name('sign_acer')->where('id',1)->update(['reward_acer'=>$acer]);
                //连续签到奖励
                foreach($continue_acer as $key => $value){
                    Db::name('sign_reward')->where('id',$value['id'])->update(['reward_num'=>$value['reward_num']]);
                }

                //断签是否重记
                Db::name('sign_config')->where('type',1)->update(['value'=>$is_stop]);
                Db::commit();
                $result = [
                    'data' => [
                        'message' => '设置成功'
                    ]
                ];
            }catch(\Exception $e){
                Db::rollback();
                $result = [
                    'error' =>$e->getMessage()
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