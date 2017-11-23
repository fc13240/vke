<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/11/22
 * Time: 14:41
 */

namespace app\admin\model;
use app\admin\model\Base;
use think\Db;

class AcerNotes extends Base
{
    /**
     * 查询消耗元宝数 - 20171122
     */
    public function getAcerNumber($map)
    {
        $map['type'] = 1;
        $number = Db::name('acer_notes')
            ->where($map)
            ->sum('number');
        return $number;
    }
}