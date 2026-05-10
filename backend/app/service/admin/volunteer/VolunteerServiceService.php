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

namespace app\service\admin\volunteer;

use app\model\volunteer\VolunteerService;
use app\model\volunteer\Volunteer;
use core\base\BaseAdminService;
use core\exception\AdminException;

class VolunteerServiceService extends BaseAdminService
{
    public function __construct()
    {
        parent::__construct();
        $this->model = new VolunteerService();
    }

    public function getPage(array $where = [])
    {
        $field = 'service_id, category_id, volunteer_id, service_name, service_cover, point_price, service_unit, service_duration, status, is_template, create_time, update_time';
        $searchModel = $this->model->withSearch(['keyword', 'category_id', 'status'], $where)
            ->with(['category', 'volunteer'])
            ->field($field)
            ->order('sort desc, service_id desc')
            ->append(['status_name']);
        return $this->pageQuery($searchModel);
    }

    public function getInfo(int $service_id)
    {
        return $this->model->with(['category', 'volunteer'])->where(['service_id' => $service_id])->findOrEmpty()->toArray();
    }

    public function add(array $data)
    {
        $data['create_time'] = time();
        $data['update_time'] = time();
        $result = $this->model->create($data);
        return $result->service_id;
    }

    public function edit(int $service_id, array $data)
    {
        $data['update_time'] = time();
        $this->model->where(['service_id' => $service_id])->update($data);
        return true;
    }

    public function del(int $service_id)
    {
        $service = $this->model->find($service_id);
        if (empty($service)) {
            throw new AdminException('volunteer_service_not_exist');
        }
        $this->model->destroy($service_id);
        return true;
    }

    public function audit(int $service_id, int $status, string $remark = '')
    {
        $service = $this->model->find($service_id);
        if (empty($service)) {
            throw new AdminException('volunteer_service_not_exist');
        }
        $this->model->where(['service_id' => $service_id])->update([
            'status' => $status,
            'update_time' => time(),
        ]);
        return true;
    }

    public function setStatus(array $service_ids, int $status)
    {
        $this->model->whereIn('service_id', $service_ids)->update(['status' => $status, 'update_time' => time()]);
        return true;
    }
}
