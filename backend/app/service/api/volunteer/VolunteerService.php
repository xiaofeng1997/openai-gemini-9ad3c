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

use app\model\volunteer\Volunteer;
use app\model\member\Member;
use app\service\core\member\CoreMemberAccountService;
use core\exception\ApiException;
use think\facade\Db;

class VolunteerService
{
    public function apply(int $member_id, array $data)
    {
        $member = (new Member())->find($member_id);
        if (empty($member)) {
            throw new ApiException('member_not_exist');
        }

        $exist = (new Volunteer())->where(['member_id' => $member_id])->find();
        if ($exist) {
            throw new ApiException('volunteer_already_apply');
        }

        $point_threshold = 500;
        if ($member['point'] < $point_threshold) {
            throw new ApiException('volunteer_point_not_enough');
        }

        $volunteer_id = (new Volunteer())->insertGetId([
            'member_id' => $member_id,
            'nickname' => $data['nickname'] ?? $member['nickname'],
            'avatar' => $data['avatar'] ?? $member['headimg'],
            'phone' => $data['phone'],
            'skills' => json_encode($data['skills'] ?? []),
            'intro' => $data['intro'] ?? '',
            'point_threshold' => $point_threshold,
            'status' => 0,
            'apply_time' => time(),
            'create_time' => time(),
            'update_time' => time(),
        ]);

        return $volunteer_id;
    }

    public function getMyVolunteer(int $member_id)
    {
        $volunteer = (new Volunteer())->where(['member_id' => $member_id])->find();

        if (empty($volunteer)) {
            return null;
        }

        return $volunteer->toArray();
    }

    public function isVolunteer(int $member_id)
    {
        $volunteer = (new Volunteer())->where(['member_id' => $member_id, 'status' => 1])->find();
        return !empty($volunteer);
    }

    public function publishService(int $member_id, array $data)
    {
        $volunteer = (new Volunteer())->where(['member_id' => $member_id, 'status' => 1])->find();
        if (empty($volunteer)) {
            throw new ApiException('volunteer_not_certified');
        }

        $service_id = (new \app\model\volunteer\VolunteerService())->insertGetId([
            'category_id' => $data['category_id'],
            'volunteer_id' => $volunteer['volunteer_id'],
            'service_name' => $data['service_name'],
            'service_cover' => $data['service_cover'],
            'service_images' => json_encode($data['service_images'] ?? []),
            'service_desc' => $data['service_desc'] ?? '',
            'point_price' => $data['point_price'],
            'service_unit' => $data['service_unit'] ?? '次',
            'service_duration' => $data['service_duration'] ?? 60,
            'service_area' => $data['service_area'] ?? '',
            'status' => 1,
            'is_template' => 0,
            'create_time' => time(),
            'update_time' => time(),
        ]);

        return $service_id;
    }

    public function getMyService(int $member_id)
    {
        $volunteer = (new Volunteer())->where(['member_id' => $member_id, 'status' => 1])->find();
        if (empty($volunteer)) {
            return [];
        }

        return (new \app\model\volunteer\VolunteerService())
            ->where(['volunteer_id' => $volunteer['volunteer_id']])
            ->order('service_id desc')
            ->select()
            ->toArray();
    }

    public function editService(int $member_id, int $service_id, array $data)
    {
        $volunteer = (new Volunteer())->where(['member_id' => $member_id, 'status' => 1])->find();
        if (empty($volunteer)) {
            throw new ApiException('volunteer_not_certified');
        }

        $service = (new \app\model\volunteer\VolunteerService())
            ->where(['service_id' => $service_id, 'volunteer_id' => $volunteer['volunteer_id']])
            ->find();
        if (empty($service)) {
            throw new ApiException('volunteer_service_not_exist');
        }

        (new \app\model\volunteer\VolunteerService())
            ->where(['service_id' => $service_id])
            ->update([
                'category_id' => $data['category_id'],
                'service_name' => $data['service_name'],
                'service_cover' => $data['service_cover'],
                'service_images' => json_encode($data['service_images'] ?? []),
                'service_desc' => $data['service_desc'] ?? '',
                'point_price' => $data['point_price'],
                'service_unit' => $data['service_unit'] ?? '次',
                'service_duration' => $data['service_duration'] ?? 60,
                'service_area' => $data['service_area'] ?? '',
                'update_time' => time(),
            ]);

        return true;
    }
}
