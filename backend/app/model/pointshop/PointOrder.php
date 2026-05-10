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

namespace app\model\pointshop;

use app\model\member\Member;
use core\base\BaseModel;
use think\model\concern\SoftDelete;

class PointOrder extends BaseModel
{
    use SoftDelete;

    protected $pk = 'order_id';
    protected $name = 'point_order';
    protected $deleteTime = 'delete_time';
    protected $defaultSoftDelete = 0;
    protected $type = ['address' => 'json'];

    const STATUS_CANCEL = -1;
    const STATUS_WAIT_DELIVER = 1;
    const STATUS_DELIVERED = 2;
    const STATUS_COMPLETED = 3;

    public function getStatusNameAttr($value, $data)
    {
        $status = [
            -1 => '已取消',
            1 => '待发货',
            2 => '已发货',
            3 => '已完成',
        ];
        return $status[$data['status']] ?? '';
    }

    public function member()
    {
        return $this->hasOne(Member::class, 'member_id', 'member_id')
            ->joinType('left')
            ->bind(['nickname', 'mobile', 'headimg']);
    }

    public function goods()
    {
        return $this->hasOne(PointGoods::class, 'goods_id', 'goods_id')
            ->joinType('left')
            ->bind(['goods_name', 'goods_image', 'point_price']);
    }

    public function searchKeywordAttr($query, $value, $data)
    {
        if ($value) {
            $query->whereLike('order_no|member.nickname|member.mobile', '%' . $this->handelSpecialCharacter($value) . '%');
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
