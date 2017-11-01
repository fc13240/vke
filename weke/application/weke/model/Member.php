<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/10/27 0027
 * Time: 15:19
 */
namespace app\weke\model;
use think\Model;
class Member extends Model
{
    public function setDecMemberAcer($member_id,$total_price)
    {
        $result = $this->where('member_id',$member_id)->setDec('member_acer',$total_price);
        if($result !== false){
            return true;
        }else{
            return false;
        }
    }
}