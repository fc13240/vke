<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/11/8
 * Time: 9:40
 */

namespace app\admin\controller;
use app\common\controller\Base;
use think\Request;
use think\Db;


class Index extends Base
{
    public function index()
    {
        $result = [
            'data' => [
                'data_menu' => $this->menu
            ]
        ];
        return resultArray($result);
    }

    /**
     * 管理-首页管理-首页banner - 20171117
     */
    public function indexBanner()
    {
        if(Request::instance()->isGet()){
            //查询首页banner
            $list = model('vke/Banner')->getBannerList(1);
            $result = [
                'data' => [
                    'banner_list' => $list
                ]
            ];
            return resultArray($result);
        }
        elseif(Request::instance()->isPost()){
            //修改后的banner图
            $banner_list = Request::instance()->post();
            if(!empty($banner_list)){
                //删除首页下所有banner
                $del_result = model('Banner')->where('type_id',1)->delete();
                if(!$del_result){
                    return resultArray(['error'=>'操作失败']);
                }
            }

            //去掉banner_id
            foreach($banner_list as $key => $value){
                if(!empty($value['banner_id'])){
                    unset($banner_list[$key]['banner_id']);
                }
                $banner_list[$key]['type_id'] = 1;

            }
            //执行修改
            $result_edit = model('Banner')->saveAll($banner_list);
            if($result_edit){
                $result = [
                    'data' => [
                        'message' => '操作成功'
                    ]
                ];
                cache('index_banner',null);
            }
            else{
                $result = [
                    'error' => '操作失败'
                ];
            }
            return resultArray($result);
        }
    }

    /**
     * 添加首页banner图 - 20171120
     */
    public function addBanner($data)
    {
        foreach($data as $key => $value){
            $data[$key]['create_time'] = date('Y-m-d H:i:s',time());
            $data[$key]['type_id'] = 1;
        }
        //执行添加
        $result_add = model('Banner')->saveAll($data);
        if($result_add){
            return true;
        }else{
            return false;
        }
    }

    /**
     * 删除banner - 20171121
     */
    public function delBanner()
    {
        $banner_id = input('post.banner_id');
        if(empty($banner_id)){
            return resultArray(['error'=>'请选择删除的banner图']);
        }
        //执行删除
        $result_del = model('Banner')->delData(['banner_id'=>$banner_id]);
        if($result_del){
            $result = [
                'data' => [
                    'message' => '删除成功'
                ]
            ];
            cache('index_banner',null);
        }else{
            $result = [
                'error' => '删除失败'
            ];
        }
        return resultArray($result);
    }

    /**
     * 管理-首页管理-当前分类 - 20171115
     */
    public function setCateType()
    {
        if(Request::instance()->isGet()){ //查询当前分类
            //查询首页分类
            $index_cate = model('CateType')->getIndexCate();
            $result = [
                'data' => [
                    'index_cate' => $index_cate
                ]
            ];
            return resultArray($result);
        }
        elseif(Request::instance()->isPost()){ //修改分类
            //原分类id
            $old_id = Request::instance()->post('old_id');
            //新分类id
            $new_id = Request::instance()->post('new_id');
            auto_validate('CateType',['old_id'=>$old_id,'new_id'=>$new_id],'edit');
            //查询新的分类信息
            $type_info = model('CateUs')->getTypeInfo($new_id);
            $data = [
                'us_id' => $type_info['id'],
                'cate_name' => $type_info['cate_name'],
                'image_url' => $type_info['image_url']
            ];
            Db::startTrans();
            try{
                //删除原二级
                $child_cate = model('CateType')->getChildId($old_id);
                if(!empty($child_cate)){
                    Db::name('product')->where('product_type','in',$child_cate)->update(['product_type'=>0]);
                    Db::name('cate_type')->where('id','in',$child_cate)->delete();
                }else{
                    //将原分类下的商品修改为无分类状态
                    Db::name('product')->where('product_type',$old_id)->update(['product_type'=>0]);
                }
                Db::name('cate_type')->where('id',$old_id)->update($data);
                Db::commit();

                $result = [
                    'data' => [
                        'message' => '修改成功'
                    ]
                ];
            }catch (\Exception $exception){
                dump($exception->getMessage());
                Db::rollback();
                $result= [
                    'error' => '修改失败'
                ];
            }
            return resultArray($result);
        }
    }


