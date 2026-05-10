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

namespace app\api\controller\pointshop;

use app\service\api\pointshop\PointGoodsService;
use app\service\api\pointshop\PointOrderService;
use core\base\BaseApiController;

class Pointshop extends BaseApiController
{
    public function index()
    {
        $member_id = $this->member_id ?? 0;
        return success((new PointGoodsService())->getIndexData($member_id));
    }

    public function goodsList()
    {
        $data = $this->request->params([
            ['category_id', 0],
            ['keyword', ''],
            ['page', 1],
            ['limit', 20],
        ]);
        return success((new PointGoodsService())->getGoodsList($data));
    }

    public function goodsDetail(int $goods_id)
    {
        return success((new PointGoodsService())->getGoodsDetail($goods_id));
    }

    public function exchange()
    {
        $data = $this->request->params([
            ['goods_id', 0],
            ['address_id', 0],
            ['num', 1],
        ]);
        $order_id = (new PointOrderService())->createOrder($this->member_id, $data);
        return success('pointshop_exchange_success', ['order_id' => $order_id]);
    }

    public function orderList()
    {
        $data = $this->request->params([
            ['status', ''],
            ['page', 1],
            ['limit', 20],
        ]);
        return success((new PointOrderService())->getMemberOrderList($this->member_id, $data));
    }

    public function orderDetail(int $order_id)
    {
        return success((new PointOrderService())->getOrderDetail($this->member_id, $order_id));
    }

    public function cancelOrder(int $order_id)
    {
        (new PointOrderService())->cancelOrder($this->member_id, $order_id);
        return success('pointshop_cancel_success');
    }

    public function confirmReceive(int $order_id)
    {
        (new PointOrderService())->confirmReceive($this->member_id, $order_id);
        return success('pointshop_confirm_success');
    }
}
