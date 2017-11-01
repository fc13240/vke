<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/10/27 0027
 * Time: 09:43
 */
namespace app\weke\model;

use think\Model;

class Banner extends Model
{
    protected $type = [
        'banner_name' => 'string',
        ' banner_image' => 'string'
    ];

    public function getBannerList($type)
    {
        $bannerList = $this
            ->where('type_id','eq',$type)
            ->where('status','eq','1')
            ->order('sorts','desc')
            ->field('banner_image,banner_url')
            ->select();
        return $bannerList;
    }
}