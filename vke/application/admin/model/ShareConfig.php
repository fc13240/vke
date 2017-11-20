<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/11/20
 * Time: 17:25
 */

namespace app\admin\model;
use app\admin\model\Base;
use think\Db;

class ShareConfig extends Base
{
    /**
     * 查询消息模板 - 20171120
     */
    public function getMessageDefault()
    {
        $map['id'] = ['gt',1];
        $message = Db::name('share_config')
            ->where($map)
            ->select();
        return $message;
    }
}