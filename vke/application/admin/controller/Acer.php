<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/11/15
 * Time: 10:59
 */

namespace app\admin\controller;
use app\common\controller\Base;
use think\Request;

class Acer extends Base
{
    /**
     * 积分管理 - 20171115
     */
    public function acerConfig()
    {
        if(Request::instance()->isGet()){ //查询积分配置
            $config = db('acer_config')->select(1);
            if(empty($config)){
                $config[] = [
                    'id' => '',
                    'rate' => '',
                    'url' => '',
                    'day_limit' => '',
                    'month_limit' => ''
                ];
            }
            $result = [
                'data' => [
                    'config' => $config
                ]
            ];
            return resultArray($result);
        }
        elseif(Request::instance()->isPost()){

        }
    }
}