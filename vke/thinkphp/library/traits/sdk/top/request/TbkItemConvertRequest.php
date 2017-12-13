<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/12/13
 * Time: 17:14
 */

namespace traits\sdk\top\request;


class TbkItemConvertRequest
{
    private $fields;
    private $num_iids;
    private $adzone_id;
    private $unid;
    private $dx;
    private $apiParas = array();

    public function setFields($fields)
    {
        $this->fields = $fields;
        $this->apiParas["fields"] = $fields;
    }
    public function setNumIids($num_iid)
    {
        $this->num_iids = $num_iid;
        $this->apiParas["num_iids"] = $num_iid;
    }
    public function setAdzoneId($adzone_id)
    {
        $this->adzone_id = $adzone_id;
        $this->apiParas['adzone_id'] = $adzone_id;
    }
    public function setUnid($unid)
    {
        $this->unid = $unid;
        $this->apiParas['unid'] = $unid;
    }
    public function setDx($dx)
    {
        $this->dx = $dx;
        $this->apiParas['dx'] = $dx;
    }
    public function getApiMethodName()
    {
        return "taobao.tbk.item.convert";
    }

    public function getApiParas()
    {
        return $this->apiParas;
    }

    public function check()
    {
        \traits\sdk\top\RequestCheckUtil::checkNotNull($this->fields,"fields");
        \traits\sdk\top\RequestCheckUtil::checkNotNull($this->num_iids,"num_iids");
        \traits\sdk\top\RequestCheckUtil::checkNotNull($this->adzone_id,"adzone_id");
    }

    public function putOtherTextParam($key, $value) {
        $this->apiParas[$key] = $value;
        $this->$key = $value;
    }
}