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

namespace app\validate\volunteer;

use think\Validate;

class VolunteerService extends Validate
{
    protected $rule = [
        'service_name' => 'require|max:200',
        'category_id' => 'require|number',
        'service_cover' => 'require',
        'point_price' => 'require|number|egt:0',
        'service_unit' => 'require|max:20',
        'service_duration' => 'require|number|egt:0',
        'sort' => 'number|egt:0',
        'status' => 'require|number|in:0,1,2',
    ];

    protected $message = [
        'service_name.require' => 'service_name_require',
        'service_name.max' => 'service_name_max',
        'category_id.require' => 'category_id_require',
        'service_cover.require' => 'service_cover_require',
        'point_price.require' => 'point_price_require',
        'point_price.egt' => 'point_price_egt',
        'service_unit.require' => 'service_unit_require',
        'service_duration.require' => 'service_duration_require',
    ];

    protected $scene = [
        'add' => ['service_name', 'category_id', 'service_cover', 'point_price', 'service_unit', 'service_duration'],
        'edit' => ['service_name', 'category_id', 'service_cover', 'point_price', 'service_unit', 'service_duration'],
    ];
}
