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

use app\model\pointshop\PointOrder;
use core\base\BaseAdminService;
use core\exception\AdminException;

class PointOrderService extends BaseAdminService
{
    public function __construct()
    {
        parent::__construct();
        $this->model = new PointOrder();
    }

    public function getPage(array $where = [])
    {
        $field = 'order_id, order_no, member_id, goods_id, num, point_num, address, express_company, express_no, status, create_time, update_time, delivery_time';
        $searchModel = $this->model->withSearch(['keyword', 'status', 'create_time'], $where)
            ->with(['member', 'goods'])
            ->field($field)
            ->order('order_id desc')
            ->append(['status_name']);
        return $this->pageQuery($searchModel);
    }

    public function getInfo(int $order_id)
    {
        return $this->model->with(['member', 'goods'])->where(['order_id' => $order_id])->findOrEmpty()->toArray();
    }

    public function deliver(int $order_id, string $express_company, string $express_no)
    {
        $order = $this->model->find($order_id);
        if (empty($order)) {
            throw new AdminException('pointshop_order_not_exist');
        }
        if ($order['status'] != PointOrder::STATUS_WAIT_DELIVER) {
            throw new AdminException('pointshop_order_cannot_deliver');
        }
        $this->model->where(['order_id' => $order_id])->update([
            'status' => PointOrder::STATUS_DELIVERED,
            'express_company' => $express_company,
            'express_no' => $express_no,
            'delivery_time' => time(),
            'update_time' => time(),
        ]);
        return true;
    }

    public function getStatusList()
    {
        return [
            ['status' => -1, 'name' => '已取消'],
            ['status' => 1, 'name' => '待发货'],
            ['status' => 2, 'name' => '已发货'],
            ['status' => 3, 'name' => '已完成'],
        ];
    }
}
