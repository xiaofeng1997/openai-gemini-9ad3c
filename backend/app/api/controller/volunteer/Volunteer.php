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

namespace app\api\controller\volunteer;

use app\service\api\volunteer\VolunteerServiceService;
use app\service\api\volunteer\VolunteerService;
use app\service\api\volunteer\VolunteerOrderService;
use core\base\BaseApiController;

class Volunteer extends BaseApiController
{
    public function index()
    {
        $member_id = $this->member_id ?? 0;
        return success((new VolunteerServiceService())->getIndexData($member_id));
    }

    public function category()
    {
        return success((new VolunteerServiceService())->getCategory());
    }

    public function serviceLists()
    {
        $data = $this->request->params([
            ['category_id', 0],
            ['keyword', ''],
            ['volunteer_id', 0],
            ['page', 1],
            ['limit', 20],
        ]);
        return success((new VolunteerServiceService())->getServiceList($data));
    }

    public function serviceDetail(int $service_id)
    {
        return success((new VolunteerServiceService())->getServiceDetail($service_id));
    }

    public function volunteerProfile(int $volunteer_id)
    {
        return success((new VolunteerServiceService())->getVolunteerProfile($volunteer_id));
    }

    public function apply()
    {
        $data = $this->request->params([
            ['nickname', ''],
            ['phone', ''],
            ['skills', []],
            ['intro', ''],
        ]);
        $this->validate($data, 'app\validate\volunteer\VolunteerApply.add');
        $res = (new VolunteerService())->apply($this->member_id, $data);
        return success('volunteer_apply_success', ['volunteer_id' => $res]);
    }

    public function myVolunteer()
    {
        return success((new VolunteerService())->getMyVolunteer($this->member_id));
    }

    public function isVolunteer()
    {
        $is_volunteer = (new VolunteerService())->isVolunteer($this->member_id);
        return success('', ['is_volunteer' => $is_volunteer]);
    }

    public function publishService()
    {
        $data = $this->request->params([
            ['category_id', 0],
            ['service_name', ''],
            ['service_cover', ''],
            ['service_images', []],
            ['service_desc', ''],
            ['point_price', 0],
            ['service_unit', '次'],
            ['service_duration', 60],
            ['service_area', ''],
        ]);
        $this->validate($data, 'app\validate\volunteer\VolunteerService.add');
        $res = (new VolunteerService())->publishService($this->member_id, $data);
        return success('volunteer_service_publish_success', ['service_id' => $res]);
    }

    public function myService()
    {
        return success((new VolunteerService())->getMyService($this->member_id));
    }

    public function editService(int $service_id)
    {
        $data = $this->request->params([
            ['category_id', 0],
            ['service_name', ''],
            ['service_cover', ''],
            ['service_images', []],
            ['service_desc', ''],
            ['point_price', 0],
            ['service_unit', '次'],
            ['service_duration', 60],
            ['service_area', ''],
        ]);
        (new VolunteerService())->editService($this->member_id, $service_id, $data);
        return success('EDIT_SUCCESS');
    }

    public function createOrder()
    {
        $data = $this->request->params([
            ['service_id', 0],
            ['service_time', 0],
            ['service_address', ''],
            ['service_remark', ''],
        ]);
        $this->validate($data, 'app\validate\volunteer\VolunteerOrder.create');
        $res = (new VolunteerOrderService())->createOrder($this->member_id, $data);
        return success('volunteer_order_create_success', ['order_id' => $res]);
    }

    public function orderLists()
    {
        $data = $this->request->params([
            ['status', ''],
            ['page', 1],
            ['limit', 20],
        ]);
        return success((new VolunteerOrderService())->getOrderList($this->member_id, $data));
    }

    public function myServeOrderLists()
    {
        $data = $this->request->params([
            ['status', ''],
            ['page', 1],
            ['limit', 20],
        ]);
        return success((new VolunteerOrderService())->getMyServeOrderList($this->member_id, $data));
    }

    public function orderDetail(int $order_id)
    {
        return success((new VolunteerOrderService())->getOrderDetail($this->member_id, $order_id));
    }

    public function cancelOrder(int $order_id)
    {
        (new VolunteerOrderService())->cancelOrder($this->member_id, $order_id);
        return success('volunteer_order_cancel_success');
    }

    public function confirmOrder()
    {
        $data = $this->request->params([
            ['order_id', 0],
            ['status', 2],
        ]);
        (new VolunteerOrderService())->confirmOrder($this->member_id, $data['order_id'], $data['status']);
        return success('EDIT_SUCCESS');
    }

    public function startService(int $order_id)
    {
        (new VolunteerOrderService())->startService($this->member_id, $order_id);
        return success('EDIT_SUCCESS');
    }

    public function finishService(int $order_id)
    {
        (new VolunteerOrderService())->finishService($this->member_id, $order_id);
        return success('EDIT_SUCCESS');
    }

    public function createEvaluation()
    {
        $data = $this->request->params([
            ['order_id', 0],
            ['score', 5],
            ['content', ''],
            ['images', []],
        ]);
        (new VolunteerOrderService())->createEvaluation($this->member_id, $data['order_id'], $data);
        return success('volunteer_evaluation_success');
    }

    public function replyEvaluation()
    {
        $data = $this->request->params([
            ['evaluation_id', 0],
            ['reply', ''],
        ]);
        (new VolunteerOrderService())->replyEvaluation($this->member_id, $data['evaluation_id'], $data['reply']);
        return success('volunteer_reply_success');
    }
}
