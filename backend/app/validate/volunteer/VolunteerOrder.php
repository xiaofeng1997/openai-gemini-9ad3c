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

class VolunteerOrder extends Validate
{
    protected $rule = [
        'service_id' => 'require|number',
        'service_time' => 'require|number',
        'service_address' => 'require|max:255',
        'service_remark' => 'max:500',
    ];

    protected $message = [
        'service_id.require' => 'service_id_require',
        'service_time.require' => 'service_time_require',
        'service_address.require' => 'service_address_require',
    ];

    protected $scene = [
        'create' => ['service_id', 'service_time', 'service_address'],
    ];
}
