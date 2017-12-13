<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/11/8
 * Time: 9:07
 */

namespace app\common\controller;
use think\Auth;
use think\Request;
use think\Controller;
header("Access-Control-Allow-Origin: *"); // 允许任意域名发起的跨域请求
class Base extends Controller
{
    public $admin_id = 1;
    public $menu;
    private $appkey = 'Test';
    private $secret = 'Test';
    public function _initialize()
    {
//        $this->admin_id = session('user')['id'];
//        //验证登录
//        if(empty($this->admin_id)){
//             ajaxReturn(['error'=>'请登录']);
//        }


        $auth=new Auth();
        $request = Request::instance();
        //获得当前访问的模块
        $module = strtolower($request->module());
        //获得当前访问的控制器
        $controller = strtolower($request->controller());
        //获得当前的访问的方法
        $action = strtolower($request->action());
        $rule_name= $module.'/'.$controller.'/'.$action;
        if($this->admin_id != 1){
            $result=$auth->check($rule_name,$this->admin_id);
            if(!$result){
                $result_array = [
                    'error' => '您没有此操作权限'
                ];
                ajaxReturn($result_array);
            }
        }
        // 分配菜单数据
        $fields = 'id,pid,name,mca';
        $nav_data=model('AdminMenu')->getData('sorts,id',$fields);
        $this->menu = $nav_data;
    }

    /**
     * 验证某字段是否存在
     * @param $model  模型名
     * @param $field  字段
     * @param $string 值
     */
    protected function checkExist($model,$field,$string,$condition="")
    {
        $map = [
            $field=>  $string
        ];
        $isExist = model($model)->where($condition)->where($map)->find();
        if($isExist){
            ajaxReturn(['error'=>$string.'已经存在']);
        }
    }

    /**
     * 上传图片类
     */
    public function upload()
    {
        $request = Request::instance();
        //获取表单上传到额图片
        $files = $request->file('images');
        //dump($files);
        if (empty($files)) {
            $result = ['error' => '请上传图片'];
            ajaxReturn($result);
        }
        //将图片移动到public/uploads/vke
        $info = $files->validate(['size'=>'3145728','ext'=>'jpg,png,jpeg'])->move(ROOT_PATH . 'public' . DS . 'uploads' . DS . 'vk');
        if ($info) {
            // 输出 20160820/42a79759f284b767dfcb2a0197904287.jpg
            $url = str_replace('\\', '/', $info->getSaveName());
            $image_url = config('image_url') . $url;
            $result = [
                'data' => [
                    'image_url' => $image_url
                ]
            ];

        } else {
            // 上传失败获取错误信息
            $result = ['error' => $files->getError()];
        }
        ajaxReturn($result);
    }

/*****************************************************************************************************/

}