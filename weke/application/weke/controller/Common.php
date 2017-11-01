<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/10/27 0027
 * Time: 09:15
 */
namespace app\weke\controller;
use think\Controller;
class Common extends Controller
{
    public $user_id = 1;
    public $user_info = [];
    public $action_name;
    public $controller_name;
    public function _initialize()
    {
        //控制器初始化

        /*$this->controller_name = CONTROLLER_NAME;
        $this->action_name = ACTION_NAME;*/
        $userId = session('user_id');
        if($userId>0){
            $user_info = db("member")->where(array("member_id"=>$_SESSION['user_id'], "is_del"=>2))->find();
            if($user_info){
                $this->user_info = $user_info;
                $this->user_id = $user_info["id"];
            }else{
                session("user_id", null);
                $this->user_info = "";
                $this->user_id   = "";
            }
        }
    }

    //验证登录
    public function checkLogin()
    {
        $user_id = session('user_id');
        if(empty($user_id)){
            return [
                'status' => '-1',
                'message' => '请登录'
            ];
        }

        //根据user_id 查询信息
        $user_info = db('member')->where('id','eq',$user_id)->where('is_del','eq','2')->find();
        if(empty($user_info)){
            return [
                'status' => '-1',
                'message' => '帐号不存在或已被冻结'
            ];
        }

    }

    //请求接口公共数据
    public function commonData()
    {

    }

    //请求接口数据
    public function getGoodsList()
    {

    }

    /**
     * 引导未知控制器
     */
    public function __call($method, $param){
        $this->redirect("weke/index");die;
    }
}