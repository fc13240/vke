<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/11/8
 * Time: 9:40
 */

namespace app\admin\controller;
use app\common\controller\Base;

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
}