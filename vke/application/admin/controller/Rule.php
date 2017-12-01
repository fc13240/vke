<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/11/8
 * Time: 14:38
 */

namespace app\admin\controller;
use app\common\controller\Base;
use think\Request;
use traits\controller\Data;
use app\admin\model\AuthRule;
use app\admin\model\AuthGroup;
use app\admin\model\AdminUsers;
use think\Db;

class Rule extends Base
{
/*****************************************权限start**********************************************************/
    /**
     * 权限列表-20171108
     */
    public function index()
    {
        //获取权限列表
        $ruleList = AuthRule::getRuleList();
        $list = Data::channelLevel($ruleList);
        $result = [
            'data' =>[
                'list' => $list,
                'data_menu' => $this->menu
            ]
        ];
        return resultArray($result);
    }

    /**
     * 添加权限-顶级权限-20171108
     */
    public function addRule()
    {
        //接受权限名和模块/控制器/方法
        $rule_name = trim(input('post.rule_name'));
        $mca = trim(strtolower(input('post.rule_mca')));
        $data = [
            'title' => $rule_name,
            'name' => $mca
        ];
        auto_validate('Rule',$data,'add');
        //验证该权限是否已经存在
        $this->checkExist('AuthRule','name',$mca);

        //添加数据库
        $id = model('AuthRule')->addData($data,'id');
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

    /**
     * 修改权限-20171108
     */
    public function editRule()
    {
        $rule_id = input('post.rule_id');
        if(empty($rule_id)){
            return $this->addRule();
        }

        $rule_name = trim(input('post.rule_name'));
        $rule_mca = trim(strtolower(input('post.rule_mca')));
        $data = [
            'id' => $rule_id,
            'title' => $rule_name,
            'name' => $rule_mca
        ];
        //数据验证
        auto_validate('Rule',$data,'edit');
        //验证该方法是否已经存在
        $this->checkExist('AuthRule','name',$rule_mca,['id'=>['neq',$rule_id]]);
        //修改
        $map = ['id'=>$rule_id];
        unset($data['id']);
        $result = model('AuthRule')->editData($map,$data);
        if($result !== false){
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
        return resultArray($result);
    }

    /**
     * 删除权限-20171108
     */
    public function delRule()
    {
        $rule_id = input('post.rule_id');
        auto_validate('Rule',['id_del'=>$rule_id],'del');
        //执行删除
        $map = ['id'=>$rule_id];
        $result = model('AuthRule')->delData($map);
        if($result){
            $result1 = [
                'data' => [
                    'message' => '删除成功'
                ]
            ];
        }else{
            $result1 = [
                'error' => '删除失败'
            ];
        }
        return resultArray($result1);
    }

    /**
     * 添加子权限-20171108
     */
    public function addChildRule()
    {
        $parent_id = input('post.rule_id');
        $rule_name = trim(input('post.rule_name'));
        $rule_mca = trim(input('post.rule_mca'));
        $data = [
            'id_add' => $parent_id,
            'title' => $rule_name,
            'name' => $rule_mca
        ];
        auto_validate('Rule',$data,'add_child');
        //验证父级权限是否存在
        $parent_rule = AuthRule::get($parent_id);
        if(empty($parent_rule)){
            return resultArray(['error'=>'父级权限不存在']);
        }
        //验证该方法是否存在
        $this->checkExist('AuthRule','name',$rule_mca);
        unset($data['id_add']);
        //添加数据
        $data['pid'] = $parent_id;
        $id = model("AuthRule")->addData($data);
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
/******************************************权限end********************************************************/


/******************************************分组start*******************************************************/
    /**
     * 分组管理*分组列表-20171108
     */
    public function group()
    {
        //查询所有启用的用户组
        $groupList = model("AuthGroup")->getGroupList();
        $result = [
            'data' => [
                'group_list' => $groupList
            ]
        ];

        return resultArray($result);
    }

    /**
     * 添加分组-20171108
     */
   public function addGroup()
   {
       $groupName = trim(input('post.group_name'));
       if(empty($groupName)){
           return resultArray(['error'=>'请输入组名']);
       }
       //查询该组名称是否已经存在
       $this->checkExist('AuthGroup','title',$groupName);

       //添加组
       $id = model('AuthGroup')->addData(['title'=>$groupName]);
       if($id){
           return resultArray([
               'data' => [
                   'message' => '添加成功'
               ]
           ]);
       }else{
           return resultArray([
                'error' => '添加失败'
           ]);
       }
   }

   /**
    * 修改分组-20171108
    */
   public function editGroup()
   {
       $group_id = input('post.id');
       if(empty($group_id)){
           return $this->addGroup();
       }
       $group_name = trim(input('post.group_name'));
        $data = [
            'id' => $group_id,
            'title' => $group_name
        ];
        auto_validate('Group',$data,'edit');
        //验证该组id是否存在
       $id = model('AuthGroup')->where('id',$group_id)->value('id');
       if(empty($id)){
           return resultArray(['error'=>'该分组不存在']);
       }
        //验证分组名称是否已经存在
       $this->checkExist('AuthGroup','title',$group_name);
       //执行修改
       $map = [
           'id' => $group_id
       ];
       $edit_result = model('AuthGroup')->editData($map,$data);
       if($edit_result !== false){
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
       return resultArray($result);
   }

   /**
    * 删除分组-20171109
    */
   public function delGroup()
   {
       $group_id = input('post.id');
       auto_validate('Group',['id_del'=>$group_id],'del');
       $result = model('AuthGroup')->delData(['id'=>$group_id]);
       if($result){
           $result1 = [
               'data' => [
                   'message' => '删除成功'
               ]
           ];
       }else{
           $result1 = [
               'error' => '删除失败'
           ];
       }
       return resultArray($result1);
   }

   /**
    * 分配权限-20171109
    */
   public function allotRule()
   {
       $request = Request::instance();
       if($request->isGet()){
           $group_id = input('get.group_id');
           auto_validate('Group',['id_allot'=>$group_id],'allot');
           //查询所有权限
           $ruleList = AuthRule::getRuleList();
           $list = Data::channelLevel($ruleList);
           //查询该分组拥有权限
           $rule = model('AuthGroup')->getGroupRule($group_id);
           //$rule = toString($rule);

           //递归修改id为字符串
           $list = $this->toString($list,$field='id');
           $result = [
               'data' => [
                   'rule_list' => $list,
                   'have_rule' => $rule
               ]
           ];
       }
       elseif($request->isPost()){
           //分组id
           $group_id = \think\Request::instance()->post('group_id');
           auto_validate('Group',['id_allot'=>$group_id],'allot');
           //权限id
           $rule_id = \think\Request::instance()->post('rule_id/a');
           if(is_array($rule_id)){
               $rules = implode(',',$rule_id);
           }else{
               $rules = $rule_id;
           }

           //执行修改
           $map = [
               'id' => $group_id
           ];
           $data = [
               'rules' => $rules
           ];
           $edit_reuslt = model('AuthGroup')->editData($map,$data);
            if($edit_reuslt !== false){
                $result = [
                    'data' => [
                        'message'=>'分配成功'
                    ]
                ];
            }else{
                $result = [
                    'error' => '分配失败'
                ];
            }
       }
        return resultArray($result);
   }

   /**
    * 添加成员-查询被添加成员-20171109
    */
   public function addUser()
   {
       $request = Request::instance();
        if($request->isPost()){
            //验证分组id和管理员名称
            $group_id = input('post.group_id');
            auto_validate('Group',['id_allot'=>$group_id],'allot');
            //查询分组信息
            $group_name = model('AuthGroup')->getGroupName($group_id);
            $username = trim(input('post.username'));
            auto_validate('Users',['username'=>$username],'select');
           //查询该管理员是否存在
            $admin = model('AdminUsers')->where(['username'=>$username])->value('id');
            if(empty($admin)){
                $result = ['error'=>'该管理员不存在'];
            }else{
                //该管理员身份
                $admin_group_id = model('AuthGroupAccess')->getGroupId($admin);
                $result = [
                    'data' => [
                        'admin_id' => $admin,
                        'admin_group_id' => $admin_group_id,
                        'group_name' => $group_name,
                        'group_id' => $group_id
                    ]
                ];
            }
            return resultArray($result);
        }
   }

    /**
     * 添加管理员 - 20171201
     */
    public function searchUser()
    {
        $request = \think\Request::instance();
        $group_id = $request->post('group_id');
        $map['group_id'] = $group_id;
        $admin_id = model('AuthGroupAccess')->getGroupUsers($map);
        //查询所有成员
        $all_admin = model('AdminUsers')->getAdminId();

        $diff_admin = array_diff($all_admin,$admin_id);
        $map_admin = [
            'id' => ['in',$diff_admin]
        ];
        $fields = 'id,username';
        $admin = model('AdminUsers')->getUsers($map_admin,$fields);
        $admin = $this->toString($admin,'id');
        $result = [
            'data' => [
                'admin' => $admin
            ]
        ];
        return resultArray($result);
    }


   /**
    * 执行添加成员-20171109
    */
   public function doAdduser()
   {
        $group_id = input('post.group_id');
        $admin_id = \think\Request::instance()->post('admin_id/a');

        $data = [
            'uid' => $admin_id,
            'group_id' => $group_id
        ];
        auto_validate('GroupUser',$data);
        //执行添加
       $map = [
           'uid' => ['in',$admin_id],
           'group_id' => $group_id
       ];
       $isexist = model('AuthGroupAccess')->where($map)->value('uid');
       if(empty($isexist)){
           Db::startTrans();
           try{
               foreach($admin_id as $key => $value){
                   $add_data = [
                       'uid' => $value,
                       'group_id' => $group_id,
                       'create_time' => date('Y-m-d H:i:s',time()),
                       'update_time' => date('Y-m-d H:i:s',time()),
                   ];
                    Db::name('auth_group_access')->insert($add_data);
               }
               Db::commit();
               $result = [
                   'data' => [
                       'message' => '添加成功'
                   ]
               ];
           }catch(\Exception $exception){
                Db::rollback();
               $result = [
                   'error' => '添加失败'
               ];
           }
       }else{
           $result = [
               'data' => [
                   'message' => '添加成功'
               ]
           ];
       }
       return resultArray($result);
   }
   /**********************************************分组end********************************************************/


   /**********************************************管理员start****************************************************/
    /**
     * 管理员列表-20171109
     */
   public function userList()
   {
        $userList = model('AdminUsers')->getUserList();
        foreach($userList as $key => $value){
            $group_id = model('AuthGroupAccess')->getGroupId($value['id']);
            $group_name = model('AuthGroup')->getGroupNameArray(array_values($group_id));
            $userList[$key]['group_name'] = $group_name;
        }
        $result = [
            'data' => [
                'user_list' => $userList
            ]
        ];
        return resultArray($result);
   }

    /**
     * 添加管理员-20171109
     */
    public function addAdmin()
    {
        $request = Request::instance();
        if($request->isGet()){
            //查询当前所有分组
            $groupList = model('AuthGroup')->getGroupList();
            $result = [
                'data' => [
                    'group_list' => $groupList
                ]
            ];
        }
        elseif($request->isPost()){
            $username = trim(input('post.username'));
            $telephone = trim(input('post.telephone'));
            $password = trim(input('post.password'));
            $group_id = \think\Request::instance()->post('group_id/a');
            $status = input('post.status');
            $data = [
                'username' => $username,
                'telephone' => $telephone,
                'password' => $password,
                'status' => $status
            ];
            auto_validate('Users',$data,'add');
            //判断该用户是否已经存在
            $this->checkExist('admin_users','username',$data['username']);
            //执行添加
            $data['create_time'] = date('Y-m-d H:i:s',time());
            $data['password'] = password_hash($data['password'],PASSWORD_DEFAULT);
            $data['status'] = $status;
            $id = model('AdminUsers')->addData($data);
            foreach($group_id as $key => $value){
                $group_data = [
                    'uid' => $id,
                    'group_id' => $value,
                    'create_time' => date('Y-m-d H:i:s',time()),
                    'update_time' => date('Y-m-d H:i:s',time())
                ];
                model('AuthGroupAccess')->addData($group_data);
            }

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
        }
        ajaxReturn($result);
    }

    /**
     * 修改管理员信息
     */
    public function editAdmin()
    {
        $request = Request::instance();
        if($request->method() == 'GET'){ //获取该管理员信息
            $admin_id = $request->get('admin_id');
            auto_validate('Users',['id'=>$admin_id],'edit');
            if(!AdminUsers::get($admin_id)){
                return resultArray(['error'=>'该管理员不存在']);
            }
            //查询管理员信息
            $fields = 'id,username,telephone,status';
            $userInfo = model('AdminUsers')->getUserInfo($admin_id,$fields);
            //查询该管理员所在组
            $user_group = model('AuthGroupAccess')->getGroupId($admin_id);
            $userInfo['group_id'] = $user_group;
            $userInfo['status'] = (string)$userInfo['status'];
            $result = [
                'data' => [
                    'user_info' => $userInfo
                ]
            ];
            return resultArray($result);
        }
        elseif($request->method() == 'POST'){
            $admin_id = $request->post('id');
            if(empty($admin_id)){
                $this->addAdmin();
            }
            $group_id = $request->post('group_id/a');
            $username = trim($request->post('username'));
            $password = trim($request->post('password'));
            $telephone = trim($request->post('telephone'));
            $status = $request->post('status');
            $data = [
                'id' => $admin_id,
                'username' => $username,
                'telephone' => $telephone,
            ];
            auto_validate('Users',$data,'edit_do');
            if(!empty($status))
            {
                $data['status'] = $status;
            }
            if(!empty($password)){
                $data['password'] = password_hash($password,PASSWORD_DEFAULT);
            }
            $map = [
                'id' => $admin_id
            ];

            //开启事物
            Db::startTrans();
            try{
                Db::name('admin_users')->where($map)->update($data);
                if(!empty($group_id)){
                    foreach($group_id as $key => $value){
                        $group_user = model('AuthGroupAccess')->where(['uid'=>$admin_id,'group_id'=>$value])->value('id');
                        if(empty($group_user)){
                            Db::name('auth_group_access')->insert(['uid'=>$admin_id,'group_id'=>$value]);
                        }
                    }
                }
                // 提交事务
                Db::commit();
                $result = [
                    'data' => [
                        'message' => '修改成功'
                    ]
                ];
            } catch (\Exception $e) {
                // 回滚事务
                Db::rollback();
                $result = [
                    'data' => [
                        'message' => '修改成功'
                    ]
                ];
            }
            return resultArray($result);
        }
    }

   /*********************************************管理员end*******************************************************/


   /**
    * 递归修改id为字符串类型 - 20171201
    */
   public function toString($list,$field='')
   {
       $list = toString($list,'id');
        foreach($list as $key => $value){
            if(!empty($value['_data'])){
                $list[$key]['_data']=$this->toString($value['_data'],'id');
            }
        }
        return $list;
   }
}