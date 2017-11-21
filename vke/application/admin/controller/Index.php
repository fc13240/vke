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
            $banner_list = Request::instance()->post('banner_list');
            //执行修改
            $result_edit = model('Banner')->updateAll($banner_list);
            if($result_edit !== false){
                $result = [
                    'data' => [
                        'message' => '修改成功'
                    ]
                ];
                cache('index_banner',null);
            }else{
                $result = [
                    'error'=>'修改失败'
                ];
            }
            return resultArray($result);
        }
    }

    /**
     * 添加首页banner图 - 20171120
     */
    public function addBanner()
    {
        $banner_image = Request::instance()->post('banner_image');
        if(empty($banner_image)){
            return resultArray(['error'=>'请上传图片']);
        }
        $banner_url = Request::instance()->post('banner_url');
        $data = [
            'banner_image' => $banner_image,
            'banner_url' => $banner_url,
            'create_time' => date('Y-m-d H:i:s',time()),
            'type_id' => 1,
        ];
        //执行添加
        $result_add = model('Banner')->addData($data);
        if($result_add){
            $result = [
                'data' => [
                    'message' => '添加成功'
                ]
            ];
            cache('index_banner',null);
        }else{
            $result = [
                'error' => '添加失败'
            ];
        }
        return resultArray($result);
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
            $cate_id = Request::instance()->get('cate_id');
            if(empty($cate_id)){
                return resultArray(['error'=>'请选择一级分类']);
            }
            //一级菜单id,根据id查询二级菜单
            $cate_list = model('CateType')->getChildCate($cate_id);
            $result = [
                'data' => [
                    'child_cate' => $cate_list
                ]
            ];
            return resultArray($result);
        }
        elseif(Request::instance()->isPost()){
            //一级分类id
            $cate_id = Request::instance()->post('cate_id');
            if(empty($cate_id)){
                return resultArray(['error'=>'请选择一级分类']);
            }
            //原二级分类
            $child_cate = Request::instance()->post('child_cate');
            //取出原二级分类id
            //新二级分类
            $new_child = Request::instance()->post('new_cate');
            if(empty($child_cate) || empty($new_child)){
                return resultArray(['error'=>'修改失败']);
            }
            $insert_arr = [];
            foreach($new_child as $key => $value){
                $insert_arr[] = [
                    'cate_name' => $value['cate_name'],
                    'pid' => $cate_id,
                    'type' => 1
                ];
            }
            Db::startTrans();
            try{
                //修改原二级分类名
                Db::name('cate_type')->update($child_cate);
                //新增二级分类
                Db::name('cate_type')->insertAll($insert_arr);
                Db::commit();
                $result = [
                    'data'=>[
                        'message' => '操作成功'
                    ]
                ];
            }catch(\Exception $exception){
                $result = [
                    'error' => '操作失败'
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

}