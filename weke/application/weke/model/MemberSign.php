<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017-07-21
 * Time: 17:21
 */
namespace app\weke\model;
use think\Model;
class MemberSign extends Model
{
    /**
     * 今天签的可获得的元宝
     * @param $user_id
     */
    public function com_get_sign_ubb($user_id)
    {
        $time1 = strtotime(date("Y-m-d")."00:00:00");
        $time2 = strtotime(date("Y-m-d")."23:59:59");
        //根据user_id查询签到表
        $sign_notes = db("sign_notes")
            ->where(array("member_id"=>$user_id))
            ->order("sign_time","desc")
            ->find();


        //1查询签到每次赠送的元宝
        $task = db("sign_acer")->where(array("id"=>1))->value("reward_yb");


        //判断是否是登录后第一次签到
        if(empty($sign_notes)){
            //第一次签到
            $result['sign_acer']           = $task;
            $result['continue_yb']      ='0';
            $result['continue_days']  = '0';
            $result['is_sign']  = '0';
        }else{
            //连续签到天数
            $continue_days = $sign_notes["continue_days"];
            //判断当前是否是月初//第几天
            $day = date("d",time());
            if($day == 1){
                $continue_days = "0";
            }
            //判断是否断签 今天零点的时间-24小时//断签
            if($time1-24*3600 > $sign_notes["sign_time"]){
                $continue_days = "0";
            }

            $is_sign ="0";
            if($time1 <= $sign_notes['sign_time'] && $sign_notes['sign_time'] <= $time2){
                $is_sign="1";
            }
            //查找连续签到的ub奖励
            $continue_yb = db("sign_reward")
                ->where(array("sign_days"=>$continue_days,"status"=>1))
                ->value("reward_num");

            $result['sign_acer']           = $task+$continue_yb;
            $result['continue_yb']      =$continue_yb;
            $result['continue_days']  = $continue_days;
            $result['is_sign']         = $is_sign;
        }
        return $result;
    }

    /**
     * 签到
     * $user_id 用户id
     * 元宝赠送数量:会员等级加送+连续签到加送+签到基本赠送
     */
    public function com_do_sign($user_id)
    {

        //查询当天是否已签到
        $time1 = strtotime(date("Y-m-d")."00:00:00");
        $time2 = strtotime(date("Y-m-d")."23:59:59");
        $today_sign = db("member_sign")
            ->where(array("member_id"=>$user_id,"sign_time"=>array("between",array($time1,$time2))))
            ->find();
        if($today_sign){
            $result = [
                "status" => 0,
                "message" => "今天已经签到",
            ];
            return $result;
        }

        //当前时间
        $now = time();

        //根据user_id查询签到表
        $sign_notes = db("member_sign")
            ->where("user_id",$user_id)
            ->order("sign_time","desc")
            ->find();

        //1查询签到每次赠送的优宝币
        $task = db("sign_acer")->where('id',1)->value("reward_yb");


        //判断是否是登录后第一次签到
        if(empty($sign_notes)){
            //第一次签到
            $data = array(
                "member_id"   => $user_id, //会员id
                "sign_time" => $now, //签到时间
                "sign_acer"    => $task, //签到赠送的元宝数量
                "continue_sign_days"=>1, //连续签到天数
                "sign_days"  =>  1
            );
            $res = db("member_sign")->insert($data);

            //记录优宝币记录表
            $memInfo = db("member")
                ->where(['member_id',$user_id])
                ->value('member_acer');
            $before = $memInfo['member_acer'];
            $end    = $memInfo['member_acer']+$data['sign_acer'];
            $param = [
                'member_id' => $user_id,      //用户ID
                'type'  => 1,       //收入/支出 1-收入 2-支出
                'number' => $data['ubaobi'],      //交易数量
                'before' => $before,  //交易前多少优宝币
                'after' => $end,  //交易后多少优宝币
                'class'   => 1,    //交易类型 1
                'msg'       => '签到赠送元宝',        //交易描述
                ];
            $this->com_add_Ubb_Log($param);
            //更新会员表会员的U宝币
            db("member")
                ->where(array('member_id'=>$user_id))
                ->setInc("member_acer",$data['sign_acer']);
            if($res !== false){
                //记录任务完成
                $result = array(
                    "status"=>'1',
                    "message"=>"签到成功",
                    "data"=>$data['sign_acer'],
                );
                return $result;
            }else{
                $result = array(
                    "status"=>'0',
                    "message"=>"签到失败",
                );
                return $result;
            }
        }else{
            //连续签到天数
            $continue_days = $sign_notes["continue_days"];

            //判断当前是否是月初//第几天
            $day = date("d",time());
            if($day == 1){
                $continue_days = 0;
            }

            //判断是否断签 今天零点的时间-24小时//断签
            if($time1-24*3600 > $sign_notes["sign_time"]){
                $continue_days = 0;
            }
            //查找连续签到的ub奖励
            $continue_yb = db("sign_reward")
                ->where(array("sign_days"=>$continue_days,"status"=>1))
                ->value("reward_num");

            //添加签到记录
            $data = array(
                "member_id"   => $user_id,
                "sign_time" => $now,
                "sign_acer"    => $task+$continue_yb,
                "continue_days"=> $continue_days+1
            );
            $res = db("sign_notes")->insert($data);

            //记录优宝币记录表
            $param=array(
                'member_id' => $user_id,
                'type'  => 1,
                'number' => $data['ubaobi'],
                'before' => $this->user_info['member_acer'],
                'after' => $this->user_info['member_acer']+$data['sign_acer'],
                'class'   => 2,
                'msg'       => "签到奖励元宝",
            );
            $this->com_add_Ubb_Log($param);

            //更新会员表会员的元宝
            $res = db("member")
                ->where(array('member_id'=>$user_id))
                ->setInc("member_acer",$data['sign_acer']);
            if($res !== false){
                //记录任务完成
                $result = array(
                    "status"=>'1',
                    "message"=>"签到成功",
                    "data"=>$data['sign_acer'],
                );
                return $result;
            }else{
                $result = array(
                    "status"=>'0',
                    "message"=>"签到失败",
                );
                return $result;
            }
        }
    }

    /**
     * 元宝交易记录列表
     * $param=array(
    'user_id' => $user_id,    //用户ID
    'type'    => $income,     //收入/支出 1-收入 2-支出
    'number'  => $pay_num,    //交易数量
    'before'  => $pay_front,  //交易前多少元宝
    'after'   => $pay_after,  //交易后多少元宝
    'class'   => 2            //签到获得的元宝
    'msg'     => $msg,        //交易描述
    );
     * @return status=> 0   非法请求/暂无记录
     * @return status=> 1   请求成功
     * */
    public function com_add_Ubb_Log($param){
        $param['add_time'] = date("Y-m-d H:i:s",time());
        $res = dn('sign_notes')->insert($param);
        if($res){
            return true;
        }else{
            return false;
        }
    }
}