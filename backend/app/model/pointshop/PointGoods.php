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

class PointGoods extends BaseModel
{
    use SoftDelete;

    protected $pk = 'goods_id';
    protected $name = 'point_goods';
    protected $deleteTime = 'delete_time';
    protected $defaultSoftDelete = 0;
    protected $type = ['goods_images' => 'json'];

    public function getStatusNameAttr($value, $data)
    {
        return $data['status'] == 1 ? '已上架' : '已下架';
    }

    public function category()
    {
        return $this->hasOne(PointCategory::class, 'category_id', 'category_id')
            ->joinType('left')
            ->bind(['category_name']);
    }

    public function searchKeywordAttr($query, $value, $data)
    {
        if ($value) {
            $query->whereLike('goods_name', '%' . $this->handelSpecialCharacter($value) . '%');
        }
    }

    public function searchCategoryIdAttr($query, $value, $data)
    {
        if ($value) {
            $query->where('category_id', $value);
        }
    }

    public function searchStatusAttr($query, $value, $data)
    {
        if ($value !== '') {
            $query->where('status', $value);
        }
    }
}
