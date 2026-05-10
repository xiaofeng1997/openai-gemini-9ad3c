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

use app\model\volunteer\VolunteerOrder;
use core\base\BaseAdminService;
use core\exception\AdminException;

class VolunteerOrderService extends BaseAdminService
{
    public function __construct()
    {
        parent::__construct();
        $this->model = new VolunteerOrder();
    }

    public function getPage(array $where = [])
    {
        $field = 'order_id, order_no, member_id, service_id, volunteer_id, point_num, service_time, service_address, status, create_time, update_time, finish_time';
        $searchModel = $this->model->withSearch(['keyword', 'status', 'create_time'], $where)
            ->with(['member', 'service', 'volunteer'])
            ->field($field)
            ->order('order_id desc')
            ->append(['status_name']);
        return $this->pageQuery($searchModel);
    }

    public function getInfo(int $order_id)
    {
        return $this->model->with(['member', 'service', 'volunteer', 'evaluation'])->where(['order_id' => $order_id])->findOrEmpty()->toArray();
    }

    public function updateStatus(int $order_id, int $status)
    {
        $order = $this->model->find($order_id);
        if (empty($order)) {
            throw new AdminException('volunteer_order_not_exist');
        }

        $data = [
            'status' => $status,
            'update_time' => time(),
        ];

        if ($status == VolunteerOrder::STATUS_FINISHED) {
            $data['finish_time'] = time();
        }

        $this->model->where(['order_id' => $order_id])->update($data);
        return true;
    }

    public function getStatusList()
    {
        return [
            ['status' => -1, 'name' => '已拒绝'],
            ['status' => 1, 'name' => '待确认'],
            ['status' => 2, 'name' => '已确认'],
            ['status' => 3, 'name' => '服务中'],
            ['status' => 4, 'name' => '已完成'],
            ['status' => 5, 'name' => '已取消'],
        ];
    }
}
