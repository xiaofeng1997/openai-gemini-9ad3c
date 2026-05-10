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

use core\base\BaseModel;
use think\model\concern\SoftDelete;

/**
 * 积分订单模型
 * Class PointOrder
 * @package app\model\pointshop
 */
class PointOrder extends BaseModel
{
    use SoftDelete;

    protected $pk = 'order_id';
    protected $name = 'point_order';

    protected $deleteTime = 'delete_time';
    protected $defaultSoftDelete = 0;

    protected $type = [
        'address' => 'json',
    ];

    /**
     * 订单状态
     */
    const STATUS_WAIT = 1;  // 待发货
    const STATUS_DELIVER = 2;  // 已发货
    const STATUS_COMPLETE = 3;  // 已完成
    const STATUS_CANCEL = -1;  // 已取消

    /**
     * 获取状态名称
     * @param $value
     * @param $data
     * @return string
     */
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

    /**
     * 会员关联
     */
    public function member()
    {
        return $this->hasOne(\app\model\member\Member::class, 'member_id', 'member_id')
            ->bind(['nickname', 'mobile', 'headimg']);
    }

    /**
     * 商品关联
     */
    public function goods()
    {
        return $this->hasOne(PointGoods::class, 'goods_id', 'goods_id')
            ->bind(['goods_name', 'goods_image', 'point_price']);
    }

    /**
     * 关键字搜索
     */
    public function searchKeywordAttr($query, $value, $data)
    {
        if ($value) {
            $query->where('order_no|member.nickname|member.mobile', 'like', '%' . $this->handelSpecialCharacter($value) . '%');
        }
    }

    /**
     * 状态搜索
     */
    public function searchStatusAttr($query, $value, $data)
    {
        if ($value !== '') {
            $query->where('status', '=', $value);
        }
    }

    /**
     * 时间搜索
     */
    public function searchCreateTimeAttr($query, $value, $data)
    {
        if (!empty($value)) {
            $start = strtotime($value[0]);
            $end = strtotime($value[1]);
            $query->whereBetweenTime('create_time', $start, $end);
        }
    }
}
