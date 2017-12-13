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
    'api/index_banner' => 'vke/Index/index_banner',
    //首页-商品分类
    'api/index_type' => 'vke/Index/index_type',
    //首页-商店
    'api/index_store_type' => 'vke/Index/index_store_type',
    //首页-商品
    'api/index_goods' => 'vke/Index/index_goods',
    //商品列表页
    'api/goodslist' => 'vke/Goods/goodsList',
    //商品列表页-分类
    'api/goodslist_type' => 'vke/Goods/goodsListType',
    //我的兑换
    'api/myexchange' => 'vke/Myexchange/myExchange',
    //兑换记录-分类
    'api/myexchange_type' => 'vke/Myexchange/myExchangeType',
    //会员元宝数
    'api/member_acer' => 'vke/Ucenter/getMemberAcer',
    //兑换记录-已免单金额
    'api/myexchange_free' => 'vke/Myexchange/myExchangeFree',
    //兑换积分商品
    'api/exchange' => 'vke/Acerstore/exchangeProduct',
    //粉丝福利-banner
    'api/fanswelfare_banner' => 'vke/Fanswelfare/fansWelfareBanner',
    //粉丝福利-商品
    'api/fanswelfare' => 'vke/Fanswelfare/fansWelfare',
    //粉丝福利-分类
    'api/fanswelfare_type' => 'vke/Fanswelfare/fansWelfareType',
    //超值线报-banner
    'api/newspaper_banner' => 'vke/Fanswelfare/newsPaperBanner',
    //超值线报-商品
    'api/newspaper_goods' => 'vke/Fanswelfare/newsPaperGoods',
    //超值线报-抢购时间
    'api/newspaper_time' => 'vke/Fanswelfare/newsPaper',
    //超实惠-9.9-banner
    'api/c_index_nine' => 'vke/Affordable/indexNine',
    //超实惠-9.9-banner
    'api/c_index_nineteen' => 'vke/Affordable/indexNineteen',
    //超实惠-聚折扣
    'api/c_index_discount' => 'vke/Affordable/indexDiscount',
    //超实惠-应季必备
    'api/c_index_season' => 'vke/Affordable/indexSeason',
    //9.9专区-排序方式
    'api/nine_sort' => 'vke/Affordable/nineSort',
    //9.9专区-排序方式
    'api/nine' => 'vke/Affordable/nine',
    //聚折扣
    'api/discount' => 'vke/Affordable/discount',
    //应季必备-banner
    'api/season_banner' => 'vke/Affordable/seasonBanner',
    //应季必备-商品
    'api/seasonindex' => 'vke/Affordable/seasonIndex',
    //兑换详情-商品详情
    'api/exchangeinfo' => 'vke/Acerstore/exchangeInfo',
    //兑换详情-默认地址
    'api/exchangeinfo_address' => 'vke/Acerstore/exchangeInfoAddress',
    //通知列表
    'api/getmessage' => 'vke/Message/getMessage',
    //提价意见反馈
    'api/feedback' => 'vke/Feedback/feedback',
    //个人中心
    'api/center' => 'vke/Ucenter/center',
    //签到页面-签到奖励
    'api/signpage_reward' => 'vke/Sign/signPage',
    //签到页面-一周签到详情
    'api/signpage_week' => 'vke/Sign/signPageWeek',
    //签到页面-兑换记录
    'api/signpage_history' => 'vke/Sign/signPageHistory',
    //执行签到
    'api/dosign' => 'vke/Sign/doSign',
    //用户个人信息
    'api/userinfo' => 'vke/Ucenter/userInfo',
    //商品详情
    'api/goodsdetail' => 'vke/Goods/goodsDetail',
    //我的足迹
    'api/footprint' => 'vke/Ucenter/getFootPrint',
    //收货地址
    'api/address_list' => 'vke/Address/addressList',
    //添加收货地址
    'api/addAddress' => 'vke/Address/addAddress',
    //编辑收货地址
    'api/updateAddress' => 'vke/Address/updateAddress',
    //删除收货地址
    'api/delAddress' => 'vke/Address/delAddress',
    //晒单
    'api/shareOrder' => 'vke/Shareorder/shareOrder',
    //添加订单
    'api/addOrder' => 'vke/Order/addOrderPage',
    //我的订单
    'api/myOrder' => 'vke/Order/myOrder',
    //积分商城列表
    'api/acerList' => 'vke/Acerstore/acerList',
    //我的晒单列表
    'api/myShareOrder' => 'vke/Shareorder/myShareOrder',
    //晒单广场
    'api/orderSquare' => 'vke/Shareorder/orderSquare',
    //搜索页面-搜索历史
    'api/searchPage' => 'vke/Search/searchPage',
    //搜索页面-热门推荐
    'api/searchHot' => 'vke/Search/searchPageHot',
    //搜索页面-默认搜索项
    'api/searchDefault' => 'vke/Search/searchDefault',
    //执行搜索
    'api/doSearch' => 'vke/Search/doSearch',
    //智搜页面
    'api/AIsearch' => 'vke/Search/AIsearch',
    //获得会员元宝数
    'api/member_acer' => 'vke/Ucenter/getMemberAcer',
    //上传图片
    'api/upload' => 'vke/Index/upload',
    //清空消息列表
    'api/delMessage' => 'vke/AdminMessage/delMessage',
    //清空我的足迹
    'api/delPrint' => 'vke/Ucenter/delPrint',
    //清空搜索历史
    'api/delSearch' => 'vke/Search/delSearch',
    //搜索结果的排序
    'api/serrchSort' => 'vke/Search/searchSort',
    //晒单说明
    'api/shareBrief' => 'vke/Shareorder/shareBrief',
    //后台上传图片
    'api/manager/upload' => 'vke/Index/upload',
    //商品详情
    'api/goodsDetail' => 'vke/Goods/goodsDetail',
    //微信登录
    'api/wechatLogin' => 'vke/Wechat/index',
    //获取微信登录者信息
    'api/getUserInfo' => 'vke/Wechat/getUserInfo',
    'api/redirects' => 'vke/Redirects/redirects',
    //生成淘口令
    'api/command' => 'vke/Sdkproduct/createCommand',
    //淘抢购api
    'api/rob' => 'vke/Sdkproduct/robApi',
    //聚划算api
    'api/discount' => 'vke/Sdkproduct/discount',
    //测试
    'api/testCommand' => 'vke/Sdkproduct/testCommand',
    'api/testTurn' => 'vke/Sdkproduct/testCommand',
    //超值线报
    'api/overflow' => 'vke/Sdkproduct/overflowCoupon'
]);

Route::rule('manager/:c/:a','admin/:c/:a');

Route::rule([
    //小程序登录获得sessionKey
    'app/login' => 'apps/Login/getSessionKey',
    'app/checkMember' => 'apps/Member/checkMember'
]);
return [
    '__pattern__' => [
        'name' => '\w+',
    ],
    '[hello]'     => [
        ':id'   => ['user/hello', ['method' => 'get'], ['id' => '\d+']],
        ':name' => ['user/hello', ['method' => 'post']],
    ],

];
