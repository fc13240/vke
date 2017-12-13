<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/11/8
 * Time: 10:14
 */
namespace app\admin\controller;
use think\Controller;
use app\admin\model\AdminUsers;
use think\Request;
use think\Cookie;

class User extends Controller
{
    protected $admin_id;

    /**
     * 用户执行注册后台会员
     */
    public function doRegister()
    {
        //用户名
        $username = input('post.username');
        //密码
        $password = input('post.password');
        $data = [
            'username' => $username,
            'password' => $password
        ];

        auto_validate('Register',$data);


        //根据用户名查看是否已经存在
        $user = AdminUsers::get(['username'=>$username]);
        if($user){
            return resultArray(['error'=>'该用户名已经存在']);
        }
        //执行添加数据库
        $result = AdminUsers::create([
            'username' => $username,
            'password' => password_hash($password,PASSWORD_DEFAULT),
            'status' => 1
        ]);
        if($result->id){
            $returnResult = [
                'data' => [
                    'message' => '注册成功'
                ]
            ];
        }else{
            $returnResult = [
                'error' => '注册失败'
            ];
        }
        return resultArray($returnResult);
    }

    /**
     * 执行登录
     */
    public function doLogin()
    {
        //接收用户名和密码
        //用户名
        $username = input('post.username');
        //密码
        $password = input('post.password');
        //验证码
        $verify = input('post.verify');
        //是否记住密码
        $isRemember = input('post.isRemember'); //1记住 0不记住
        //验证验证码
        $captcha = new \think\captcha\Captcha();
        if(!$captcha->check($verify)){
            //return resultArray(['error'=>'验证码错误']);
        }
        $data = [
            'username' => $username,
            'password' => $password
        ];
        auto_validate('Login',$data);

        //验证用户名是否存在
        $user = AdminUsers::get(['username'=>$username]);
        if(!$user){
            return resultArray(['error'=>'该用户不存在']);
        }
        //验证禁用状态
        if($user->status == 2){
            return resultArray(['error'=>'该账户已经被禁用']);
        }
        //验证密码是否正确
        if(!password_verify($password,$user->password)){
            return resultArray(['error'=>'密码错误']);
        }
        //登录成功后,存session,登录时间,登录ip
        session('user',$user->toArray());
        $this->admin_id = session('user')['id'];
        $user->last_login_time = date('Y-m-d H:i:s',time());
        $user->last_login_ip = Request::instance()->ip();
        if($user->save()){

            $fields = 'nickname,head_image';
            $user_info = model('AdminUsers')->getUserInfo($this->admin_id,$fields);
            $result = [
                'data' => [
                    'message' => '登录成功',
                    'user_info' => $user_info,
                    'url' => 'manager/Index/user'
                ]
            ];
            //是否记住登录账号密码
            if(!empty($isRemember)){
                $data = [
                        'username' => $username,
                        'password' => $password
                ];

                Cookie::set('autologin',serialize($data),'604800');
            }else{
                setcookie('autologin',null);
            }
        }else{
            $result = [
                'error' => '登录失败'
            ];
        };
        return resultArray($result);

    }

    /**
     * 退出登录
     */
    public function logout()
    {
        session('user',null);
        setcookie('autologin',null);
        return resultArray(['data'=>['message'=>'退出成功']]);
    }

    /**
     * 修改昵称 - 20171120
     */
    public function editNickName()
    {
        $nickname = Request::instance()->post('nickname');
        $image_url = Request::instance()->post('head_image');
        $nickname = trim($nickname);
        if(empty($nickname)){
            return resultArray(['error'=>'请输入用户名']);
        }

        //执行修改
        $map['id'] = session('user')['id'];
        $data['nickname'] = $nickname;
        if(!empty($image_url)){
            $data['head_image'] = $image_url;
        }

        $result_edit = model('AdminUsers')->editData($map,$data);
        if($result_edit !== false){
            $result = [
                'data' => [
                    'message' => '修改成功'
                ]
            ];
        }else{
            $result = [
                'error' => '修改失败'
            ];
        }
        return resultArray($result);
    }

    /**
     * 修改密码 - 20171120
     */
    public function changePassword()
    {
        //原密码
        $old_password = Request::instance()->post('old_password');

        //新密码
        $new_password = Request::instance()->post('new_password');
        //确认密码
        $sure_password = Request::instance()->post('sure_password');
        $data = [
            'old_password' => trim($old_password),
            'new_password' => trim($new_password),
            'sure_password' => trim($sure_password)
        ];
       $this->checkPassword($data);
       //执行修改
        $map['id'] = session('user')['id'];
        $data_edit = [
            'password' => password_hash($data['new_password'],PASSWORD_DEFAULT)
        ];
        $result_edit = model('AdminUsers')->editData($map,$data_edit);
        if($result_edit !== false){
            $result = [
                'data' => [
                    'message' => '修改成功'
                ]
            ];
        }else{
            $result = [
                'error' => '修改失败'
            ];
        }
        return resultArray($result);
    }

    /**
     * 验证密码规则 - 20171120
     */
    public function checkPassword($data)
    {
        auto_validate('Password',$data,'edit_password');
        $id = session('user')['id'];
        $password = model('AdminUsers')->where('id',$id)->value('password');
        $password = password_verify($data['old_password'],$password);
        if(!$password){
            ajaxReturn(['error'=>'原密码不正确']);
        }
        if($data['new_password'] != $data['sure_password']){
            ajaxReturn(['error'=>'两次密码不一致']);
        }
    }

    /**
     * 登录页面 - 20171121
     */
    public function loginPage()
    {

            if(Cookie::has('autologin')){
                $cookie_info = unserialize($_COOKIE['autologin']);
                $username = $cookie_info['username'];
                $password = $cookie_info['password'];
                $result = [
                    'data' => [
                        'username' => $username,
                        'password' => $password
                    ]
                ];
            }else{
                $result = [
                    'error' => '请登录'
                ];
            }
            return resultArray($result);
    }

    /**
     * 登录页验证码 - 20171121
     */
    public function verify()
    {
        $captcha = new \think\captcha\Captcha();
        return $captcha->entry();
    }

}