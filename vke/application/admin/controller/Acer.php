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
            $config = db('acer_config')->field('id,rate,url,day_limit,month_limit')->find(1);

            $result = [
                'data' => [
                    'config' => $config
                ]
            ];

        }
        elseif(Request::instance()->isPost()){

            $config = Request::instance()->post();
            if(empty($config)){
                return resultArray(['error'=>'请输入配置']);
            }
            if(empty($config['rate'])){
                return resultArray(['error'=>'请输入积分汇率']);
            }
            //执行修改
            $map['id'] = 1;
            $result_edit = model('AcerConfig')->editData($map,$config);
            if($result_edit !== false){
                $result = [
                    'data' => [
                        'message' => '保存成功'
                    ]
                ];
            }else{
                $result = [
                    'error' => '保存失败'
                ];
            }
        }
        return resultArray($result);
    }
}