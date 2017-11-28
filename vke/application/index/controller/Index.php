<?php
namespace app\index\controller;

use think\cache\driver\Memcache;
use think\cache\driver\Redis;

class Index
{
    public function index()
    {
        $memcache = new Memcache();
        $memcache->set('test1','Test');
        $test = $memcache->get('test1');
        echo $test;
    }
    public function redis()
    {
        $redis = new Redis();
        dump($redis);
    }
}
