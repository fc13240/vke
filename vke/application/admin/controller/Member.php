<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/11/22
 * Time: 15:20
 */

namespace app\admin\controller;
use app\common\controller\Base;
use think\Request;

class Member extends Base
{
    /**
     * 用户数据-新增用户 - 20171122
     */
    public function newMember()
    {
        $start = input('post.start');
        $end = input('post.end');
        auto_validate('ShareData',['start'=>$start,'end'=>$end],'select');
        $start_tmp = strtotime($start.' 00:00:00');
        $end_tmp = strtotime($end.' 23:59:59');
        //查询这期间新增的用户数量
        for($i=$start_tmp;$i<=$end_tmp;$i+=86400){
            $start_time = date('Y-m-d',$i).' 00:00:00';
            $end_time = date('Y-m-d',$i).' 23:59:59';
            $map['create_time'] = ['between',[$start_time,$end_time]];
            $count = model('Member')->getNewCount($map);
            $data[] = [
                'date' => date('d',$i),
                'count' => $count
            ];
        }
        $result = [
            'data' => $data
        ];
        return resultArray($result);
    }

    /**
     * 用户数据导出 - 20171122
     */
    public function exportNewMember()
    {

    }
}