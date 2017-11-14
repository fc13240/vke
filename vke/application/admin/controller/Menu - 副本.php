<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/11/8
 * Time: 13:06
 */

namespace app\admin\controller;
use app\common\controller\Base;
use app\admin\model\AdminMenu;
use think\Request;
use think\Db;

class Menu extends Base
{
    /**
     * 菜单首页
     * @return array|\think\response\Json
     */
    public function index()
    {
        $admin_nav = new AdminMenu;
        $fields = 'id,pid,name,mca';
        $data= $admin_nav ->getData('sorts,id',$fields);
        $result = [
            'data' => [
                'menu' => $data,
                'data_menu' => $this->menu
            ]
        ];
        return resultArray($result);
    }

    /**
     * 添加菜单
     */
    public function addMenu()
    {
        $menuName = input('post.menu_name');
        $mca = strtolower(input('post.mca'));
        $data = [
            'name' => $menuName,
            'mca' => $mca
        ];
        auto_validate('Menu',$data,'add_1');
        //验证通过后添加数据库---添加菜单同时添加顶级权限
        $data_menu = [
            'pid' => 0,
            'name' => $menuName,
            'mca' => $mca
        ];
        $data_rule = [
            'pid' => 0,
            'name' =>$mca,
            'title' => $menuName,
        ];
        Db::startTrans();
        try{
            $menu_id = Db::name('admin_menu')->insertGetId($data_menu);
            $data_rule['menu_id'] = $menu_id;
            Db::name('auth_rule')->insert($data_rule);
            Db::commit();
            $result = [
                'data' => [
                    'message' => '添加成功'
                ]
            ];
        }catch (\Exception $e){
            Db::rollback();
            $result = [
                'error' => '添加失败'
            ];
        }
        return resultArray($result);
    }

    /**
     * 添加子菜单
     */
    public function addChildMenu()
    {
        $request = Request::instance();
        //接收菜单id
        $menu_id = $request->post('menu_id');
        $menu_name = $request->post('menu_name');
        $menu_mca = strtolower($request->post('menu_mca'));
        $data = [
            'pid' => $menu_id,
            'name' => $menu_name,
            'mca' => $menu_mca
        ];

        auto_validate('Menu',$data,'add_2');
        //验证该模块/控制器/方法是否已经存在
        $this->checkExist('AdminMenu','mca',$menu_mca);
        $id = model('AdminMenu')->addData($data);
        if($id){
            $result = [
                'data' => [
                    'message' => '添加成功'
                ]
            ];
        }else{

            $result = [
                'error' => '添加失败'
            ];
        }
        return resultArray($result);



    }
}