<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/11/3
 * Time: 15:11
 */

namespace app\vke\model;
use think\Model;
use think\Db;


class Message extends Model
{
    /**
     * 根据用户id获得通知消息列表
     */
    public function getMessageList($user_id)
    {
        $map = [
            'member_id' => ['like','%'.$user_id.'%'],
            'is_del' => 1
        ];
        $messageList = Db::name('message')
            ->where($map)
            ->order(['status'=>'asc','add_time'=>'desc'])
            ->field('id,title,msg,status,add_time')
            ->select();
        if(empty($messageList)){
            $messageList = [];
        }
        return $messageList;
    }

    /**
     * 判断用户是否有未读消息
     * @param $user_id
     * @return bool
     */
    public function hasMessage($user_id)
    {
        $map = [
            'member_id' => $user_id,
            'status' => 1,
            'is_del' => 1
        ];
        $message = Db::table('vke_message')
            ->where($map)
            ->find();
        if(empty($message)){
            return false;
        }else{
            return true;
        }
    }

    /**
     * 获得用户的未读消息条数
     */
    public function getMessageCount($user_id)
    {
        $map = [
            'member_id' => $user_id,
            'status' => 1,
            'is_del' => 1
        ];
        $count = Db::name('message')
            ->where($map)
            ->count();
        return $count;
    }

}