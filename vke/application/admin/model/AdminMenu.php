<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/11/8
 * Time: 9:23
 */

namespace app\admin\model;
use app\admin\model\Base;
use think\Auth;
use \traits\controller\Data;
use think\Db;


class AdminMenu extends Base
{
    /**
     * 获取全部菜单
     * @param  string $type tree获取树形结构 level获取层级结构
     * @return array       	结构数据
     */
    public function getData($order='',$fields=''){
        $data=Db::name('admin_menu')->field($fields)->order($order)->select();
        // 获取树形或者结构数据
            $data= Data::channelLevel($data,0,'id');
            // 显示有权限的菜单
            $auth=new Auth();
            foreach ($data as $k => $v) {
                if ($auth->check($v['mca'],session('user')['id'])) {
                    foreach ($v['_data'] as $m => $n) {
                        if(!$auth->check($n['mca'],session('user')['id'])){
                            unset($data[$k]['_data'][$m]);
                        }
                    }
                }else{
                    // 删除无权限的菜单
                    unset($data[$k]);
                }
        }
        return $data;
    }
}