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

namespace app\service\admin\pointshop;

use app\model\pointshop\PointCategory;
use core\base\BaseAdminService;
use core\exception\AdminException;

/**
 * 积分商品分类服务层
 * Class PointCategoryService
 * @package app\service\admin\pointshop
 */
class PointCategoryService extends BaseAdminService
{
    public function __construct()
    {
        parent::__construct();
        $this->model = new PointCategory();
    }

    /**
     * 获取分类列表
     * @return array
     */
    public function getList()
    {
        return $this->model->order('sort desc, category_id desc')->select()->toArray();
    }

    /**
     * 获取分类详情
     * @param int $category_id
     * @return array
     */
    public function getInfo(int $category_id)
    {
        return $this->model->where(['category_id' => $category_id])->findOrEmpty()->toArray();
    }

    /**
     * 添加分类
     * @param array $data
     * @return mixed
     */
    public function add(array $data)
    {
        $data['create_time'] = time();
        $data['update_time'] = time();
        $result = $this->model->create($data);
        return $result->category_id;
    }

    /**
     * 编辑分类
     * @param int $category_id
     * @param array $data
     * @return true
     */
    public function edit(int $category_id, array $data)
    {
        $data['update_time'] = time();
        $this->model->where(['category_id' => $category_id])->update($data);
        return true;
    }

    /**
     * 删除分类
     * @param int $category_id
     * @return true
     */
    public function del(int $category_id)
    {
        $category = $this->model->find($category_id);
        if (empty($category)) {
            throw new AdminException('CATEGORY_NOT_EXIST');
        }
        $this->model->destroy($category_id);
        return true;
    }
}
