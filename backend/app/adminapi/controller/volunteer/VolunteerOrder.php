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

use app\service\admin\volunteer\VolunteerOrderService;
use core\base\BaseAdminController;

class VolunteerOrder extends BaseAdminController
{
    public function lists()
    {
        $data = $this->request->params([
            ['keyword', ''],
            ['status', ''],
            ['create_time', []],
        ]);
        return success((new VolunteerOrderService())->getPage($data));
    }

    public function info(int $order_id)
    {
        return success((new VolunteerOrderService())->getInfo($order_id));
    }

    public function updateStatus()
    {
        $data = $this->request->params([
            ['order_id', 0],
            ['status', 4],
        ]);
        (new VolunteerOrderService())->updateStatus($data['order_id'], $data['status']);
        return success('EDIT_SUCCESS');
    }

    public function getStatusList()
    {
        return success((new VolunteerOrderService())->getStatusList());
    }
}
