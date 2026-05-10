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
 * 积分商品分类模型
 * Class PointCategory
 * @package app\model\pointshop
 */
class PointCategory extends BaseModel
{
    use SoftDelete;

    protected $pk = 'category_id';
    protected $name = 'point_category';

    protected $deleteTime = 'delete_time';
    protected $defaultSoftDelete = 0;

    /**
     * 获取状态名称
     * @param $value
     * @param $data
     * @return string
     */
    public function getIsShowNameAttr($value, $data)
    {
        return $data['is_show'] == 1 ? '显示' : '隐藏';
    }
}
