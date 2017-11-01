<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/10/26 0026
 * Time: 17:37
 */
namespace app\weke\controller;
use app\weke\controller\Common;
use think\Cookie;
class Goods extends Common
{
    //商品列表,参数分类id
    public function goodsList()
    {
        $goods_type = input('goodsType');
        $goods_type = 2;
        if(empty($goods_type) && $goods_type !== 0){
            return [
                'status'=>0,
                'message' => '参数错误'
            ];
        }
        //查询商品分类id
        $goodsTypeAll = model('CateType')->getGoodsType();

        if(!in_array($goods_type,array_keys($goodsTypeAll))){
            return [
                'status'=>0,
                'message' => '参数错误'
            ];
        }
        //根据分类id查询分类名称
        $typeName = $goodsTypeAll[$goods_type];
        //根据分类名称调用淘宝客接口查询商品数据
        $goodsList = [];
        //返回数据
        return [
            'goodsTypeNow' => $goods_type,   //当前分类id
            'allGoodsType' => $goodsTypeAll,
            'goodsList'    => $goodsList
        ];
    }

    //商品详情  需要传入商品id
    public function goodsDetail()
    {
        $goods_id = input('goods_id');
        if(empty($goods_id)){
            return [
                'status' => '0',
                'message' => '参数错误'
            ];
        }

        //根据商品id,调用接口查询商品信息
        $goods_detail = [];
        if(empty($goods_detail)){
            return [
                'status' => '0',
                'message' => '参数错误'
            ];
        }

        //浏览商品后,添加到我的浏览记录中   获取浏览历史时判断登录,根据登录状态获取不同的浏览历史
        //查询该会员是否登录
        $user_id = $this->user_id;
        if(!empty($user_id)){
            //根据会员id和商品id查询该会员该商品的浏览信息
            $footPrintId = model('MemberFootprint')->getFootId($user_id,$goods_id);

            if(!empty($footPrintId)){ //如果id不为空,更新该商品浏览次数
                db('member_footprint')->where('id',$footPrintId)->setInc('number');
            }else{
                $data = [
                    'member_id' => $user_id,
                    'product_id' => $goods_id,
                    'time' => date('Y-m-d H:i:s',time()),
                    'number' => 1
                ];
                db('member_footprint')->insert($data);
            }
        }else{  //未登录将浏览的商品id存到cookie中
            //cookie初始化
            cookie(['prefix' => 'weke_', 'expire' => 3600]);
            //查看当前cookie中是否存在该商品
            $goods_cookie = cookie('footprint');
            if(!empty($goods_cookie)){ //判断cookie是否已经储存浏览历史
                if(in_array($goods_id,array_keys($goods_cookie))){
                    $goods_cookie[$goods_id] = [
                        'num' => $goods_cookie[$goods_id]['num']+1,
                        'time' => date('Y-m-d H:i:s',time())
                    ];
                }else{
                    $goods_cookie[$goods_id] = ['num'=>1,'time'=>date('Y-m-d H:i:s',time())];
                }
            }else{
                $data = [
                    $goods_id => ['num'=>1,'time'=>date('Y-m-d H:i:s',time())]
                ];
                cookie('footprint',$data);
            }
        }

        return [
            'status' => '1',
            'message' => '请求成功',
            'data' => $goods_detail
        ];
    }


}