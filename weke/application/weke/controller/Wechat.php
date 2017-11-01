<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/11/1
 * Time: 10:24
 */
namespace app\weke\controller;
use app\weke\controller\Common;
class Wechat extends Common
{
    private $app_id = '';
    private $app_secret = '';
    public function index()
    {
        $state  = md5(uniqid(rand(), TRUE));
        //存到session中用于后续验证
        session('wx_state',$state);
        $url = "www.weke.com/weke/Wechat/getUserInfo";
        $wechat_url = action('UserInfo')->get_authorize_url($url,$state);
        header('location:'.$wechat_url);
    }

    /**
     * 获取用户信息
     */
    public function getUserInfo()
    {
        if(input('get.state') != session("wx_state")){
            //$this->redirect("http://" . $_SERVER['HTTP_HOST'] . "/weke/Index/index");
        }
        $code = input('get.code');
        //获取access_token
        $access_token = action('UserInfo')->get_access_token($this->app_id, $this->app_secret, $code);
        //根据access_token获取用户信息
        $userInfo = action('UserInfo')->get_user_info($access_token['access_token'],$access_token['openid']);
        //将用户信息存储到数据库
    }


}