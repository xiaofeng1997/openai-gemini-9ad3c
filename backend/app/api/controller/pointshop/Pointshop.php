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
use think\Response;

/**
 * 积分商城API控制器
 * Class Pointshop
 * @package app\api\controller\pointshop
 */
class Pointshop extends BaseApiController
{
    /**
     * 获取积分商城首页数据
     * @return Response
     */
    public function index()
    {
        return success((new PointGoodsService())->getIndexData());
    }

    /**
     * 商品列表
     * @return Response
     */
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

    /**
     * 商品详情
     * @param int $goods_id
     * @return Response
     */
    public function goodsDetail(int $goods_id)
    {
        return success((new PointGoodsService())->getGoodsDetail($goods_id));
    }

    /**
     * 积分兑换
     * @return Response
     */
    public function exchange()
    {
        $data = $this->request->params([
            ['goods_id', 0],
            ['address_id', 0],
            ['num', 1],
        ]);
        $this->validate($data, 'app\validate\api\Pointshop.exchange');
        $order_id = (new PointOrderService())->createOrder($data);
        return success('EXCHANGE_SUCCESS', ['order_id' => $order_id]);
    }

    /**
     * 订单列表
     * @return Response
     */
    public function orderList()
    {
        $data = $this->request->params([
            ['status', ''],
            ['page', 1],
            ['limit', 20],
        ]);
        return success((new PointOrderService())->getMemberOrderList($data));
    }

    /**
     * 订单详情
     * @param int $order_id
     * @return Response
     */
    public function orderDetail(int $order_id)
    {
        return success((new PointOrderService())->getOrderDetail($order_id));
    }

    /**
     * 取消订单
     * @param int $order_id
     * @return Response
     */
    public function cancelOrder(int $order_id)
    {
        (new PointOrderService())->cancelOrder($order_id);
        return success('CANCEL_SUCCESS');
    }

    /**
     * 确认收货
     * @param int $order_id
     * @return Response
     */
    public function confirmReceive(int $order_id)
    {
        (new PointOrderService())->confirmReceive($order_id);
        return success('CONFIRM_SUCCESS');
    }
}
