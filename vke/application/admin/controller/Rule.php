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
       $group_id = input('post.group_id');
       $group_name = trim(input('post.group_name'));
        $data = [
            'id' => $group_id,
            'title' => $group_name
        ];
        auto_validate('Group',$data,'edit');

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
       $group_id = input('post.group_id');
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
           $result = [
               'data' => [
                   'rule_list' => $list,
                   'have_rule' => $rule
               ]
           ];
       }
       elseif($request->isPost()){
           //分组id
           $group_id = input('post.group_id');
           auto_validate('Group',['id_allot'=>$group_id],'allot');
           //权限id
           $rule_id = input('post.rule_id');
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
    * 执行添加成员-20171109
    */
   public function doAdduser()
   {
        $group_id = input('post.group_id');
        $admin_id = input('post.admin_id');
        $data = [
            'uid' => $admin_id,
            'group_id' => $group_id
        ];
        auto_validate('GroupUser',$data);
        //执行添加
       $isexist = model('AuthGroupAccess')->where($data)->value('uid');
       if(empty($isexist)){
          $result_add =  model('AuthGroupAccess')->data($data)->save();
          if($result_add){
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
            $data = [
                'username' => $username,
                'telephone' => $telephone,
                'password' => $password
            ];
            auto_validate('Users',$data,'add');
            //判断该用户是否已经存在
            $this->checkExist('admin_users','username',$data['username']);
            //执行添加
            $data['create_time'] = date('Y-m-d H:i:s',time());
            $data['password'] = password_hash($data['password'],PASSWORD_DEFAULT);

            $id = model('AdminUsers')->addData($data);
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
        return resultArray($result);
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
            $result = [
                'data' => [
                    'user_info' => $userInfo
                ]
            ];
            return resultArray($result);
        }
        elseif($request->method() == 'POST'){
            $admin_id = $request->post('admin_id');
            $group_id = $request->post('group_id');
            $username = trim($request->post('username'));
            $password = trim($request->post('password'));
            $telephone = trim($request->post('telephone'));
            $data = [
                'id' => $admin_id,
                'username' => $username,
                'telephone' => $telephone,
            ];
            auto_validate('Users',$data,'edit_do');

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

    /**
     * 获取管理员分组信息
     */
    public function getAdminGroup()
    {
        $admin_id = input('post.admin_id');
        auto_validate('Users',['id'=>$admin_id],'edit');
        if(!AdminUsers::get($admin_id)){
            return resultArray(['error'=>'该管理员不存在']);
        }
        //查询所有分组
        $all_groups = model('AuthGroup')->getGroupList();
        //查询该管理员所在分组
        $admin_groups = model('AuthGroupAccess')->getGroupId($admin_id);

        foreach($all_groups as $key => $value){
            if(in_array($value['id'],$admin_groups)){
                $all_groups[$key]['status'] = 1;
            }else{
                $all_groups[$key]['status'] = 2;
            }
        }
        $result = [
            'data' => [
                'all_groups' => $all_groups,
            ]
        ];
        return resultArray($result);
    }
   /*********************************************管理员end*******************************************************/

}