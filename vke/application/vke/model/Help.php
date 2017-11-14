<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/11/6
 * Time: 17:16
 */

namespace app\vke\model;
use think\Model;
use think\Db;

class Help extends Model
{
    /**
     * 获得帮助信息
     */
    public function getHelpInfo($type)
    {
        $addOrderHelp = Db::table('vke_help')
            ->where('type',$type)
            ->where('status','eq','1')
            ->order('sorts','desc')
            ->field('image_url,content')
            ->select();
        return $addOrderHelp;
    }
}