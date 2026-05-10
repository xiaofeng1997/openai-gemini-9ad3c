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

namespace app\service\api\volunteer;

use app\model\volunteer\VolunteerOrder;
use app\model\volunteer\VolunteerService;
use app\model\volunteer\Volunteer;
use app\model\member\Member;
use app\model\member\MemberAddress;
use app\service\core\member\CoreMemberAccountService;
use core\exception\ApiException;
use think\facade\Db;
use think\facade\Cache;

class VolunteerOrderService
{
    public function createOrder(int $member_id, array $data)
    {
        $service_id = $data['service_id'];
        $service_time = $data['service_time'];
        $service_address = $data['service_address'];
        $service_remark = $data['service_remark'] ?? '';

        $service = (new VolunteerService())->find($service_id);
        if (empty($service) || $service['status'] != 1) {
            throw new ApiException('volunteer_service_not_exist');
        }

        $member = (new Member())->find($member_id);
        if ($member['point'] < $service['point_price']) {
            throw new ApiException('volunteer_point_not_enough');
        }

        $member_address = (new MemberAddress())->where(['member_id' => $member_id, 'is_default' => 1])->find();

        $volunteer_id = $service['volunteer_id'];

        Db::startTrans();
        try {
            $order_no = 'V' . date('YmdHis') . rand(1000, 9999);

            $order_data = [
                'order_no' => $order_no,
                'member_id' => $member_id,
                'member_name' => $member['nickname'],
                'member_phone' => $member_address ? $member_address['mobile'] : '',
                'service_id' => $service_id,
                'volunteer_id' => $volunteer_id,
                'volunteer_name' => $volunteer_id > 0 ? (new Volunteer())->where(['volunteer_id' => $volunteer_id])->value('nickname') : '平台',
                'point_num' => $service['point_price'],
                'service_time' => $service_time,
                'service_address' => $service_address,
                'service_remark' => $service_remark,
                'status' => VolunteerOrder::STATUS_PENDING,
                'create_time' => time(),
            ];

            $order = (new VolunteerOrder())->create($order_data);

            (new CoreMemberAccountService())
                ->changePoint($member_id, -$service['point_price'], 'volunteer_order', '预约服务: ' . $service['service_name']);

            Db::commit();
            return $order->order_id;
        } catch (\Exception $e) {
            Db::rollback();
            throw new ApiException($e->getMessage());
        }
    }

