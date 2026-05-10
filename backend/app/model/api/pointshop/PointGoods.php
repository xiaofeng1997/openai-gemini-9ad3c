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

use app\model\pointshop\PointGoods as GoodsModel;
use app\model\pointshop\PointCategory;
use core\base\BaseModel;

/**
 * API端积分商品模型
 * Class PointGoods
 * @package app\model\api\pointshop
 */
class PointGoods extends BaseModel
{
    public function category()
    {
        return $this->hasOne(PointCategory::class, 'category_id', 'category_id');
    }
}
