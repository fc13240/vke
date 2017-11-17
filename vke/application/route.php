<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------
use think\Route;
//前台路由配置
Route::rule([
    //首页-banner
    'index_banner' => 'vke/Index/index_banner',
    //首页-商品分类
    'index_type' => 'vke/Index/index_type',
    //首页-商店
    'index_store_type' => 'vke/Index/index_store_type',
    //首页-商品
    'index_goods' => 'vke/Index/index_goods',
    //商品列表页
    'goodslist' => 'vke/Goods/goodsList',
    //商品列表页-分类
    'goodslist_type' => 'vke/Goods/goodsListType',
    //我的兑换
    'myexchange' => 'vke/Myexchange/myExchange',
    //兑换记录-分类
    'myexchange_type' => 'vke/Myexchange/myExchangeType',
    //会员元宝数
    'member_acer' => 'vke/Ucenter/getMemberAcer',
    //兑换记录-已免单金额
    'myexchange_free' => 'vke/Myexchange/myExchangeFree',
    //兑换积分商品
    'exchange' => 'vke/Acerstore/exchangeProduct',
    //粉丝福利-banner
    'fanswelfare_banner' => 'vke/Fanswelfare/fansWelfareBanner',
    //粉丝福利-商品
    'fanswelfare' => 'vke/Fanswelfare/fansWelfare',
    //粉丝福利-分类
    'fanswelfare_type' => 'vke/Fanswelfare/fansWelfareType',
    //超值线报-banner
    'newspaper_banner' => 'vke/Fanswelfare/newsPaperBanner',
    //超值线报-商品
    'newspaper_goods' => 'vke/Fanswelfare/newsPaperGoods',
    //超值线报-抢购时间
    'newspaper_time' => 'vke/Fanswelfare/newsPaper',
    //超实惠-9.9-banner
    'c_index_nine' => 'vke/Affordable/indexNine',
    //超实惠-9.9-banner
    'c_index_nineteen' => 'vke/Affordable/indexNineteen',
    //超实惠-聚折扣
    'c_index_discount' => 'vke/Affordable/indexDiscount',
    //超实惠-应季必备
    'c_index_season' => 'vke/Affordable/indexSeason',
    //9.9专区-排序方式
    'nine_sort' => 'vke/Affordable/nineSort',
    //9.9专区-排序方式
    'nine' => 'vke/Affordable/nine',
    //聚折扣
    'discount' => 'vke/Affordable/discount',
    //应季必备-banner
    'season_banner' => 'vke/Affordable/seasonBanner',
    //应季必备-商品
    'seasonindex' => 'vke/Affordable/seasonIndex',
    //兑换详情-商品详情
    'exchangeinfo' => 'vke/Acerstore/exchangeInfo',
    //兑换详情-默认地址
    'exchangeinfo_address' => 'vke/Acerstore/exchangeInfoAddress',
    //通知列表
    'getmessage' => 'vke/Message/getMessage',
    //提价意见反馈
    'feedback' => 'vke/Feedback/feedback',
    //个人中心
    'center' => 'vke/Ucenter/center',
    //签到页面-签到奖励
    'signpage_reward' => 'vke/Sign/signPage',
    //签到页面-一周签到详情
    'signpage_week' => 'vke/Sign/signPageWeek',
    //签到页面-兑换记录
    'signpage_history' => 'vke/Sign/signPageHistory',
    //执行签到
    'dosign' => 'vke/Sign/doSign',
    //用户个人信息
    'userinfo' => 'vke/Ucenter/userInfo',
    //商品详情
    'goodsdetail' => 'vke/Goods/goodsDetail',
    //我的足迹
    'footprint' => 'vke/Ucenter/getFootPrint',
    //收货地址
    'address_list' => 'vke/Address/addressList',
    //添加收货地址
    'addAddress' => 'vke/Address/addAddress',
    //编辑收货地址
    'updateAddress' => 'vke/Address/updateAddress',
    //删除收货地址
    'delAddress' => 'vke/Address/delAddress',
    //晒单
    'shareOrder' => 'vke/Shareorder/shareOrder',
    //添加订单
    'addOrder' => 'vke/Order/addOrderPage',
    //我的订单
    'myOrder' => 'vke/Order/myOrder',
    //积分商城列表
    'acerList' => 'vke/Acerstore/acerList',
    //我的晒单列表
    'myShareOrder' => 'vke/Shareorder/myShareOrder',
    //晒单广场
    'orderSquare' => 'vke/Shareorder/orderSquare',
    //搜索页面-搜索历史
    'searchPage' => 'vke/Search/searchPage',
    //搜索页面-热门推荐
    'searchHot' => 'vke/Search/searchPageHot',
    //搜索页面-默认搜索项
    'searchDefault' => 'vke/Search/searchDefault',
    //执行搜索
    'doSearch' => 'vke/Search/doSearch',
    //智搜页面
    'AIsearch' => 'vke/Search/AIsearch',
    //获得会员元宝数
    'member_acer' => 'vke/Ucenter/getMemberAcer',
    //上传图片
    'upload' => 'vke/Index/upload',
    //清空消息列表
    'delMessage' => 'vke/Message/delMessage',
    //清空我的足迹
    'delPrint' => 'vke/Ucenter/delPrint',
    //清空搜索历史
    'delSearch' => 'vke/Search/delSearch',
    //搜索结果的排序
    'serrchSort' => 'vke/Search/searchSort',
    //晒单说明
    'shareBrief' => 'vke/Shareorder/shareBrief'
]);

Route::rule('manager/:c/:a','admin/:c/:a');

return [
    '__pattern__' => [
        'name' => '\w+',
    ],
    '[hello]'     => [
        ':id'   => ['index/hello', ['method' => 'get'], ['id' => '\d+']],
        ':name' => ['index/hello', ['method' => 'post']],
    ],

];
