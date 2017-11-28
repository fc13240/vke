<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/10/31
 * Time: 17:37
 */
namespace app\vke\model;
use think\Model;
use think\Db;

class PanicTime extends Model
{
    public function getPanicTime()
    {
        $list = Db::name('panic_time')
        ->where('status','eq',1)
        ->order('start_time','asc')
        ->field('panic_id,start_time,end_time')
        ->select();
        foreach($list as $key => $value){
            $list[$key]['start_time'] = substr($value['start_time'],0,5);
            $list[$key]['end_time'] = substr($value['end_time'],0,5);
        }
        return $list;
    }

    /**
     * 获取某一时间段 - 20171124
     */
    public function getTime($panic_id)
    {
        $map = [
            'panic_id' => $panic_id,
            'status' => 1
        ];
        $time = Db::name('panic_time')
            ->where($map)
            ->field('start_time,end_time')
            ->select();
        return $time;
    }
}