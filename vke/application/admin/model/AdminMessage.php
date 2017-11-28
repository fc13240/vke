<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/11/20
 * Time: 16:33
 */

namespace app\admin\model;
use app\admin\model\Base;
use think\Db;

class AdminMessage extends Base
{
    /**
     * 消息列表 - 20171120
     */
    public function getMessageList($map)
    {
        $list = Db::name('admin_message')
            ->where($map)
            ->order(['status'=>'asc','add_time'=>'desc'])
            ->field('id,type,title,msg,status,add_time')
            ->select();
        return $list;
    }

    /**
     * 查询未读消息条数 - 20171121
     */
    public function unreadCount()
    {
        $map = [
            'status' => 1,
            'is_del' => 1
        ];
        $count = Db::name('admin_message')
            ->where($map)
            ->count();
        return $count;
    }

    /**
     * 最新一条消息 - 20171121
     */
    public function latestMessage()
    {
        $map = [
            'status' => 1,
            'is_del' => 1
        ];
        $message = Db::name('admin_message')
            ->where($map)
            ->order('add_time','desc')
            ->field('id,title,msg')
            ->find();
        return $message;
    }
}