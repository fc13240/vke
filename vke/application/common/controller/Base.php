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

class Base extends Controller
{
    public $admin_id;
    public $menu;
    public function _initialize()
    {
        $this->admin_id = session('user')['id'];
        //验证登录
        if(empty($this->admin_id)){
             ajaxReturn(['error'=>'请登录']);
        }


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
}