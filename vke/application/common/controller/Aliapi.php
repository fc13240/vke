<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/12/13
 * Time: 16:07
 */

namespace app\common\controller;


class aliapi
{
    public function requestApi($req)
    {
        $c = new \traits\sdk\top\TopClient;
        $c->appkey = config('app_key');
        $c->secretKey = config('app_secret');
        $resp = $c->execute($req);
        return $resp;
    }
}