<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/11/27
 * Time: 17:08
 */

namespace app\admin\controller;
use think\Controller;

class Test extends Controller
{
    public function index()
    {
        return view('index');
    }
    public function test(){
        return view();
    }
    public function ajaxReturn()
    {
        return view();
    }
    public function testRoute($mca)
    {
        dump($mca);
    }
}