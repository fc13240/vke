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
            ->field('id,title,msg,status,add_time')
            ->select();
        return $list;
    }
}