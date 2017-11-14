<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/11/13
 * Time: 11:06
 */

namespace app\admin\model;
use app\admin\model\Base;
use think\Db;

class CateType extends Base
{
    /**
     * 获取分类列表 - 20171113
     */
    public function getCatelist($type,$pid=0)
    {
        $map = [
            'type' => $type,
            'pid' => $pid,
            'status' => 1
        ];
        $list = Db::name('cate_type')
            ->where($map)
            ->order('sorts','desc')
            ->field('id,pid,cate_name')
            ->select();
            foreach($list as $key => $value){
                if($value['pid'] == 0){
                    $list[$key]['child_menu'] = $this->getCatelist(1,$value['id']);
                }

            }
        return $list;
    }
}