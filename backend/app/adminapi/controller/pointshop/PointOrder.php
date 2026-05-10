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

use app\service\admin\pointshop\PointOrderService;
use core\base\BaseAdminController;

class PointOrder extends BaseAdminController
{
    public function lists()
    {
        $data = $this->request->params([
            ['keyword', ''],
            ['status', ''],
            ['create_time', []],
        ]);
        return success((new PointOrderService())->getPage($data));
    }

    public function info(int $order_id)
    {
        return success((new PointOrderService())->getInfo($order_id));
    }

    public function deliver()
    {
        $data = $this->request->params([
            ['order_id', 0],
            ['express_company', ''],
            ['express_no', ''],
        ]);
        $this->validate($data, 'app\validate\pointshop\PointOrder.deliver');
        (new PointOrderService())->deliver($data['order_id'], $data['express_company'], $data['express_no']);
        return success('EDIT_SUCCESS');
    }

    public function getStatusList()
    {
        return success((new PointOrderService())->getStatusList());
    }
}
