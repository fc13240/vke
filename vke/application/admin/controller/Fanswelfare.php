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

class Fanswelfare extends Base
{
    /**
     * 管理 - 粉丝福利管理 - 粉丝福利banner - 20171114
     */
    public function banner()
    {
        //查询粉丝福利当前的banner
        $banner = model('vke/Banner')->getBannerList(2);
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
        //接收每页显示多少条数据
        $page_limit = $request->post('page_limit');
        if(empty($page_limit)){
            return resultArray(['error'=>'请输入每页数据条数']);
        }

        $path = getPath();
        //查询正在上架的粉丝福利商品
        $map = [
            'store_type' => 2,
            'on_sale' => 1
        ];
        $fields = 'id,pict_url,title,brokerage,reserve_price,zk_final_price,coupon_number,volume,stock,fans_acer';
        $list = model('Product')->getGoodsList($map,$fields,$path,$page_limit);
        $result = [
            'data' => [
                'product_list' => $list,
                'page' => $list->render()
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
            'id' => ['in',$product_id],
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
}