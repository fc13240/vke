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


class User extends Controller
{
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
        $user->last_login_time = date('Y-m-d H:i:s',time());
        $user->last_login_ip = Request::instance()->ip();
        if($user->save()){
            $result = [
                'data' => [
                    'message' => '登录成功',
                    'url' => 'manager/Index/index'
                ]
            ];

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
        return resultArray(['data'=>['message'=>'退出成功']]);
    }
}