    /**
     * 管理-首页管理-全部分类 - 20171117
     */
    public function allCateType()
    {
        $allBanner = cache('allType');
        if(empty($allBanner)){
            $allBanner = model('CateUs')->getAllType();
            cache('allType',$allBanner);
        }
        foreach($allBanner as $key => $value){
            $allBanner[$key]['checked'] = false;
        }
        $result = [
            'data' => [
                'all_type' => $allBanner
            ]
        ];
        return resultArray($result);

    }

    /**
     * 管理-首页管理-创建二级分类 - 20171117
     */
    public function createChildCate()
    {

        if(Request::instance()->isGet()){
            //查询当前全部分类
            $us_cate = Db::name('cate_type')->where('type',1)->field('id,pid,cate_name')->select();
            $cate_list = $this->regroup($us_cate);
            $result = [
                'data' => [
                    'child_cate' => $cate_list
                ]
            ];
            return resultArray($result);
        }
        elseif(Request::instance()->isPost()){
            $request = Request::instance()->post();

            //一级分类id
            $cate_id = $request['cate_id'];
            if(empty($cate_id)){
                return resultArray(['error'=>'请选择一级分类']);
            }
            //二级分类数组
            $child_cate = $request['child_cate'];

            $add_arr = [];
            if(!empty($child_cate)){
                foreach($child_cate as $key => $value){
                    $arr = [
                        'pid' => $cate_id,
                        'cate_name' => $value['cate_name'],
                        'status' => 1,
                        'type' => 1,
                        'edit_time' => date('Y-m-d',time())
                    ];
                    if(!empty($value['id'])){
                        $arr['id'] = $value['id'];
                    }
                }
            }
            Db::startTrans();
            try{
                if(!empty($add_arr)){
                    //新增二级分类
                    Db::name('cate_type')->insertAll($add_arr);
                }

                Db::commit();
                $result = [
                    'data'=>[
                        'message' => '操作成功'
                    ]
                ];
            }catch(\Exception $exception){
                $result = [
                    'error' => $exception->getMessage()
                ];
            }
            return resultArray($result);
        }
    }


    /**
     * 删除二级分类 - 20171117
     */
    public function delChildCate()
    {
        //二级分类id
        $child_id = Request::instance()->post('cate_id');
        if(!empty($child_id)){
            //将该二级分类下的商品全部转为无类别
            Db::startTrans();
            try{
                Db::name('product')->where('product_type',$child_id)->update(['product_type'=>0]);
                Db::name('cate_type')->where('id',$child_id)->delete();
                Db::commit();
                $result = [
                    'data' => [
                        'message' => '成功'
                    ]
                ];
            }catch(\Exception $exception){
                Db::rollback();
                $result = [
                    'data' => [
                        'message' => '失败'
                    ]
                ];
            }
        }else{
            $result = [
                'data' => [
                    'message' => '成功'
                ]
            ];
        }
        return resultArray($result);
    }


    /**
     * 重组数组 - 20171213
     */
    public function regroup($cate_list)
    {
        $group = [];
        foreach($cate_list as $key => $value){
            if($value['pid'] == 0){
                $group[] = $value;
                unset($cate_list[$key]);
            }
        }
        foreach($group as $key => $value){
            $group[$key]['child'] = [];
            foreach($cate_list as $k => $v){
                if($value['id'] == $v['pid']){
                    $group[$key]['child'][] = $v;
                }
            }
        }
        return $group;
    }
}