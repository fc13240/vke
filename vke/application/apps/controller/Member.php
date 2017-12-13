<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/12/11
 * Time: 10:43
 */

namespace app\apps\controller;
use think\Controller;
use think\Request;
use think\Db;

class Member extends Controller
{
    /**
     * 查看当前用户是否已经存到数据库
     */
    public function checkMember()
    {
        $member_id = Request::instance()->post('member_id');
        $user_info = Request::instance()->post('userInfo/a');
        $nickname = Db::name('member')->where('member_id',$member_id)->value('wechat_nickname');
        if(empty($nickname)){
            $data = [
                'wechat_nickname' => $user_info['nickName'],
                'wechat_sex' => $user_info['gender'],
                'wechat_province' => $user_info['province'],
                'wechat_city' => $user_info['city'],
                'wechat_country' => $user_info['country'],
                'wechat_head_image' => $user_info['avatarUrl'],
            ];
            Db::name('member')->where('member_id',$member_id)->update($data);
        }
    }
}