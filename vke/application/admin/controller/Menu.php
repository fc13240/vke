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
use \traits\controller\Data;

class Menu extends Base
{
    public function totalMenu()
    {
        $fields = 'id,pid,name,mca,icon,url';
        $data=Db::name('admin_menu')->field($fields)->order('sorts,id','desc')->select();
        // 获取树形或者结构数据
        $data= Data::channelLevel($data,0,'id');
        $data_arr = [];
        foreach($data as $key => $value){
            $data_arr[] = $value;
        }
        foreach($data_arr as $key => $value){
            if(!empty($value['_data'])){
                $data_child = [];
                foreach($value['_data'] as $k => $v){
                    $data_child[] = $v;
                };
                $data_arr[$key]['_data'] = $data_child;
            }
        }
        $result = [
            'data' => [
                'menu'=>$data_arr
            ]
        ];
        return resultArray($result);
    }


    /**
     * 未读消息条数以及最新一条消息 - 20171121
     */
    public function unreadMessage()
    {
        //查询后台的未读消息
        $unreadCount = model('AdminMessage')->unreadCount();
        //查询最新的一条未读消息
        $latestMessage = model('AdminMessage')->latestMessage();
        if(empty($latestMessage)){
            $latestMessage = "";
        }
        $result = [
            'data' => [
                'count' => $unreadCount,
                'message' => $latestMessage
            ]
        ];
        return resultArray($result);
    }

    /**
     * 菜单首页
     * @return array|\think\response\Json
     */
    public function index()
    {
        $admin_nav = new AdminMenu;
        $fields = 'id,pid,name,mca,icon,url';
        $data= $admin_nav ->getData('sorts,id',$fields);

        $data_arr = [];
        foreach($data as $key => $value){
            $data_arr[] = $value;
        }
        foreach($data_arr as $key => $value){
            if(!empty($value['_data'])){
                $data_child = [];
                foreach($value['_data'] as $k => $v){
                    $data_child[] = $v;
                };
                $data_arr[$key]['_data'] = $data_child;
            }
        }


        foreach($data_arr as $key => $value){
            if(!empty($value['icon'])){
                $image_url = explode(',',$value['icon']);
                $data_arr[$key]['icon'] = $image_url[0];
                $data_arr[$key]['icon_blue'] = $image_url[1];
            }
        }
        $result = [
            'data' => [
                'menu' => $data_arr,
                //'data_menu' => $this->menu
            ]
        ];
        return resultArray($result);
    }

    /**
     * 菜单排序 - 20171121
     */
    public function menuSort()
    {
        $menu = input('post.menu');
        if(empty($menu)){
            return resultArray(['error'=>'修改失败']);
        }
        $menu_count = 300;
        $sort = [];
        foreach($menu as $key => $value){
            $sort[] = [
                'id' => $value['id'],
                'sorts' => $menu_count
            ];
            $menu_count--;
            if(!empty($value['_data'])){
                foreach($value['_data'] as $k => $v){
                    $sort[] = [
                        'id' => $v['id'],
                        'sorts' => $menu_count
                    ];
                    $menu_count--;
                }

            }
        }
        //执行修改
        $result_edit = model('AdminMenu')->saveAll($sort);
        if($result_edit !== false){
            $result = [
                'data' => [
                    'message' => '保存成功'
                ]
            ];
        }else{
            $result = [
                'error' => '保存失败'
            ];
        }
        return resultArray($result);
    }

