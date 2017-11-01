<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/10/31
 * Time: 17:37
 */
namespace app\weke\model;
use think\Model;
class PanicTime extends Model
{
    public function getPanicTime()
    {
        $list = $this
        ->where('status','eq',1)
        ->order('start_time','asc')
        ->field('panic_id,start_time,end_time')
        ->select();
        return $list;
    }
}