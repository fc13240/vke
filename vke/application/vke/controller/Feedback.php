<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/11/3
 * Time: 15:31
 */

namespace app\vke\controller;
use app\vke\controller\Common;

class Feedback extends Common
{
    /**
     * 意见反馈
     */
    public function feedback()
    {
        //接受并验证数据
        $msg = input('msg');
        $telephone = input('telephone');
        $data = [
            'telephone' => $telephone,
            'msg' => $msg
        ];
        $validate = validate('Feedback');
        if(!$validate->check($data)){
            return resultArray(
                ['error'=>$validate->getError()]
            );
        }
        $user_id = $this->user_id;
        $model = model('Feedback');
        $model->data([
            'msg'=>$msg,
            'telephone' => $telephone,
            'member_id' => $user_id,
        ]);
        if($model->save()){
            return resultArray([
                'data' => [
                    'message' => '提交成功'
                ]
            ]);
        }else{
            return resultArray(['error'=>'提交失败']);
        }
    }
}