<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/10/27 0027
 * Time: 15:19
 */
namespace app\vke\model;
use think\Model;
use think\Db;
class Member extends Model
{
    /**
     * 减少用户元宝数
     * @param $member_id 用户id
     * @param $total_price 应减少的元宝数量
     * @return bool
     */
    public function setDecMemberAcer($member_id,$total_price)
    {
        $result = $this->where('member_id',$member_id)->setDec('member_acer',$total_price);
        if($result !== false){
            return true;
        }else{
            return false;
        }
    }

    /**
     * 查询用户已免单的金额
     * @param $user_id 用户id
     */
    public function getMemberFreeMoney($user_id)
    {
        return $this->where('member_id',$user_id)->value('free_money');
    }


    /**
     * 获取用户个人信息
     * @param $user_id
     * @return array|false|\PDOStatement|string|Model
     */
    public function getUserInfo($user_id,$fields)
    {
        $userInfo = Db::table('vke_member')
            ->where('member_id',$user_id)
            ->field($fields)
            ->find();
        return $userInfo;
    }

}