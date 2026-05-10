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

use app\service\admin\volunteer\VolunteerServiceService;
use core\base\BaseAdminController;

class VolunteerService extends BaseAdminController
{
    public function lists()
    {
        $data = $this->request->params([
            ['keyword', ''],
            ['category_id', 0],
            ['status', ''],
        ]);
        return success((new VolunteerServiceService())->getPage($data));
    }

    public function info(int $service_id)
    {
        return success((new VolunteerServiceService())->getInfo($service_id));
    }

    public function add()
    {
        $data = $this->request->params([
            ['category_id', 0],
            ['service_name', ''],
            ['service_cover', ''],
            ['service_images', []],
            ['service_desc', ''],
            ['point_price', 0],
            ['service_unit', '次'],
            ['service_duration', 60],
            ['service_area', ''],
            ['sort', 0],
            ['status', 1],
        ]);
        $this->validate($data, 'app\validate\volunteer\VolunteerService.add');
        $data['is_template'] = 1;
        $res = (new VolunteerServiceService())->add($data);
        return success('ADD_SUCCESS', ['service_id' => $res]);
    }

    public function edit(int $service_id)
    {
        $data = $this->request->params([
            ['category_id', 0],
            ['service_name', ''],
            ['service_cover', ''],
            ['service_images', []],
            ['service_desc', ''],
            ['point_price', 0],
            ['service_unit', '次'],
            ['service_duration', 60],
            ['service_area', ''],
            ['sort', 0],
            ['status', 1],
        ]);
        $this->validate($data, 'app\validate\volunteer\VolunteerService.edit');
        (new VolunteerServiceService())->edit($service_id, $data);
        return success('EDIT_SUCCESS');
    }

    public function del(int $service_id)
    {
        (new VolunteerServiceService())->del($service_id);
        return success('DELETE_SUCCESS');
    }

    public function audit()
    {
        $data = $this->request->params([
            ['service_id', 0],
            ['status', 1],
        ]);
        (new VolunteerServiceService())->audit($data['service_id'], $data['status']);
        return success('EDIT_SUCCESS');
    }

    public function setStatus()
    {
        $data = $this->request->params([
            ['service_ids', []],
            ['status', 1],
        ]);
        (new VolunteerServiceService())->setStatus($data['service_ids'], $data['status']);
        return success('EDIT_SUCCESS');
    }
}
