<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/10/27 0027
 * Time: 09:15
 */
namespace app\vke\controller;
use think\Controller;
use think\Db;
use think\Request;
use think\Image;
use app\common\controller\Compress;
use app\vke\controller\Wechat;
use app\vke\controller\Redirects;


header("Access-Control-Allow-Origin: *"); // 允许任意域名发起的跨域请求
class Common extends Controller
{
    public $user_id;
    public $user_info = [];
    public $action_name;
    public $controller_name;
    public function _initialize()
    {
        //记录访问日志
        $request = Request::instance();
        $ip = $request->ip();
        $create = date('Y-m-d H:i:s',time());
        Db::name('notes')->insert(['ip'=>$ip,'create_time'=>$create]);

        file_put_contents('log.txt',$ip);
        /*$this->controller_name = CONTROLLER_NAME;
        $this->action_name = ACTION_NAME;*/
        $userId = session('user_id');
        if($userId>0){
            $user_info = db("member")->where(array("member_id"=>$userId, "is_del"=>2))->find();
            if($user_info){
                $this->user_info = $user_info;
                $this->user_id = $user_info["member_id"];
            }else{
                session("user_id", null);
                $this->user_info = "";
                $this->user_id   = "";
                $this->redirect('http://www.dxvke.com/#/home');
            }
        }
    }

    //验证登录
    public function checkLogin()
    {
        $user_id = session('user_id');
        if(empty($user_id)){
            return resultArray(['error'=>'请登录']);
        }

        //根据user_id 查询信息
        $user_info = db('member')->where('member_id','eq',$user_id)->where('is_del','eq','2')->find();
        if(empty($user_info)){
            return resultArray(['error'=>'账号不存在或已被冻结']);
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
        $this->redirect("vke/user");die;
    }

    /**
     * 上传图片类
     */
    public function upload()
    {
        $request = Request::instance();
        //获取表单上传到额图片
        $files = $request->file('images');
        if(empty($files)){
            $result = ['error'=>'请上传图片'];
            ajaxReturn($result);
        }
        foreach($files as $key => $file){
            //将图片移动到public/uploads/vke
           $info = $file->move(ROOT_PATH.'public'.DS.'uploads'.DS.'vk');
            if($info){
                // 输出 20160820/42a79759f284b767dfcb2a0197904287.jpg
                $url = str_replace('\\','/',$info->getSaveName());

                $name = substr($url,0,strrpos($url,'/')).'/'.md5(time()).'.jpg';
                $file_name = 'uploads/vk/'.$name;
                $compress = new Compress;
                $compress->getData(config('image_url').$url,1);
                $url = $compress->compressImg($file_name);

                $image_url[]= [
                    'image_url'=>config('image_url').$name
                ];
                $result = [
                    'data' => [
                        'image_url' => $image_url
                    ]
                ];
            }else{
                // 上传失败获取错误信息
               $result = ['error'=>$file->getError()];
            }
        }
        ajaxReturn($result);
    }

}