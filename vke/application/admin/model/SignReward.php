<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/11/15
 * Time: 9:57
 */

namespace app\admin\model;
use app\admin\model\Base;
use think\Db;

class SignReward extends Base
{
    /**
     * 查询七天签到奖励情况 - 20171115
     */
    public function getWeekReward()
    {
        $reward = Db::name('sign_reward')
            ->where('status',1)
            ->order('sign_days','asc')
            ->field('id,sign_days,reward_num')
            ->select();
        return $reward;
    }
}