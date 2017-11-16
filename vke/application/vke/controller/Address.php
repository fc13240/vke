<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/11/6
 * Time: 14:37
 */

namespace app\vke\controller;
use app\vke\controller\Common;
use think\Request;


class Address extends Common
{
    /**
     * 添加收货地址
     */
    public function addAddress()
    {
        $user_id = $this->user_id;
        $address = explode(' ',input('post.address'));
        if(count($address) < 3){
            return resultArray(['error'=>'请选择省市区']);
        }
        //验证数据
        $data = [
            'person_name' => trim(input('post.person_name')),
            'telephone' => trim(input('post.telephone')),
            'province' => $address[0],
            'country' => $address[1],
            'district' => $address[2],
            'address' => trim(input('post.detail')),
            'is_default' => input('is_default') ? trim(input('is_default')) : '2'
        ];
        $validate = validate('Address');
        if(!$validate->scene('add')->check($data)){
            return resultArray(['error'=>$validate->getError()]);
        }
        $model = model('Address');
        //判断默认地址
        if($data['is_default'] == 1){
            $model->where(['member_id'=>$user_id,'is_default'=>1])->update(['is_default'=>2]);
        }
        $data['member_id'] = $user_id;
        //添加数据
        $model->data($data);
        if($model->save()){
            $result = [
                'data' => [
                    'message' => '地址添加成功'
                ]
            ];
        }else{
            $result = [
                'error' => '地址添加失败'
            ];
        }
        return resultArray($result);

    }

    /**
     *收货管理
     */
    public function addressList()
    {
        $user_id = $this->user_id;
        $addressList = model('Address')->getAddressList($user_id);
        $result = [
            'data' => [
                'address_list' => $addressList
            ]
        ];

        return resultArray($result);
    }

    /**
     * 编辑收货地址
     */
    public function updateAddress()
    {
        $user_id = $this->user_id;
        $validate = validate('Address');
        $address_id = input('address_id');
        if(!$validate->scene('edit_id')->check(['id'=>$address_id])){
            return resultArray(['error'=>$validate->getError()]);
        }

        if(Request::instance()->isGet()){
            //查询地址信息
            $addressInfo = model('Address')->getAddressInfo($address_id,$user_id);
            if(empty($addressInfo)){
                return resultArray(['error'=>'该地址信息不存在']);
            }

            //数组重构------
                $addressInfo['address_array'][] =  $addressInfo['province'];
                $addressInfo['address_array'][] =  $addressInfo['country'];
                $addressInfo['address_array'][] =  $addressInfo['district'];
                unset($addressInfo['province']);
                unset($addressInfo['country']);
                unset($addressInfo['district']);
            //数组重构------
            $result = [
                'data' => [
                    'address_info' => $addressInfo
                ]
            ];
        }
        elseif(Request::instance()->isPost()){
            //验证数据
            $address = explode(' ',input('post.address'));
            if(count($address) < 3){
                return resultArray(['error'=>'请选择省市区']);
            }
            $data = [
                'person_name' => input('post.person_name'),
                'telephone' => input('post.telephone'),
                'province' => $address[0],
                'country' => $address[1],
                'district' => $address[2],
                'address' => input('post.detail'),
                'is_default' => input('is_default') ? input('is_default') : '2',
            ];
            $validate = validate('Address');
            if(!$validate->scene('add')->check($data)){
                return resultArray(['error'=>$validate->getError()]);
            }
            $uodateModel = model('Address');
            if($data['is_default'] == 1){
                $uodateModel->where(['member_id'=>$user_id,'is_default'=>1])->update(['is_default'=>2]);
            }
            if($uodateModel->save($data,['address_id'=>$address_id])){
                $result = [
                    'data' => [
                        'message' => '修改成功'
                    ]
                ];
            }else{
                $result = [
                    'error' => '修改失败'
                ];
            }
        }

        return resultArray($result);
    }

    /**
     * 删除收货地址 - 20171115
     */
    public function delAddress()
    {
        $user_id = $this->user_id;
        $address_id = input('post.address_id');
        if(empty($address_id)){
            return resultArray(['error'=>'请选择删除地址']);
        }
        //执行删除
        $result = model('Address')->where(['address_id'=>$address_id])->delete();
        if($result){
            //将最新修改的地址设为默认
            $newest = model('Address')->where('member_id',$user_id)->order('update_time','desc')->find();
            model('Address')->where('address_id',$newest['address_id'])->update(['is_default'=>1]);
            $result = [
                'data' => [
                    'message' => '删除成功'
                ]
            ];
        }else{
            $result = [
                'error' => '删除失败'
            ];
        }
        return resultArray($result);
    }
}