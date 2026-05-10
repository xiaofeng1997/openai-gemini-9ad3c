<?php
// +----------------------------------------------------------------------
// | Niucloud-Lite-Ai 企业快速开发的管理平台
// +----------------------------------------------------------------------
// | 官方网址：https://www.niucloud.com
// +----------------------------------------------------------------------
// | niucloud团队 版权所有 开源版本可自由商用
// +----------------------------------------------------------------------
// | Author: Niucloud Team
// +----------------------------------------------------------------------

namespace app\adminapi\controller\pointshop;

use app\service\admin\pointshop\PointCategoryService;
use core\base\BaseAdminController;
use think\Response;

/**
 * 积分商城分类控制器
 * Class PointCategory
 * @package app\adminapi\controller\pointshop
 */
class PointCategory extends BaseAdminController
{
    /**
     * 分类列表
     * @return Response
     */
    public function lists()
    {
        return success((new PointCategoryService())->getList());
    }

    /**
     * 分类详情
     * @param int $category_id
     * @return Response
     */
    public function info(int $category_id)
    {
        return success((new PointCategoryService())->getInfo($category_id));
    }

    /**
     * 添加分类
     * @return Response
     */
    public function add()
    {
        $data = $this->request->params([
            ['category_name', ''],
            ['parent_id', 0],
            ['image', ''],
            ['sort', 0],
            ['is_show', 1],
        ]);
        $this->validate($data, 'app\validate\pointshop\PointCategory.add');
        $res = (new PointCategoryService())->add($data);
        return success('ADD_SUCCESS', ['category_id' => $res]);
    }

    /**
     * 编辑分类
     * @param int $category_id
     * @return Response
     */
    public function edit(int $category_id)
    {
        $data = $this->request->params([
            ['category_name', ''],
            ['parent_id', 0],
            ['image', ''],
            ['sort', 0],
            ['is_show', 1],
        ]);
        $this->validate($data, 'app\validate\pointshop\PointCategory.edit');
        (new PointCategoryService())->edit($category_id, $data);
        return success('EDIT_SUCCESS');
    }

    /**
     * 删除分类
     * @param int $category_id
     * @return Response
     */
    public function del(int $category_id)
    {
        (new PointCategoryService())->del($category_id);
        return success('DELETE_SUCCESS');
    }
}
