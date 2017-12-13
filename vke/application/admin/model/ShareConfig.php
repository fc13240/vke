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
            ->column('id,value');
        $message_arr = [];
        foreach($message as $key => $value){
            switch($key){
                case 2:
                    $message_arr['share_agree'] = $value;
                    break;
                case 3:
                    $message_arr['share_refuse'] = $value;
                    break;
                case 4:
                    $message_arr['express'] = $value;
                    break;
                case 5:
                    $message_arr['withdraw'] = $value;
                    break;
                case 6:
                    $message_arr['recharge'] = $value;
                    break;
                case 7:
                    $message_arr['examine_agree'] = $value;
                    break;
                case 8:
                    $message_arr['examine_refuse'] = $value;
                    break;
            }
        }
        return $message_arr;
    }
}