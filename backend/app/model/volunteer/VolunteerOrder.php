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

namespace app\model\volunteer;

use app\model\member\Member;
use core\base\BaseModel;
use think\model\concern\SoftDelete;

class VolunteerOrder extends BaseModel
{
    use SoftDelete;

    protected $pk = 'order_id';
    protected $name = 'volunteer_order';
    protected $deleteTime = 'delete_time';
    protected $defaultSoftDelete = 0;

    const STATUS_PENDING = 1;
    const STATUS_CONFIRMED = 2;
    const STATUS_SERVICING = 3;
    const STATUS_FINISHED = 4;
    const STATUS_CANCELLED = 5;
    const STATUS_REJECTED = -1;

    public function getStatusNameAttr($value, $data)
    {
        $status = [
            -1 => '已拒绝',
            1 => '待确认',
            2 => '已确认',
            3 => '服务中',
            4 => '已完成',
            5 => '已取消',
        ];
        return $status[$data['status']] ?? '';
    }

    public function member()
    {
        return $this->hasOne(Member::class, 'member_id', 'member_id')
            ->joinType('left')
            ->bind(['member_nickname' => 'nickname', 'member_mobile' => 'mobile', 'member_headimg' => 'headimg']);
    }

    public function service()
    {
        return $this->hasOne(VolunteerService::class, 'service_id', 'service_id')
            ->joinType('left')
            ->bind(['service_name', 'service_cover', 'point_price']);
    }

    public function volunteer()
    {
        return $this->hasOne(Volunteer::class, 'volunteer_id', 'volunteer_id')
            ->joinType('left')
            ->bind(['volunteer_name' => 'nickname', 'volunteer_avatar' => 'avatar']);
    }

    public function evaluation()
    {
        return $this->hasOne(VolunteerEvaluation::class, 'order_id', 'order_id');
    }

    public function searchKeywordAttr($query, $value, $data)
    {
        if ($value) {
            $query->whereLike('order_no|member.member_nickname|member.member_mobile', '%' . $this->handelSpecialCharacter($value) . '%');
        }
    }

    public function searchStatusAttr($query, $value, $data)
    {
        if ($value !== '') {
            $query->where('status', $value);
        }
    }

    public function searchCreateTimeAttr($query, $value, $data)
    {
        if (!empty($value)) {
            $start = strtotime($value[0]);
            $end = strtotime($value[1]);
            $query->whereBetweenTime('create_time', $start, $end);
        }
    }
}
