<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/11/24
 * Time: 9:39
 */

namespace app\admin\controller;
use app\common\controller\Base;
use think\Request;
use think\Loader;
use think\Db;
Loader::import('sdk.TopClient');
Loader::import('sdk.request.TbkItemGetRequest');
Loader::import('sdk.request.TbkItemConvertRequest');


class CollectProduct extends Base
{
    private $appkey = 'Test';
    private $secret = 'Test';
    private $adzone_id = '1';


    /**
     * 商品数据的采集 - 20171124
     */
    public function sdk()
    {
        $c = new \TopClient;
        $c->appkey = 'Test';
        $c->secretKey = 'Test';

        $req = new \TbkItemGetRequest;
        $req->setFields("num_iid,title,pict_url,small_images,reserve_price,zk_final_price,user_type,provcity,item_url,seller_id,volume,nick");
        $req->setQ("女装");
        $req->setCat("16,18");
        $resp = $c->execute($req);
        if($resp->total_results!=0) {
            $product = (array)$resp->results->n_tbk_item;
            //查询数据库中已有的商品
            $db_num_iid = db('product')->column('num_iid');
            //dump($product);
            foreach ($product as $key => $value) {
               if(!empty($value->small_images)){
                   $product[$key]->small_images = implode(',',$value->small_images);
               }
                if (!in_array($value->num_iid, $db_num_iid)) {
                    $insert_product[] = (array)$value;
                    $insert_num_iid[] = $value->num_iid;
                } else {
                    $update_product[] = (array)$value;
                    $update_num_iid[] = $value->num_iid;
                }
            }
            //对数据库商品分别执行修改语句和新增语句(首先转链)
            if(!empty($insert_num_iid)){
                $convert_insert = $this->convert(implode(',', $insert_num_iid));
                foreach($convert_insert as $key => $value){
                    $insert_product_end[] = array_merge($insert_product[$key], (array)$value);
                }
                Db::name('product')->insertAll($insert_product_end);
            }
            if(!empty($update_num_iid)){
                $convert_update = $this->convert(implode(',', $update_num_iid));
                foreach($convert_update as $key => $value){
                    $update_product_end[] = array_merge($update_product[$key], (array)$value);
                }
                Db::name('product')->where('num_iid', 'in', $update_num_iid)->update($update_product_end);
            }
        }
    }

    public function convert($num_iids)
    {
        $c = new \TopClient;
        $c->appkey = $this->appkey;
        $c->secretKey = $this->secret;
        $req = new \TbkItemConvertRequest;
        $req->setFields("num_iid,click_url");
        $req->setNumIids($num_iids);
        $req->setAdzoneId($this->adzone_id);
        $req->setPlatform("2");
        $req->setDx("1");
        $resp = $c->execute($req);
       if(empty($resp->error_response)){
            return (array)$resp->results->n_tbk_item;
       }
    }


}