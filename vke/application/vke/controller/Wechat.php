<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/11/1
 * Time: 10:24
 */
namespace app\vke\controller;
use app\vke\controller\Userinfo;
header("Access-Control-Allow-Origin: *");
class Wechat
{
    private $app_id = '';
    private $app_secret = '';
    private $_this;

    public function __construct()
    {
        $this->_this = new Userinfo;
        $state  = md5(uniqid(rand(), TRUE));
        //存到session中用于后续验证
        session('wx_state',$state);
        $url = "www.vke.com/vke/Wechat/getUserInfo";
        $wechat_url = action('Userinfo')->get_authorize_url($url,$state);
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
        $access_token = $this->_this->get_access_token($this->app_id, $this->app_secret, $code);
        //根据access_token获取用户信息
        $userInfo = $this->_this->get_user_info($access_token['access_token'],$access_token['openid']);
        //根据openid查询该用户是否已经填写信息
        $user_id = model('Member')->where(['wechat_openid'=>$userInfo['openid']])->value('member_id');
        if(empty($user_id)){
            //将用户信息存储到数据库
            $data = [
                'wechat_openid' => $userInfo['openid'],
                'wechat_nickname' => $userInfo['nickname'],
                'wechat_sex' => $userInfo['sex'],
                'wechat_province' => $userInfo['province'],
                'wechat_city' => $userInfo['city'],
                'wechat_country' => $userInfo['country'],
                'wechat_head_image' => $userInfo['headimgurl'],
                'wechat_unionid' => $userInfo['unionid']
            ];
            $model = model('Member');
            $model->data($data);
            $model->save();
            $this->user_id = $model->member_id;
        }else{
            $this->user_id = $user_id;
        }
    }
}