<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/11/6
 * Time: 14:39
 */

namespace app\vke\model;
use think\Model;
use think\Db;

class Address extends Model
{
    /**
     * 获得用户的地址列表
     */
    public function getAddressList($user_id)
    {
        $map = [
            'member_id' => $user_id
        ];
        $list = Db::table('vke_address')
            ->where($map)
            ->order('is_default asc')
            ->field('address_id,province,country,district,address,person_name,telephone,is_default')
            ->select();
        return $list;
    }

    /**
     * 获取地址详细信息
     */
    public function getAddressInfo($address_id,$user_id)
    {
        $map = [
            'member_id' => $user_id,
            'address_id' => $address_id
        ];
        $address = Db::table('vke_address')
            ->where($map)
            ->field('province,country,district,address,person_name,telephone,is_default')
            ->find();

        return $address;
    }

    /**
     * 获得用户默认地址
     */
    public function getDefaultAddress($user_id)
    {
        $address = Db::name('address')
            ->where(['member_id'=>$user_id,'is_default'=>1])
            ->field('address_id,province,country,district,address,person_name,telephone')
            ->find();
        if(empty($address)){
            $address = Db::name('address')
                ->where(['member_id'=>$user_id])
                ->field('address_id,province,country,district,address,person_name,telephone')
                ->order('update_time','desc')
                ->find();
        }
        return $address;
    }
}