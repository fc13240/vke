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
        //验证数据
        $data = [
            'person_name' => trim(input('post.person_name')),
            'telephone' => trim(input('post.telephone')),
            'province' => trim(input('post.province')),
            'country' => trim(input('post.country')),
            'district' => trim(input('post.district')),
            'address' => trim(input('post.address')),
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
            $result = [
                'data' => [
                    'address_info' => $addressInfo
                ]
            ];
        }
        elseif(Request::instance()->isPost()){
            //验证数据
            $data = [
                'person_name' => input('person_name'),
                'telephone' => input('telephone'),
                'province' => input('province'),
                'country' => input('country'),
                'district' => input('district'),
                'address' => input('address'),
                'is_default' => input('is_default') ? input('is_default') : '2',
            ];
            $validate = validate('Address');
            if(!$validate->scene('add')->check($data)){
                return resultArray(['error'=>$validate->getError()]);
            }
            $uodateModel = model('Address');
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
}