    public function getOrderList(int $member_id, array $params)
    {
        $where = [['member_id', '=', $member_id]];

        if ($params['status'] !== '') {
            $where[] = ['status', '=', (int)$params['status']];
        }

        $page = max(1, $params['page'] ?? 1);
        $limit = min(50, max(10, $params['limit'] ?? 20));

        $query = (new VolunteerOrder())->with(['service'])->where($where);

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

    public function getMyServeOrderList(int $member_id, array $params)
    {
        $volunteer = (new Volunteer())->where(['member_id' => $member_id, 'status' => 1])->find();
        if (empty($volunteer)) {
            return ['data' => [], 'total' => 0, 'page' => 1, 'limit' => 20];
        }

        $where = [['volunteer_id', '=', $volunteer['volunteer_id']]];

        if ($params['status'] !== '') {
            $where[] = ['status', '=', (int)$params['status']];
        }

        $page = max(1, $params['page'] ?? 1);
        $limit = min(50, max(10, $params['limit'] ?? 20));

        $query = (new VolunteerOrder())->with(['service'])->where($where);

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
        $order = (new VolunteerOrder())
            ->with(['service', 'evaluation'])
            ->where(['order_id' => $order_id])
            ->where(function ($query) use ($member_id) {
                $query->whereOr([
                    ['member_id', '=', $member_id],
                    ['volunteer_id', 'in', function ($q) use ($member_id) {
                        $q->table('nc_volunteer')->where(['member_id' => $member_id])->field('volunteer_id');
                    }]
                ]);
            })
            ->find()
            ->toArray() ?? [];

        if (empty($order)) {
            throw new ApiException('volunteer_order_not_exist');
        }

        return $order;
    }

    public function cancelOrder(int $member_id, int $order_id)
    {
        $order = (new VolunteerOrder())->where(['order_id' => $order_id, 'member_id' => $member_id])->find();
        if (empty($order)) {
            throw new ApiException('volunteer_order_not_exist');
        }

        if ($order['status'] != VolunteerOrder::STATUS_PENDING) {
            throw new ApiException('volunteer_order_cannot_cancel');
        }

        Db::startTrans();
        try {
            (new VolunteerOrder())->where(['order_id' => $order_id])->update([
                'status' => VolunteerOrder::STATUS_CANCELLED,
                'update_time' => time(),
            ]);

            (new CoreMemberAccountService())
                ->changePoint($member_id, $order['point_num'], 'volunteer_order_cancel', '取消订单退回积分: ' . $order['order_no']);

            Db::commit();
            return true;
        } catch (\Exception $e) {
            Db::rollback();
            throw new ApiException($e->getMessage());
        }
    }

    public function confirmOrder(int $member_id, int $order_id, int $status)
    {
        $volunteer = (new Volunteer())->where(['member_id' => $member_id, 'status' => 1])->find();
        if (empty($volunteer)) {
            throw new ApiException('volunteer_not_certified');
        }

        $order = (new VolunteerOrder())->where(['order_id' => $order_id, 'volunteer_id' => $volunteer['volunteer_id']])->find();
        if (empty($order)) {
            throw new ApiException('volunteer_order_not_exist');
        }

        if ($status == -1 && $order['status'] != VolunteerOrder::STATUS_PENDING) {
            throw new ApiException('volunteer_order_cannot_reject');
        }

        if ($status == 2 && $order['status'] != VolunteerOrder::STATUS_PENDING) {
            throw new ApiException('volunteer_order_cannot_confirm');
        }

        (new VolunteerOrder())->where(['order_id' => $order_id])->update([
            'status' => $status,
            'update_time' => time(),
        ]);

        if ($status == VolunteerOrder::STATUS_CANCELLED) {
            (new CoreMemberAccountService())
                ->changePoint($order['member_id'], $order['point_num'], 'volunteer_order_reject', '志愿者拒绝订单退回积分: ' . $order['order_no']);
        }

        return true;
    }

    public function startService(int $member_id, int $order_id)
    {
        $volunteer = (new Volunteer())->where(['member_id' => $member_id, 'status' => 1])->find();
        if (empty($volunteer)) {
            throw new ApiException('volunteer_not_certified');
        }

        $order = (new VolunteerOrder())->where(['order_id' => $order_id, 'volunteer_id' => $volunteer['volunteer_id']])->find();
        if (empty($order)) {
            throw new ApiException('volunteer_order_not_exist');
        }

        if ($order['status'] != VolunteerOrder::STATUS_CONFIRMED) {
            throw new ApiException('volunteer_order_cannot_start');
        }

        (new VolunteerOrder())->where(['order_id' => $order_id])->update([
            'status' => VolunteerOrder::STATUS_SERVICING,
            'update_time' => time(),
        ]);

        return true;
    }

    public function finishService(int $member_id, int $order_id)
    {
        $volunteer = (new Volunteer())->where(['member_id' => $member_id, 'status' => 1])->find();
        if (empty($volunteer)) {
            throw new ApiException('volunteer_not_certified');
        }

        $order = (new VolunteerOrder())->where(['order_id' => $order_id, 'volunteer_id' => $volunteer['volunteer_id']])->find();
        if (empty($order)) {
            throw new ApiException('volunteer_order_not_exist');
        }

        if ($order['status'] != VolunteerOrder::STATUS_SERVICING) {
            throw new ApiException('volunteer_order_cannot_finish');
        }

        (new VolunteerOrder())->where(['order_id' => $order_id])->update([
            'status' => VolunteerOrder::STATUS_FINISHED,
            'finish_time' => time(),
            'update_time' => time(),
        ]);

        return true;
    }

    public function createEvaluation(int $member_id, int $order_id, array $data)
    {
        $order = (new VolunteerOrder())->where(['order_id' => $order_id, 'member_id' => $member_id])->find();
        if (empty($order)) {
            throw new ApiException('volunteer_order_not_exist');
        }

        if ($order['status'] != VolunteerOrder::STATUS_FINISHED) {
            throw new ApiException('volunteer_order_not_finished');
        }

        $exist = (new \app\model\volunteer\VolunteerEvaluation())->where(['order_id' => $order_id])->find();
        if ($exist) {
            throw new ApiException('volunteer_evaluation_exists');
        }

        (new \app\model\volunteer\VolunteerEvaluation())->insert([
            'order_id' => $order_id,
            'member_id' => $member_id,
            'volunteer_id' => $order['volunteer_id'],
            'score' => $data['score'] ?? 5,
            'content' => $data['content'] ?? '',
            'images' => json_encode($data['images'] ?? []),
            'create_time' => time(),
        ]);

        return true;
    }

    public function replyEvaluation(int $member_id, int $evaluation_id, string $reply)
    {
        $evaluation = (new \app\model\volunteer\VolunteerEvaluation())->find($evaluation_id);
        if (empty($evaluation)) {
            throw new ApiException('volunteer_evaluation_not_exist');
        }

        $volunteer = (new Volunteer())->where(['member_id' => $member_id, 'volunteer_id' => $evaluation['volunteer_id']])->find();
        if (empty($volunteer)) {
            throw new ApiException('volunteer_not_certified');
        }

        (new \app\model\volunteer\VolunteerEvaluation())->where(['evaluation_id' => $evaluation_id])->update([
            'reply' => $reply,
            'reply_time' => time(),
        ]);

        return true;
    }
}
