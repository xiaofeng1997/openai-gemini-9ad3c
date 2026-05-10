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

namespace app\model\api\pointshop;

use app\model\pointshop\PointOrder as OrderModel;
use app\model\member\MemberAddress;
use core\base\BaseModel;

/**
 * API端积分订单模型
 * Class PointOrder
 * @package app\model\api\pointshop
 */
class PointOrder extends BaseModel
{
    public function member()
    {
        return $this->hasOne(\app\model\member\Member::class, 'member_id', 'member_id');
    }

    public function goods()
    {
        return $this->hasOne(\app\model\pointshop\PointGoods::class, 'goods_id', 'goods_id');
    }

    public function address()
    {
        return $this->hasOne(MemberAddress::class, 'address_id', 'address_id');
    }
}
