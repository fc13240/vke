<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/11/20
 * Time: 16:30
 */

namespace app\admin\controller;
use app\common\controller\Base;
use think\Request;

class Message extends Base
{
    /**
     * 后台消息中心列表 - 20171120
     */
    public function messageList()
    {
        //查询member_id为0的消息
        $map['is_del'] = 1;

        $message_list = model('AdminMessage')->getMessageList($map);
        $result = [
            'data' => [
                'message_list' => $message_list
            ]
        ];
        return resultArray($result);
    }

    /**
     * 设置消息模板 - 20171120
     */
    public function setMessage()
    {
        if(Request::instance()->isGet()){
            //查询消息模板
            $message = model('ShareConfig')->getMessageDefault();
            $message_arr = [];
            foreach($message as $key => $value){
                if($value['type'] == 2){
                    $message_arr['share'][]=$value;
                }
                elseif($value['type'] == 3){
                    $message_arr['store'][]=$value;
                }
                elseif($value['type'] == 4){
                    $message_arr['order'][]=$value;
                }

            }
            $result = [
                'data' => [
                    'message' => $message_arr
                ]
            ];
        }
        elseif(Request::instance()->isPost()){
            //修改

        }
        return resultArray($result);
    }
}