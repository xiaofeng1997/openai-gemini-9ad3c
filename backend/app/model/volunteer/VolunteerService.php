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

use core\base\BaseModel;
use think\model\concern\SoftDelete;

class VolunteerService extends BaseModel
{
    use SoftDelete;

    protected $pk = 'service_id';
    protected $name = 'volunteer_service';
    protected $deleteTime = 'delete_time';
    protected $defaultSoftDelete = 0;
    protected $type = ['service_images' => 'json'];

    const STATUS_PENDING = 0;
    const STATUS_ONLINE = 1;
    const STATUS_OFFLINE = 2;

    public function getStatusNameAttr($value, $data)
    {
        $status = [
            0 => '待审核',
            1 => '已上架',
            2 => '已下架',
        ];
        return $status[$data['status']] ?? '';
    }

    public function category()
    {
        return $this->hasOne(VolunteerCategory::class, 'category_id', 'category_id')
            ->joinType('left')
            ->bind(['category_name']);
    }

    public function volunteer()
    {
        return $this->hasOne(Volunteer::class, 'volunteer_id', 'volunteer_id')
            ->joinType('left')
            ->bind(['volunteer_nickname' => 'nickname', 'volunteer_avatar' => 'avatar']);
    }

    public function searchKeywordAttr($query, $value, $data)
    {
        if ($value) {
            $query->whereLike('service_name', '%' . $this->handelSpecialCharacter($value) . '%');
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
