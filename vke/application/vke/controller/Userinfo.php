<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/11/1
 * Time: 10:39
 */
namespace app\vke\controller;
use think\Controller;

header("Access-Control-Allow-Origin: *");
class Userinfo extends Controller
{
    protected $app_id = 'wx3d2bfcee97e18e30';
    /**
     * 获取网页授权登录地址
     * @param string $redirect_uri
     * @param string $state
     * @return string
     */
    public function get_authorize_url($redirect_uri = '', $state = ''){
        $redirect_uri = urlencode($redirect_uri);
        return "https://open.weixin.qq.com/connect/oauth2/authorize?appid=".$this->app_id."&redirect_uri=".$redirect_uri."&response_type=code&scope=snsapi_userinfo&state=".$state."#wechat_redirect";
    }

    /**
       * 获取授权token
       *
       * @param string $code 通过get_authorize_url获取到的code
    */
    public function get_access_token($app_id = '', $app_secret = '', $code = '')
    {
        $token_url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid={$app_id}&secret={$app_secret}&code={$code}&grant_type=authorization_code";
        $token_data = $this->getJson($token_url);
        if(empty($token_data['errcode'])){ //请求成功
            return [
                'access_token' => $token_data['access_token'],
                'openid' => $token_data['openid']
            ];
        }else{
            return $token_data;
        }

    }

    /**
       * 获取授权后的微信用户信息
       *
       * @param string $access_token
       * @param string $open_id
    */
    public function get_user_info($access_token = '', $open_id = '')
    {
            if($access_token && $open_id)
        {
                $info_url = "https://api.weixin.qq.com/sns/userinfo?access_token={$access_token}&openid={$open_id}&lang=zh_CN";
            $info_data = $this->getJson($info_url);
            return $info_data;
        }
         return FALSE;
    }

    function getJson($url){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($ch);
        curl_close($ch);
        return json_decode($output, true);
    }
}