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
 * 积分商品模型
 * Class PointGoods
 * @package app\model\pointshop
 */
class PointGoods extends BaseModel
{
    use SoftDelete;

    protected $pk = 'goods_id';
    protected $name = 'point_goods';

    protected $deleteTime = 'delete_time';
    protected $defaultSoftDelete = 0;

    protected $type = [
        'goods_images' => 'json',
    ];

    /**
     * 获取状态名称
     * @param $value
     * @param $data
     * @return string
     */
    public function getStatusNameAttr($value, $data)
    {
        return $data['status'] == 1 ? '上架' : '下架';
    }

    /**
     * 分类关联
     */
    public function category()
    {
        return $this->hasOne(PointCategory::class, 'category_id', 'category_id')->bind(['category_name' => 'category_name']);
    }

    /**
     * 关键字搜索
     */
    public function searchKeywordAttr($query, $value, $data)
    {
        if ($value) {
            $query->where('goods_name', 'like', '%' . $this->handelSpecialCharacter($value) . '%');
        }
    }

    /**
     * 分类搜索
     */
    public function searchCategoryIdAttr($query, $value, $data)
    {
        if ($value) {
            $query->where('category_id', '=', $value);
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
}
