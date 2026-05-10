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

class PointCategoryService extends BaseAdminService
{
    public function __construct()
    {
        parent::__construct();
        $this->model = new PointCategory();
    }

    public function getList()
    {
        return $this->model->order('sort desc, category_id desc')->select()->toArray();
    }

    public function getInfo(int $category_id)
    {
        return $this->model->where(['category_id' => $category_id])->findOrEmpty()->toArray();
    }

    public function add(array $data)
    {
        $data['create_time'] = time();
        $data['update_time'] = time();
        $result = $this->model->create($data);
        return $result->category_id;
    }

    public function edit(int $category_id, array $data)
    {
        $data['update_time'] = time();
        $this->model->where(['category_id' => $category_id])->update($data);
        return true;
    }

    public function del(int $category_id)
    {
        $category = $this->model->find($category_id);
        if (empty($category)) {
            throw new AdminException('pointshop_category_not_exist');
        }
        $this->model->destroy($category_id);
        return true;
    }
}
