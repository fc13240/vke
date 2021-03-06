<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/10/27 0027
 * Time: 15:16
 */
namespace app\vke\controller;
use app\vke\model\Member;
use app\vke\controller\Common;
use app\vke\model\MemberFootprint;

class Ucenter extends Common
{
    public function _initialize()
    {
        parent::_initialize(); // TODO: Change the autogenerated stub
        $this->checkLogin();
    }

    //个人中心首页
    public function center()
    {
        $user_id = $this->user_id;
        $fields = "wechat_head_image,wechat_nickname,member_acer";
        $user_info = model('Member')->getUserInfo($user_id,$fields);

        //根据user_id判断用户是不是首次登录
        $is_first = Member::where('member_id','eq',$user_id)->value('is_first_login');

        //判断该用户是否有未读消息
        $has_message = model('Message')->hasMessage($user_id);

        $message_count = model('Message')->getMessageCount($user_id);

        $result = [
            'data' =>[
                'head_image' => $user_info['wechat_head_image'],
                'user_name'  => $user_info['wechat_nickname'],
                'user_acer'  => $user_info['member_acer'],
                'message_count' => $message_count
            ]
        ];
//        if($has_message){
//            $result['data']['message'] = 1;
//        }
        if($is_first == 1){
            //首次登录补充个人信息提示语
            $mark = "请点击头像完善个人资料";
            $result['data']['mark'] = $mark;
        }
        Member::where('member_id',$user_id)->update(['is_first_login'=>2]);
        return resultArray($result);
    }



    /**
     * 获取浏览历史信息*2017.10.31*freedom
     */
    public function getFootPrint()
    {
        //首先判断是否登录
        $user_id = $this->user_id;
        $productList = model('MemberFootprint')->myPrint($user_id);
        $product_list = [];
        foreach($productList as $key => $value){
            $time = substr($value['time'],0,10);
            $product_list[$time]['object'][] = $value;
            $product_list[$time]['date'] = $time;
        }

            $result = [
                'data' => [
                    'history' => $product_list
                ]
            ];
            return resultArray($result);
    }

    /**
     * 清空我的足迹
     */
    public function delPrint()
    {
        $user_id = $this->user_id;
        $map['member_id'] = $user_id;
        $result_del = model('MemberFootprint')->where($map)->delete();
        if($result_del){
           $result = [
               'data' => [
                   'message' => '操作成功'
               ]
           ];
        }else{
            $result = [
                'error' => '操作失败'
            ];
        }
        return resultArray($result);
    }

    /**
     * 获取用户信息(头像,昵称,性别)
     */
    public function userInfo()
    {
        $user_id = $this->user_id;
        $fields = "wechat_head_image,wechat_nickname,wechat_sex";
        $user_info = model('Member')->getUserInfo($user_id,$fields);

        $result = [
            'data' => [
                'head_image' => $user_info['wechat_head_image'],
                'user_name'  => $user_info['wechat_nickname'],
                'sex' => $user_info['wechat_sex'],
            ]
        ];

        return resultArray($result);

    }

    /**
     * 获得会员元宝数
     */
    public function getMemberAcer()
    {
        $user_id = $this->user_id;
        $acer = model('Member')->where('member_id',$user_id)->value('member_acer');
        $result = [
            'data' => [
                'member_acer' => $acer
            ]
        ];
        return resultArray($result);
    }


}