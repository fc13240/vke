<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/11/13
 * Time: 14:37
 */

namespace app\admin\controller;
use app\common\controller\Base;
use think\Request;

class Order extends Base
{
    protected $request;
    public function _initialize()
    {
        parent::_initialize(); // TODO: Change the autogenerated stub
        $this->request = Request::instance();
    }

    /**
     * 管理-订单管理-订单列表 - 20171113
     */
    public function orderList()
    {
        $request = $this->request;
        //接收筛选条件-下单日期
        $date = $request->post('date');
        //类别
        $type = $request->post('type');
        $map = [];
        if(!empty($date)){
            $map['exchange_time'] = $date;
        }
        if(!empty($type)){
            $map['product_type'] = $type;
        }

        //查询订单
        $orderList = model('ExchangeOrder')->getOrderList($map);

        $result = [
            'data' => [
                'order_list' => $orderList
            ]
        ];
        return resultArray($result);
    }

    /**
     * 管理-订单管理-发货操作 - 20171113
     */
    public function diliver()
    {
        $request = $this->request;
        //接受订单id
        $order_id = $request->post('order_id');
        if(empty($order_id)){
            return resultArray(['error'=>'请选择发货订单']);
        }
        $map['order_id'] = ['in',$order_id];
        //验证该订单状态
        $fields = 'is_able,status,order_num,express_status';
        $orderInfo = model('ExchangeOrder')->getOrderInfo($map,$fields);
        if(empty($orderInfo)){
            return resultArray(['error'=>'订单信息不存在']);
        }
        foreach($orderInfo as $key => $value){
            if($value['status'] == 1 || $value['is_able'] == 2 || $value['express_status'] != 1){
                return resultArray(['error'=>'订单号:'.$value['order_num'].'为无效订单']);
            }
        }

        //执行修改
        $data['express_status'] = 2;
        $result_edit = model('ExchangeOrder')->editData($map,$data);
        if($result_edit !== false){
            $result  = [
                'data' => [
                    'message' => '发货成功'
                ]
            ];
        }else{
            $result = [
                'error' => '发货失败'
            ];
        }
        return resultArray($result);
    }
}