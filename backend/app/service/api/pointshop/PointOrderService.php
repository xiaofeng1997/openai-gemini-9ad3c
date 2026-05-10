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

namespace app\service\api\pointshop;

use app\model\api\pointshop\PointOrder as OrderModel;
use app\model\member\Member;
use app\model\member\MemberAddress;
use app\model\pointshop\PointGoods;
use app\service\core\member\CoreMemberAccountService;
use core\base\BaseApiService;
use core\exception\ApiException;
use think\facade\Db;

/**
 * API端积分订单服务层
 * Class PointOrderService
 * @package app\service\api\pointshop
 */
class PointOrderService extends BaseApiService
{
    public function __construct()
    {
        parent::__construct();
        $this->model = new OrderModel();
    }

    /**
     * 创建积分订单
     * @param array $data
     * @return int
     */
    public function createOrder(array $data)
    {
        $member_id = $this->member_id;
        $goods_id = $data['goods_id'];
        $num = $data['num'] ?? 1;
        $address_id = $data['address_id'];

        $goods = (new PointGoods())->find($goods_id);
        if (empty($goods) || $goods['status'] != 1) {
            throw new ApiException('GOODS_NOT_EXIST');
        }

        if ($goods['stock'] < $num) {
            throw new ApiException('GOODS_STOCK_NOT_ENOUGH');
        }

        $address = (new MemberAddress())->where(['address_id' => $address_id, 'member_id' => $member_id])->find();
        if (empty($address)) {
            throw new ApiException('ADDRESS_NOT_EXIST');
        }

        $member = (new Member())->find($member_id);
        $total_point = $goods['point_price'] * $num;

        if ($member['point'] < $total_point) {
            throw new ApiException('POINT_NOT_ENOUGH');
        }

        Db::startTrans();
        try {
            $order_no = 'P' . date('YmdHis') . rand(1000, 9999);

            $order_data = [
                'order_no' => $order_no,
                'member_id' => $member_id,
                'goods_id' => $goods_id,
                'num' => $num,
                'point_num' => $total_point,
                'address' => [
                    'name' => $address['name'],
                    'mobile' => $address['mobile'],
                    'province_id' => $address['province_id'],
                    'city_id' => $address['city_id'],
                    'district_id' => $address['district_id'],
                    'address' => $address['address'],
                    'full_address' => $address['full_address'],
                ],
                'status' => 1,
                'create_time' => time(),
            ];

            $order = $this->model->create($order_data);

            (new PointGoods())->where(['goods_id' => $goods_id])->dec('stock', $num)->inc('sales_num', $num)->update();

            (new CoreMemberAccountService())->changePoint($member_id, -$total_point, 'pointshop_exchange', '积分兑换: ' . $goods['goods_name']);

            Db::commit();
            return $order->order_id;
        } catch (\Exception $e) {
            Db::rollback();
            throw new ApiException($e->getMessage());
        }
    }

    /**
     * 获取会员订单列表
     * @param array $params
     * @return array
     */
    public function getMemberOrderList(array $params)
    {
        $member_id = $this->member_id;
        $where = [['member_id', '=', $member_id]];

        if ($params['status'] !== '') {
            $where[] = ['status', '=', $params['status']];
        }

        $page = $params['page'] ?? 1;
        $limit = $params['limit'] ?? 20;

        $list = $this->model->with(['goods'])
            ->where($where)
            ->order('order_id desc')
            ->paginate([
                'list_rows' => $limit,
                'page' => $page,
            ]);

        return $list->toArray();
    }

    /**
     * 获取订单详情
     * @param int $order_id
     * @return array
     */
    public function getOrderDetail(int $order_id)
    {
        $member_id = $this->member_id;
        $order = $this->model->with(['goods'])->where(['order_id' => $order_id, 'member_id' => $member_id])->findOrEmpty()->toArray();

        if (empty($order)) {
            throw new ApiException('ORDER_NOT_EXIST');
        }

        return $order;
    }

    /**
     * 取消订单
     * @param int $order_id
     * @return true
     */
    public function cancelOrder(int $order_id)
    {
        $member_id = $this->member_id;
        $order = $this->model->where(['order_id' => $order_id, 'member_id' => $member_id])->find();

        if (empty($order)) {
            throw new ApiException('ORDER_NOT_EXIST');
        }

        if ($order['status'] != 1) {
            throw new ApiException('ORDER_CANNOT_CANCEL');
        }

        Db::startTrans();
        try {
            $this->model->where(['order_id' => $order_id])->update(['status' => -1, 'update_time' => time()]);

            (new PointGoods())->where(['goods_id' => $order['goods_id']])->inc('stock', $order['num'])->dec('sales_num', $order['num'])->update();

            (new CoreMemberAccountService())->changePoint($member_id, $order['point_num'], 'pointshop_cancel', '取消订单退回积分: ' . $order['order_no']);

            Db::commit();
            return true;
        } catch (\Exception $e) {
            Db::rollback();
            throw new ApiException($e->getMessage());
        }
    }

    /**
     * 确认收货
     * @param int $order_id
     * @return true
     */
    public function confirmReceive(int $order_id)
    {
        $member_id = $this->member_id;
        $order = $this->model->where(['order_id' => $order_id, 'member_id' => $member_id])->find();

        if (empty($order)) {
            throw new ApiException('ORDER_NOT_EXIST');
        }

        if ($order['status'] != 2) {
            throw new ApiException('ORDER_CANNOT_RECEIVE');
        }

        $this->model->where(['order_id' => $order_id])->update(['status' => 3, 'update_time' => time()]);
        return true;
    }
}
