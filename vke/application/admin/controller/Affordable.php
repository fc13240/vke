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
use think\Db;

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
        $store_type = $request->post('store_type/a');

        foreach($store_type as $key => $value){
            //检查该名称是否已经存在
            $this->checkExist('StoreType','store_name',$value['store_name']);
            //检查id是否存在
            $id = model('StoreType')->where(['id'=>$value['id']])->value('id');
            if(empty($id)){
                return resultArray(['error'=>'数据错误']);
            }
        }
        //执行修改
        $result_edit = model('StoreType')->saveAll($store_type);
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