<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/11/1
 * Time: 10:24
 */
namespace app\vke\controller;
use app\vke\controller\Userinfo;
use think\Request;
use think\Controller;

header("Access-Control-Allow-Origin: *");
class Wechat extends Controller
{
    private $app_id = 'wx3d2bfcee97e18e30';
    private $app_secret;
    private $_this;
    private $action;
    public function _initialize()
    {
        $this->app_secret = config('app_secret');
        $this->_this = new Userinfo;

    }
    public function index()
    {
        $action = Request::instance()->get('action');
        session('login_action',$action);
        $state  = md5(uniqid(rand(), TRUE));
        //存到session中用于后续验证
        session('wx_state',$state);
        $url = "http://www.dxvke.com/api/getUserInfo";
        $class = new Userinfo;
        $wechat_url = $class->get_authorize_url($url,$state);
        //dump($wechat_url);die;
        header('location:'.$wechat_url);
    }

    /**
     * 获取用户信息
     */
    public function getUserInfo()
    {
        if(input('get.state') != session("wx_state")){
            $this->redirect("http://www.dxvke.com/#/home");
        }
        $code = Request::instance()->get('code');
        $class = new Userinfo;

        //获取access_token
        $access_token = $class->get_access_token($this->app_id, $this->app_secret, $code);
        if(empty($access_token)){
            $this->redirect("http://www.dxvke.com/#/home");
        }
        //根据access_token获取用户信息
        $userInfo = $class->get_user_info($access_token['access_token'],$access_token['openid']);
        //根据openid查询该用户是否已经填写信息
        $user_id = model('Member')->where(['wechat_openid'=>$userInfo['openid']])->value('member_id');

        $common = new Common;
        if(empty($user_id)){
            //将用户信息存储到数据库
            $data = [
                'wechat_openid' => $access_token['openid'],
                'wechat_nickname' => $userInfo['nickname'],
                'wechat_sex' => $userInfo['sex'],
                'wechat_province' => $userInfo['province'],
                'wechat_city' => $userInfo['city'],
                'wechat_country' => $userInfo['country'],
                'wechat_head_image' => $userInfo['headimgurl'],
                'last_login_time' => date('Y-m-d',time())
            ];
            $model = model('Member');
            $model->data($data);
            $model->save();
            $common->user_id = $model->member_id;
        }else{
            $common->user_id = $user_id;
        }
        session('user_id',$common->user_id);
        $action = session('login_action');
        $this->redirect("http://www.dxvke.com/#/".$action);
    }
}