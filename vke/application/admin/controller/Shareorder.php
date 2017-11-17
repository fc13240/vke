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
    /**
     * 验证订单
     */
    public function checkOrder($share_id)
    {
        //晒单id
        if(empty($share_id)){
            ajaxReturn(['error'=>'请选择查看的晒单']);
        }
        //根据晒单id查询是否存在
        $value = db('member_evaluate')->where('evaluate_id',$share_id)->value('evaluate_id');
        if(empty($value)){
            ajaxReturn(['error'=>'该订单不存在']);
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
        foreach($url as $key => $value){
            $share_url[] = [
                'image' => $value
            ];
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
    public function setRewardAcer()
    {
        if(Request::instance()->isGet()){
            $acer = db('acer_reward')->where('type',2)->value('acer_number');
            $result = [
                'data' => [
                    'reward_acer' => $acer
                ]
            ];
        }
        elseif(Request::instance()->isPost()){
            //新设元宝数
            $new_acer = Request::instance()->post('acer');
            if(!is_numeric($new_acer)){
                return resultArray(['error'=>'请输入正确的元宝数量']);
            }
            //执行修改
            $result_edit = db('acer_reward')->where('type',2)->update(['acer_number'=>$new_acer]);
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
        }
        return resultArray($result);
    }

    /**
     * 晒单审核未通过 - 20171117
     */
    public function refuseOrder()
    {
        $examine_status = Request::instance()->post('type');
        if($examine_status == 2){
            $status = 1;
        }
        elseif($examine_status == 3){
            $status = 3;
        }
        //未通过的订单id
        $share_id = Request::instance()->post('share_id');
        foreach($share_id as $key => $value){
            $this->checkOrder($value['share_id']);
        }
        $map['evaluate_id'] = ['in',array_values($share_id)];
        //查询未通过通知内容,发送通知
        $member_id = model('MemberEvaluate')->getMemberId($map);
        //发送内容
        $msg = db('share_config')->where('type',$examine_status)->find();
        //修该晒单状态,发送未通过通知
        $data = [];
        Db::startTrans();
        try{
            Db::name('member_evaluate')->where('evaluate_id','in',$share_id)->update(['examine_status'=>$status]);
            foreach($member_id as $key => $value){
                $data[] = [
                    'member_id' => $value,
                    'msg' => $msg['value'],
                    'title' => $msg['title'],
                    'add_time' => date('Y-m-d H:i:s',time())
                ];
            }
            Db::name('message')->insertAll($data);
            Db::commit();
            $result = [
                'data' => [
                    'message' => '操作成功'
                ]
            ];
        }catch(\Exception $exception){
            Db::rollback();
            $result = [
                'error' => '操作失败'
            ];
        }
        return resultArray($result);
    }

    /**
     * 晒单规则说明 - 20171117
     */
    public function shareBrief()
    {
        if(Request::instance()->isGet()){
            $brief = db('share_config')->where('id',1)->value('value');
            $result = [
                'data' => [
                    'brief' => $brief
                ]
            ];
        }
        elseif(Request::instance()->isPost()){
            //晒规则说明'
            $brief = Request::instance()->post('brief');
            if(!empty($brief)){
                return resultArray(['error'=>'请输入晒单规则说明']);
            }
            //执行修改
            $result_edit = db('share_config')->where('type',1)->update(['value'=>$brief]);
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
        }
        return resultArray($result);
    }
}