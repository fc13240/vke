<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/11/13
 * Time: 17:40
 */

namespace app\admin\controller;
use app\common\controller\Base;
use think\Request;

class Acerstore extends Base
{
    protected $request;
    public function _initialize()
    {
        parent::_initialize(); // TODO: Change the autogenerated stub
        $this->request = Request::instance();
    }

    /**
     * 元宝商城管理 - 20171113
     */
    public function acerList()
    {
        $request = $this->request;
        //接收奖品类型
        $product_type = $request->post('product_type');
        //接收上架状态
        $is_sale = $request->post('is_sale');
        $map = [];
        if(!empty($product_type)){
            $map['product_type'] = $product_type;
        }

        if(!empty($is_sale)){
            $map['is_sale'] = $is_sale;
        }

        //查询积分商城商品
        $acerList = model('ProductAcer')->getProductAcer($map);
        $page = $acerList->render();
        $result = [
            'data' => [
                'acer_list' => $acerList,
                'page' => $page
            ]
        ];
        return resultArray($result);
    }

    /**
     * 上下架/一键上下架 - 20171114
     */
    public function changeSale()
    {
        $request = $this->request;
        //接受元宝商品id
        $goods_id = $request -> post('product_id');

        //接受上下架
        $is_sale = $request -> post('is_sale');
        $data = [
            'product_id' => $goods_id,
            'is_sale' => $is_sale
        ];
        auto_validate('AcerStore',$data,'is_sale');
        $map['product_id'] = ['in',$goods_id];
        //执行修改
        $result_edit = model('ProductAcer')->editData($map,$data);
        if($result_edit !== false){
            $result = [
                'data' => [
                    'message' => '操作成功'
                ]
            ];
        }else{
            $result = [
                'error' => '操作失败'
            ];
        }
        return resultArray($result);
    }

    /**
     * 添加元宝商品 - 20171114
     */
    public function addProductAcer()
    {
        $request = $this->request;
        //接收添加的数据
        $post = $request->post();
        auto_validate('AcerStore',$post,'add');
        //执行添加
        $post['add_time'] = date('Y-m-d H:i:s',time());
        $result_id = model('ProductAcer')->addData($post);
        if($result_id){
            $result = [
                'data' => [
                    'message' => '添加成功'
                ]
            ];
        }else{
            $result = [
                'error' => '添加失败'
            ];
        }
        return resultArray($result);
    }

    /**
     * 编辑元宝商城商品 - 20171115
     */
    public function editProductAcer()
    {
        if(Request::instance()->isGet()){
            //接收产品id
            $product_id = Request::instance()->get('product_id');
            auto_validate('AcerStore',['product_id'=>$product_id],'edit');
            //查询该产品信息
            $map['product_id'] = $product_id;
            $fields = 'product_id,product_image,small_images,market_price,exchange_acer,';
            $productInfo = model('ProductAcer')->getProductInfo($map,$fields);
        }
        elseif(Request::instance()->isPost()){

        }

    }
}