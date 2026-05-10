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
use think\Response;

/**
 * 积分商城订单控制器
 * Class PointOrder
 * @package app\adminapi\controller\pointshop
 */
class PointOrder extends BaseAdminController
{
    /**
     * 订单列表
     * @return Response
     */
    public function lists()
    {
        $data = $this->request->params([
            ['keyword', ''],
            ['status', ''],
            ['create_time', []],
        ]);
        return success((new PointOrderService())->getPage($data));
    }

    /**
     * 订单详情
     * @param int $order_id
     * @return Response
     */
    public function info(int $order_id)
    {
        return success((new PointOrderService())->getInfo($order_id));
    }

    /**
     * 发货
     * @return Response
     */
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

    /**
     * 获取订单状态列表
     * @return Response
     */
    public function getStatusList()
    {
        return success((new PointOrderService())->getStatusList());
    }
}
