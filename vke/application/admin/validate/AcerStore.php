<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/11/14
 * Time: 10:22
 */

namespace app\admin\validate;
use think\Validate;

class AcerStore extends Validate
{
    protected $rule = [
        'product_id' => 'require',
        'is_sale' => 'require',
        'product_type' => 'require|in:1,2',
        'product_name' => 'require|max:100',
        'product_image' => 'require',
        'exchange_brief' => 'require|max:150',
        'content' => 'require|max:255',
        'stock' => 'require|number',
        'market_price' => 'require',
        'exchange_acer' => 'require|number'
    ];

    protected $message = [
        'product_id.require' => '请选择元宝商品',
        'is_sale.require' => '请选择上下架情况',
        'product_type.require' => '请选择商品类型',
        'product_type.in' => '请选择商品类型',
        'product_name.require' => '请输入商品名称',
        'product_name.max' => '请输入规定字数的商品名称',
        'product_image.require' => '请上传商品图片',
        'exchange_brief.require' => '请输入兑换说明',
        'exchange_brief.max' => '请输入规定字数内的兑换说明',
        'content.require' => '请输入商品详情',
        'content.max' => '请输入规定字数内的商品详情',
        'stock.require' => '请输入商品库存',
        'stock.number' => '请输入正确的数字',
        'market_price.require' => '请输入商品市场价',
        'exchange_acer.require' => '请输入兑换所需元宝数',
        'exchange_acer.number' => '请输入兑换所需元宝数'
    ];

    protected $scene = [
        'is_sale' => ['product_id','is_sale'],
        'add' => ['product_type','product_name','product_image','exchange_brief','content','stock','market_price','exchange_acer'],
        'edit' => ['product_id']
    ];
}