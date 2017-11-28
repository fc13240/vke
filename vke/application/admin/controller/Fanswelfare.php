<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/11/14
 * Time: 11:34
 */

namespace app\admin\controller;
use app\common\controller\Base;
use think\Request;
use think\Db;

class Fanswelfare extends Base
{
    /**
     * 管理 - 粉丝福利管理 - 粉丝福利banner - 20171114
     */
    public function banner()
    {
        //查询粉丝福利当前的banner
        $banner = cache('adminFansBanner');
        if(empty($banner)){
            $banner = model('vke/Banner')->getBannerList(2);
            cache('adminFansBanner',$banner);
        }

        $result = [
            'data' => [
                'banner' => $banner[0]['banner_image'],
                'url' => $banner[0]['banner_url']
            ]
        ];
        return resultArray($result);
    }

    /**
     * 管理-粉丝福利管理-修改banner - 20171114
     */
    public function editBanner()
    {
        $request = Request::instance();
        //接收图片路径
        $image_url = $request->post('banner_image');
        $banner_url = $request->post('banner_url');
        $old_image = $request->post('old_image');
        auto_validate('Banner',['banner_image'=>$image_url]);
        //执行修改
        $map = [
            'type_id' => 2
        ];
        $data = [
            'banner_image' => $image_url,
            'banner_url' => $banner_url
        ];
        $result_edit = model('Banner')->editData($map,$data);
        if($result_edit !== false){
            $result = [
                'data' => [
                    'message' => '修改成功'
                ]
            ];
            cache('adminFansBanner',null);
            if(!empty($old_image)){
                //删除原图片
                unlink($old_image);
            }
        }else{
            $result = [
                'error' => '修改成功'
            ];
        }
        return resultArray($result);
    }

    /**
     * 管理-粉丝福利管理-商品列表 - 20171114
     */
    public function productList()
    {
        $request = Request::instance();
//        //接收每页显示多少条数据
//        $page_limit = $request->post('page_limit');
//        if(empty($page_limit)){
//            return resultArray(['error'=>'请输入每页数据条数']);
//        }
//
//        $path = getPath();
        //查询正在上架的粉丝福利商品
        $order = ['id'=>'asc'];
        $is_new = $request->post('is_new');
        if(!empty($is_new)){
            $order = ['create_time'=>'desc'];
        }
        $map = [
            'store_type' => 2,
            'on_sale' => 1
        ];
        $fields = 'id,pict_url,title,brokerage,reserve_price,zk_final_price,coupon_number,volume,stock,fans_acer';
//        $list = model('Product')->getGoodsList($map,$fields,$path,$page_limit);
        $list = model('Product')->getGoodsList($map,$fields,$order);
        $result = [
            'data' => [
                'product_list' => $list
            ]
        ];
        return resultArray($result);
    }

    /**
     * 设置商品赠送元宝 - 20171114
     */
    public function setAcer()
    {
        $request = Request::instance();
        $acer = $request->post('acer');
        $product_id = $request->post('product_id');
        auto_validate('Acer',['id'=>$product_id,'acer'=>$acer],'edit');
        //执行修改
        $map['id'] = $product_id;
        $data['fans_acer'] = $acer;

        //判断该商品是否为粉丝福利
        $map_fans = [
            'id' => $product_id,
            'store_type' => 2
        ];
        $s = model('Product')->where($map_fans)->value('id');
        if(empty($s)){
            return resultArray(['error'=>'该商品不属于粉丝福利']);
        }

        $result_edit = model('Product')->editData($map,$data);
        if($result_edit !== false){
            $result = [
                'data' => [
                    'message' => '设置成功'
                ]
            ];
        }else{
            $result = [
                'error' => '设置失败'
            ];
        }
        return resultArray($result);

    }

    /**
     * 批量设置返元宝数量 - 20171128
     */
    public function batchSetAcer()
    {
        $product_id = input('post.product_id');
        $acer_num = input('post.acer_num');
        if(empty($product_id)){
            return resultArray(['error'=>'请选择粉丝福利商品']);
        }
        if(empty($acer_num)){
            return resultArray(['error'=>'请设置赠送元宝的数量']);
        }
        //验证该订单是否存在
        $product_id = $this->checkOrder($product_id);

        //执行修改
        $map = [
            'id' => ['in',$product_id],
            'store_type' => 2
        ];

        $result_edit = Db::name('product')->where($map)->update(['fans_acer'=>$acer_num]);
        if($result_edit !== false){
            $result = [
                'data' => [
                    'message' => '设置成功'
                ]
            ];
        }else{
            $result = [
                'error' => '设置失败'
            ];
        }

        return resultArray($result);
    }

    /**
     * 管理-粉丝福利管理-上下架 - 20171114
     */
    public function changeSale()
    {
        $request = Request::instance();
        //接收商品id
        $product_id = $request->post('product_id');
        auto_validate('Goods',['goods_id'=>$product_id],'fans');
        //执行修改
        $map['id'] = ['in',$product_id];
        $data['on_sale'] = 2;
        $result_edit = model('Product')->editData($map,$data);
        if($result_edit !== false){
            $result = [
                'data' => [
                    'message' => '下架成功'
                ]
            ];
        }else{
            $result = [
                'error' => '下架失败'
            ];
        }

        return resultArray($result);
    }

    /**
     * 批量验证订单是否存在/是否属于粉丝福利商品
     */
    public function checkOrder($product_id)
    {
        $id = [];
        foreach($product_id as $key => $value){
            $map = [
                'id' => $value,
                'store_type' => 2
            ];
            $result = Db::name('product')->where($map)->value('id');
            if(empty($result)){
               unset($product_id[$key]);
            }
        }
        return $product_id;
    }
}