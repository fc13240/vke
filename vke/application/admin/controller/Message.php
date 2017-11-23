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

    /**
     * 群发消息 - 20171122
     */
    public function massMessage()
    {
        //标题
        $title = input('post.title');
        //内容
        $msg = input('post.msg');
        auto_validate('Message',['title'=>$title,'msg'=>$msg],'mass');
        //查询当前所有用户的id
        $member_id = model('Member')->getMemberId();
        $id_string = implode(',',$member_id);
        //存入消息列表
        $data = [
            'member_id' => $id_string,
            'title' => $title,
            'msg' => $msg,
            'add_time' => date('Y-m-d H:i:s',time())
        ];
        $result_add = db('message')->insert($data);
        if($result_add){
           $result = [
               'data' => [
                   'message' => '发送成功'
               ]
           ];
        }else{
            $result = [
                'error' => '发送失败'
            ];
        }
        return resultArray($result);
    }
}