    /**
     * 添加菜单-20171110
     */
    public function addMenu()
    {
        $menuName = trim(input('post.menu_name'));
        $mca = strtolower(input('post.menu_mca'));
        $url = trim(input('post.url'));
        $data = [
            'name' => $menuName,
            'mca' => $mca
        ];
        auto_validate('Menu',$data,'add_1');
        $this->checkExist('AdminMenu','mca',$mca);
        //验证通过后添加数据库---添加菜单同时添加顶级权限
        $data_menu = [
            'pid' => 0,
            'name' => $menuName,
            'mca' => $mca,
            'url' => $url
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
                'error' => $e->getMessage()
            ];
        }
        return resultArray($result);
    }

    /**
     * 添加子菜单-20171110
     */
    public function addChildMenu()
    {
        $request = Request::instance();
        //接收菜单id
        $menu_id = $request->post('menu_id');
        $menu_name = trim($request->post('menu_name'));
        $menu_mca = strtolower($request->post('menu_mca'));
        $url = trim($request->post('url'));
        $data = [
            'pid' => $menu_id,
            'name' => $menu_name,
            'mca' => $menu_mca,
            'url' => $url
        ];
        auto_validate('Menu',$data,'add_2');
        //根据菜单id查询权限id
        $rule_id = Db::name('auth_rule')->where(['menu_id'=>$menu_id])->value('id');
        $data_rule = [
            'pid' => $rule_id,
            'name' => $menu_mca,
            'title' => $menu_name
        ];
        auto_validate('Menu',$data,'add_2');
        //验证该模块/控制器/方法是否已经存在
        $this->checkExist('AdminMenu','mca',$menu_mca);
        //执行添加-添加同时添加权限
        Db::startTrans();
        try{
            $new_rule_id = Db::name('admin_menu')->insertGetId($data);
            $data_rule['menu_id'] = $new_rule_id;
            Db::name('auth_rule')->insert($data_rule);
            Db::commit();

            $result = [
                'data' => [
                    'message' => '添加成功'
                ]
            ];
        }catch(\Exception $e){

            Db::rollback();
            $result = [
                'error' => $e->getMessage()
            ];
        }
        return resultArray($result);
    }

    /**
     * 修改菜单-20171110
     */
    public function editMenu()
    {
        $request = Request::instance();
        if($request->method() == 'GET'){
            $menu_id = $request->get('menu_id');
            auto_validate('Menu',['pid'=>$menu_id],'edit');
            //验证该菜单id是否存在
            $menu = Db::name('admin_menu')
                ->where(['id'=>$menu_id])
                ->field('id,name,mca')
                ->find();
            if(empty($menu)){
                return resultArray(['error'=>'该菜单不存在']);
            }
            $result = [
                'data' => [
                    'menu_info' => $menu
                ]
            ];
            return resultArray($result);

        }
        elseif($request->method() == 'POST'){
            //接收菜单id
            $menu_id = $request->post('menu_id');
            if(empty($menu_id)){
                return $this->addMenu();
            }
            $menu_name = trim($request->post('menu_name'));
            $menu_mca = strtolower($request->post('menu_mca'));
            $menu_url = trim($request->post('url'));
            $data = [
                'pid' => $menu_id,
                'name' => $menu_name,
                'mca' => $menu_mca,
                'url' => $menu_url
            ];
            auto_validate('Menu',$data,'add_2');
            //验证模块/控制器/方法是否已经存在
            $this->checkExist('AdminMenu','mca',$menu_mca,['id'=>['neq',$menu_id]]);
            //验证该菜单id是否存在
            $menu = Db::name('admin_menu')->where(['id'=>$menu_id])->value('id');
            if(empty($menu)){
                return resultArray(['error'=>'该菜单不存在']);
            }
            unset($data['pid']);
            //执行修改
            $result_edit = model('AdminMenu')->editData(['id'=>$menu_id],$data);
            if($result_edit !== false){
                $result = [
                    'data' => [
                        'message' => '修改成功'
                    ]
                ];
            }else{
                $result = [
                    'error' => '修改失败'
                ];
            }
        }
        return resultArray($result);
    }

    /**
     * 删除菜单(包括该菜单下的权限)-20171110
     */
    public function delMenu()
    {
        //接收菜单id
        $request = Request::instance();
        $menu_id = $request->post('menu_id');
        //验证数据
        auto_validate('Menu',['pid'=>$menu_id],'edit');
        //查询该菜单所对应的权限
        $rule_id = Db::name('auth_rule')->where('menu_id',$menu_id)->value('id');
        //开启事物,删除菜单及权限
        Db::startTrans();
        try{
            //删除菜单
            Db::name('admin_menu')
                ->where('id',$menu_id)
                ->whereOr('pid',$menu_id)
                ->delete();
            //删除权限
            Db::name('auth_rule')
                ->where('id',$rule_id)
                ->whereOr('pid',$rule_id)
                ->delete();
            Db::commit();
            $result = [
                'data' => [
                    'message' => '删除成功'
                ]
            ];
        }catch(\Exception $e){
            Db::rollback();
            $result = [
                'error' => '删除失败'
            ];
        }
        return resultArray($result);
    }
}