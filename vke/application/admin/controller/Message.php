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
        $page_list = input('per_page');
        $message_list = model('AdminMessage')->getMessageListPage($map,$page_list);
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
            $message_arr = model('ShareConfig')->getMessageDefault();
            $result = [
                'data' => [
                    'message' => $message_arr
                ]
            ];
        }
        elseif(Request::instance()->isPost()){
            //修改
            $message = Request::instance()->post();
            $message_arr = [];
            foreach($message as $key => $value){
                switch($key){
                    case 'share_agree':
                        $message_arr[] = [
                            'id' => 2,
                            'value' => $value
                        ];
                        break;
                    case 'share_refuse':
                        $message_arr[] = [
                            'id' => 3,
                            'value' => $value
                        ];
                        break;
                    case 'express':
                        $message_arr[] = [
                            'id' => 4,
                            'value' => $value
                        ];
                        break;
                    case 'withdraw':
                        $message_arr[] = [
                            'id' => 5,
                            'value' => $value
                        ];
                        break;
                    case 'recharge':
                        $message_arr[] = [
                            'id' => 6,
                            'value' => $value
                        ];
                        break;
                    case 'examine_agree':
                        $message_arr[] = [
                            'id' => 7,
                            'value' => $value
                        ];
                        break;
                    case 'examine_refuse':
                        $message_arr[] = [
                            'id' => 8,
                            'value' => $value
                        ];
                        break;
                }
            }
            $result_edit = model('ShareConfig')->saveAll($message_arr);
            if($result_edit !== false){
                $result = [
                    'data' => [
                        'message' => '设置成功'
                    ]
                ];
            }else{
                $result = [
                    'error' => '设置失败'
                ];
            }
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

    /**
     * 设为已读 - 20171128
     */
    public function setStatus()
    {
        $message_id = input('message_id');
        if(empty($message_id)){
            return resultArray(['error'=>'请选择消息']);
        }
        //检查该id是否存在
        $id = \think\Db::name('admin_message')->where('id',$message_id)->value('id');
        if(empty($id)){
            return resultArray(['error'=>'该消息不存在']);
        }
        $result_edit = \think\Db::name('admin_message')->where('id',$message_id)->update(['status'=>2]);
        if($result_edit !== false){
            $result = [
                'data' => [
                    'message' => '成功'
                ]
            ];
        }else{
            $result = [
                'error' => '失败'
            ];
        }

        return resultArray($result);
    }
}