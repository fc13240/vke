<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/11/2
 * Time: 9:21
 */
namespace app\vke\controller;
use app\vke\controller\Common;
class Api extends Common
{
    /**
     * 工厂模式,便于前台统一入口
     */
    public function call($method=""){
        $method = input('get.method');
        dump($method);die;
        $method_list = explode("_", $method, 2);
        if(count($method_list)<2){
            $this->dealError();
        }
        $class = ucfirst(strtolower($method_list[0]));
        $class = "app\\weke\\controller\\{$class}";
        if(!class_exists($class)){
            $this->dealError();
        }
        $ctrl = action($method_list[0]);
        $ctrl->$method_list[1]();
    }

    private function dealError(){
        $result = array(
            "result"  => "0",
            "info"    => "非法的访问！！！"
        );
        ajaxR($result);
    }
}