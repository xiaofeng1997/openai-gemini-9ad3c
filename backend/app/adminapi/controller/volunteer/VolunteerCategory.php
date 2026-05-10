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

namespace app\adminapi\controller\volunteer;

use app\service\admin\volunteer\VolunteerCategoryService;
use core\base\BaseAdminController;

class VolunteerCategory extends BaseAdminController
{
    public function lists()
    {
        return success((new VolunteerCategoryService())->getList());
    }

    public function info(int $category_id)
    {
        return success((new VolunteerCategoryService())->getInfo($category_id));
    }

    public function add()
    {
        $data = $this->request->params([
            ['category_name', ''],
            ['icon', ''],
            ['sort', 0],
            ['is_show', 1],
        ]);
        $this->validate($data, 'app\validate\volunteer\VolunteerCategory.add');
        $res = (new VolunteerCategoryService())->add($data);
        return success('ADD_SUCCESS', ['category_id' => $res]);
    }

    public function edit(int $category_id)
    {
        $data = $this->request->params([
            ['category_name', ''],
            ['icon', ''],
            ['sort', 0],
            ['is_show', 1],
        ]);
        $this->validate($data, 'app\validate\volunteer\VolunteerCategory.edit');
        (new VolunteerCategoryService())->edit($category_id, $data);
        return success('EDIT_SUCCESS');
    }

    public function del(int $category_id)
    {
        (new VolunteerCategoryService())->del($category_id);
        return success('DELETE_SUCCESS');
    }
}
