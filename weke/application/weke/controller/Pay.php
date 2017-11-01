<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/10/31
 * Time: 15:34
 */
namespace app\weke\controller;
use app\weke\controller\Common;
use app\weke\model\ExchangeOrder;
use think\Db;
class Pay extends Common
{
    /**
     * 后台确认积分商品发货之后,修改积分商品兑换订单
     * $order_num 被确认的订单号
     */
    public function callback($order_num)
    {
        //验证该订单
    }

    public function makeOrder($user_id,$product_id,$address_id,$number,$one_price,$total_price,$product_type)
    {
        //生成订单号
        $order_num = build_order_no();
        $acerProduct = model('ExchangeOrder');
        $acerProduct->data(
            [
                'member_id' => $user_id,
                'order_num' => $order_num,
                'product_type' => $product_type,
                'product_id' => $product_id,
                'address_id' => $address_id,
                'exchange_num' => $number,
                'status' => 1,
                'express_status'      => 1,
                'exchange_time' => date('Y-m-d H:i:s',time()),
                'one_acer' => $one_price,
                'total_acer' => $total_price,
                'is_able'  => 1
            ]
        );
        $result = $acerProduct->save();
        if($result !== false){
            //订单生成成功,返回订单号
            return $order_num;
        }else{
            return false;
        }
    }

    /**
     * 积分支付
     */
    public function acerPay($order_num)
    {
        //根据订单号查询订单信息
        $order = ExchangeOrder::get(['order_num'=>$order_num]);
        $orderInfo = $order->toArray();
        if($orderInfo){
            //订单生成成功,减少库存以及用户的元宝值
            //开启事务
            Db::startTrans();
            $productAcerStock = model('ProductAcer')->setDecStock($orderInfo['product_id']);
            $memberAcer = model('Member')->setDecMemberAcer($orderInfo['member_id'],$orderInfo['total_acer']);
            if($productAcerStock !== false && $memberAcer !== false){
                //修改订单状态为已支付
                $order->status = 2;
                if($order->save()){
                    Db::commit();
                    return [
                        'status' => '1',
                        'message' => '兑换成功,请耐心等待'
                    ];
                }else{
                    //修改订单为无效的订单,并且记录错误信息
                    db('exchange_order')->where('order_num',$order_num)->setField('is_able',2);
                    addErrorOrder($orderInfo['member_id'],$order_num,"支付状态修改失败");
                    Db::rollback();
                    return [
                        'status' => '0',
                        'message' => '兑换失败'
                    ];
                }
            }else{
                //修改订单为无效的订单,并且记录错误信息
                db('exchange_order')->where('order_num',$order_num)->setField('is_able',2);
                addErrorOrder($orderInfo['member_id'],$order_num,"库存或元宝信息修改失败");
                Db::rollback();
                return [
                    'status' => '0',
                    'message' => '兑换失败'
                ];
            }
        }else{
            return [
                'status' => '0',
                'message' => '兑换失败'
            ];
        }
    }
}