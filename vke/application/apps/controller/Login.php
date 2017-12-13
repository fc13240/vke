<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/12/7
 * Time: 9:54
 */

namespace app\apps\controller;

use think\Controller;
use think\Request;
use think\Db;

class Login extends Controller
{
    /**
     *通过code获取session_key - 20171207
     */
    public function getSessionKey()
    {
        $app_id = config('app_id');
        $app_secret = config('app_secret');
        $code = Request::instance()->post('code','', 'htmlspecialchars_decode');
        $url = 'https://api.weixin.qq.com/sns/jscode2session?appid='.$app_id.'&secret='.$app_secret.'&js_code='.$code.'&grant_type=authorization_code';
        $result = json_decode($this->curl($url),true);

        if($result['openid']) {
            $open_id = $result['openid'];
            //查找用户的id
            $member_id = Db::name('member')->where('wechat_openid', $open_id)->value('member_id');
            if (empty($member_id)) { //注册新用户
                $member_data = [
                    'is_del' => 2,
                    'wechat_openid' => $open_id,
                    'last_login_time' => date('Y-m-d', time()),
                    'create_time' => date('Y-m-d', time())
                ];
                $member_id = Db::name('member')->insertGetId($member_data);
            }
            $rand_string = $this->getRand($member_id);

            cache('$rand_string',$result['session_key'].$open_id,30*86400);
            return json(['status'=>200,'session_key'=>$rand_string,'member_id'=>$member_id]);
        }else{
            return json_encode(['status'=>400]);
        }
    }

    public function getOpenId()
    {
        $data = Request::instance()->post('encryptedData');
        if(empty($data)){
            return json_encode(['status'=>400]);
        }

        //解码获得openid

    }

    public function getRand($member_id)
    {
        $rand_string = md5($member_id.time());
        return substr($rand_string,0,16);
    }

    /**
     * curl - 20171207
     */
    public function curl($url)
    {
        //初始化
        $ch = curl_init();

        //设置选项，包括URL
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, '0');
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, '0');
        //执行并获取HTML文档内容
        $output = curl_exec($ch);

        $err_code = curl_errno($ch);
        //释放curl句柄
        curl_close($ch);

        //打印获得的数据
        return $output;
    }
}