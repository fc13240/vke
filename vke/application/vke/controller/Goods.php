<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/10/26 0026
 * Time: 17:37
 */
namespace app\vke\controller;
use app\vke\controller\Common;
use think\Cookie;
use app\vke\model\CateType;
use app\vke\model\TypeHistory;
use think\Request;

class Goods extends Common
{
    //商品列表-分类
    public function goodsListType()
    {
        $cate_id = input('post.cate_id');
        auto_validate('Cate',['cate_id'=>$cate_id]);
        //验证该分类是否存在
        $cate = CateType::get($cate_id);
        if(empty($cate)){
            return resultArray(['error'=>'该分类不存在']);
        }

        $goodsTypeAll = model('CateType')->getChildGoodsType($cate_id);
        $result = [
            'data' => [
                'allGoodsType' => $goodsTypeAll
            ]
        ];
        return resultArray($result);
    }
    //商品列表,参数分类id
    public function goodsList()
    {
        $request = Request::instance();
        if($request->method() == 'POST'){
            $goods_type = $request->post('cate_id');
        }
        if(!isset($goods_type)){
            return resultArray(['error'=>'参数错误']);
        }
        //记录商品分类的点击次数
        $typeModel = new TypeHistory;
        $typeModel->type_id = $goods_type;
        $typeModel->save();

        //根据分类id调用淘宝客接口查询商品数据
        $fields = "id,title,pict_url,small_images,reserve_price,volume,zk_final_price,cat_name";
        $goodsList = model('Product')->getIndexGoods($goods_type,'',$fields);
        $goods_count = count($goodsList);
        //返回数据
        $result = [
            'data' => [
                'cate_id_now' => $goods_type,   //当前分类id
                'goodsList'    => $goodsList,
                'goods_count' => $goods_count
            ]
        ];
        return resultArray($result);
    }

    //商品详情  需要传入商品id
    public function goodsDetail()
    {
        $goods_id = input('goods_id');
        if(empty($goods_id)){
            return resultArray(['error'=>'参数错误']);
        }

        //根据商品id,调用接口查询商品信息
        $fields = "id,num_iid,title,pict_url,small_images,reserve_price,zk_final_price,provcity,volume";
        $goods_detail = model('Goods')->getProductInfo($goods_id,$fields);
        if(empty($goods_detail)){
            return resultArray(['error'=>'参数错误']);
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
            cookie(['prefix' => 'vke_', 'expire' => 3600]);
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

        $result = [
            'data' => $goods_detail
        ];
        return resultArray($result);
    }


}