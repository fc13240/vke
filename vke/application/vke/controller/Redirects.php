<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/12/11
 * Time: 18:40
 */

namespace app\vke\controller;
use think\Controller;
use app\vke\controller\Wechat;
use think\Request;

class Redirects extends Controller
{
    public function redirects()
    {
        $action = Request::instance()->get('action');
        $action_arr = explode('_',$action);
        if(count($action_arr) > 1){
            $action = implode('/',$action_arr);
        }
        $this->redirect('http://www.dxvke.com/api/wechatLogin?action='.$action);
    }
}