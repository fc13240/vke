<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/11/8
 * Time: 9:40
 */

namespace app\admin\controller;
use app\common\controller\Base;
use think\Request;

class Index extends Base
{
    public function index()
    {
        $result = [
            'data' => [
                'data_menu' => $this->menu
            ]
        ];
        return resultArray($result);
    }

    /**
     * 管理-首页管理 - 20171115
     */
    public function setBanner()
    {
        if(Request::instance()->isGet()){
            //查询首页分类
            $index_cate = model('CateType')->getIndexCate();
            $result = [
                'data' => [
                    'index_cate' => $index_cate
                ]
            ];
            return resultArray($result);
        }
        elseif(Request::instance()->isPost()){

        }

    }
}