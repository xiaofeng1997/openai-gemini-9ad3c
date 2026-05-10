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

use app\model\pointshop\PointOrder;
use app\model\member\Member;
use app\model\member\MemberAddress;
use app\model\pointshop\PointGoods;
use app\service\core\member\CoreMemberAccountService;
use core\exception\ApiException;
use think\facade\Db;
use think\facade\Cache;

class PointOrderService
{
    protected $lockKey = 'point_order_lock_';

    public function createOrder(int $member_id, array $data)
    {
        $goods_id = $data['goods_id'];
        $num = max(1, $data['num'] ?? 1);
        $address_id = $data['address_id'];

        $lock = $this->lockKey . $goods_id . '_' . $member_id;
        if (!Cache::get($lock)) {
            Cache::set($lock, 1, 10);
        } else {
            throw new ApiException('pointshop_repeat_submit');
        }

        try {
            $goods = (new PointGoods())->find($goods_id);
            if (empty($goods) || $goods['status'] != 1) {
                throw new ApiException('pointshop_goods_not_exist');
            }

            if ($goods['stock'] < $num) {
                throw new ApiException('pointshop_stock_not_enough');
            }

            $address = (new MemberAddress())
                ->where(['address_id' => $address_id, 'member_id' => $member_id])
                ->find();

            if (empty($address)) {
                throw new ApiException('pointshop_address_not_exist');
            }

            $member = (new Member())->find($member_id);
            $total_point = $goods['point_price'] * $num;

            if ($member['point'] < $total_point) {
                throw new ApiException('pointshop_point_not_enough');
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
                    'status' => PointOrder::STATUS_WAIT_DELIVER,
                    'create_time' => time(),
                ];

                $order = (new PointOrder())->create($order_data);

                (new PointGoods())
                    ->where(['goods_id' => $goods_id])
                    ->dec('stock', $num)
                    ->inc('sales_num', $num)
                    ->update();

                (new CoreMemberAccountService())
                    ->changePoint($member_id, -$total_point, 'pointshop_exchange', '积分兑换: ' . $goods['goods_name']);

                (new PointGoodsService())->clearGoodsCache($goods_id);

                Db::commit();
                return $order->order_id;
            } catch (\Exception $e) {
                Db::rollback();
                throw new ApiException($e->getMessage());
            }
        } finally {
            Cache::delete($lock);
        }
    }

    public function getMemberOrderList(int $member_id, array $params)
    {
        $where = [['member_id', '=', $member_id]];

        if ($params['status'] !== '') {
            $where[] = ['status', '=', (int)$params['status']];
        }

        $page = max(1, $params['page'] ?? 1);
        $limit = min(50, max(10, $params['limit'] ?? 20));

        $query = (new PointOrder())->with(['goods'])->where($where);

        $total = $query->count();
        $list = $query
            ->order('order_id desc')
            ->page($page, $limit)
            ->select()
            ->toArray();

        return [
            'data' => $list,
            'total' => $total,
            'page' => $page,
            'limit' => $limit,
        ];
    }

    public function getOrderDetail(int $member_id, int $order_id)
    {
        $order = (new PointOrder())
            ->with(['goods'])
            ->where(['order_id' => $order_id, 'member_id' => $member_id])
            ->find()
            ->toArray() ?? [];

        if (empty($order)) {
            throw new ApiException('pointshop_order_not_exist');
        }

        return $order;
    }

    public function cancelOrder(int $member_id, int $order_id)
    {
        $order = (new PointOrder())->where(['order_id' => $order_id, 'member_id' => $member_id])->find();

        if (empty($order)) {
            throw new ApiException('pointshop_order_not_exist');
        }

        if ($order['status'] != PointOrder::STATUS_WAIT_DELIVER) {
            throw new ApiException('pointshop_order_cannot_cancel');
        }

        Db::startTrans();
        try {
            (new PointOrder())
                ->where(['order_id' => $order_id])
                ->update(['status' => PointOrder::STATUS_CANCEL, 'update_time' => time()]);

            (new PointGoods())
                ->where(['goods_id' => $order['goods_id']])
                ->inc('stock', $order['num'])
                ->dec('sales_num', $order['num'])
                ->update();

            (new CoreMemberAccountService())
                ->changePoint($member_id, $order['point_num'], 'pointshop_cancel', '取消订单退回积分: ' . $order['order_no']);

            (new PointGoodsService())->clearGoodsCache($order['goods_id']);

            Db::commit();
            return true;
        } catch (\Exception $e) {
            Db::rollback();
            throw new ApiException($e->getMessage());
        }
    }

    public function confirmReceive(int $member_id, int $order_id)
    {
        $order = (new PointOrder())->where(['order_id' => $order_id, 'member_id' => $member_id])->find();

        if (empty($order)) {
            throw new ApiException('pointshop_order_not_exist');
        }

        if ($order['status'] != PointOrder::STATUS_DELIVERED) {
            throw new ApiException('pointshop_order_cannot_receive');
        }

        (new PointOrder())
            ->where(['order_id' => $order_id])
            ->update(['status' => PointOrder::STATUS_COMPLETED, 'update_time' => time()]);

        return true;
    }
}
