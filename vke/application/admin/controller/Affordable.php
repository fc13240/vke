<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/11/13
 * Time: 13:37
 */

namespace app\admin\controller;
use app\common\controller\Base;
use think\Request;

class Affordable extends Base
{
    /**
     * 管理-专场页管理-首页 - 20171113
     */
    public function affordable()
    {
        $fields = 'id,store_name,image';
        $storeList = model('StoreType')->getStoreList($fields);
        $result = [
            'data' => [
                'store_list' => $storeList
            ]
        ];
        return resultArray($result);
    }

    /**
     * 管理-专场页管理-保存 - 20171113
     */
    public function save()
    {
        $request = $this->request;
        //分类id
        $store_id = $request->post('store_id');
        //接收图片路径
        $image = $request->post('image');
        //接收专场名称
        $store_name = $request->post('store_name');
        $data = [
            'store_id'=>$store_id,
            'image'=>$image,
            'store_name'=>$store_name
        ];
        auto_validate('Affordable',$data,'save');
        //检查该名称是否已经存在
        $this->checkExist('StoreType','store_name',$store_name);
        //执行修改
        unset($data['store_id']);
        $result_edit = model('StoreType')->editData(['id'=>$store_id],$data);
        if($result_edit !== false){
            $result = [
                'data' => [
                    'message' => '保存成功'
                ]
            ];
        }else{
            $result = [
              'error' => '保存失败'
            ];
        }

        return resultArray($result);
    }
}