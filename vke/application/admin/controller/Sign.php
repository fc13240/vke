<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/11/14
 * Time: 18:03
 */

namespace app\admin\controller;
use app\common\controller\Base;
use think\Request;

class Sign extends Base
{
    protected $request;
    public function _initialize()
    {
        parent::_initialize(); // TODO: Change the autogenerated stub
        $this->request = Request::instance();
    }

    /**
     * 管理-签到管理-一周签到情况 - 20171114
     */
    public function weekSign()
    {
        $week = getWeekTime();
        foreach($week as $key => $value){ //根据start 和 end查询签到情况
            $signCount = model('')->getSignCount();
        }

    }
}