<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/10/27 0027
 * Time: 10:24
 */
namespace app\vke\controller;
use app\vke\model\ExchangeOrder;
class Myexchange extends Common
{
    public function _initialize()
    {
        parent::_initialize(); // TODO: Change the autogenerated stub
        //验证登录
        $this->checkLogin();
    }

    /**
     * 兑换记录-分类
     * @return array|\think\response\Json
     */
    public function myExchangeType()
    {
        $acerType = [
            [
                'acer_type' => '3',
                'type_name' => '全部'
            ],
            [
                'acer_type' => '1',
                'type_name' => '虚拟类'
            ],
            [
                'acer_type' => '2',
                'type_name' => '实物类'
            ],
        ];
        $result = [
            'data' => [
                'acer_type' => $acerType,
            ]
        ];
        return resultArray($result);
    }

    public function myExchange()
    {
        $user_id = $this->user_id;
        //累计成功免单
        $free_money = model('member')->getMemberFreeMoney($user_id);
        //接受类别，3为全部
        $typeNow = input('acer_type');
        if(empty($typeNow)){
            $typeNow = 3;
        }
        $acerGoods = model('ExchangeOrder')->getOrderAcerList($user_id,$typeNow);
        //累计成功免单
        $free_money = model('member')->getMemberFreeMoney($user_id);
        $result = [
            'data' => [
                'type_now' => $typeNow,
                'free_money' => $free_money,
                'acer_goods' => $acerGoods,

            ]
        ];
        return resultArray($result);
    }
}