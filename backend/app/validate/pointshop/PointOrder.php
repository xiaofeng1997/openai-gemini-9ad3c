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

namespace app\validate\pointshop;

use think\Validate;

class PointOrder extends Validate
{
    protected $rule = [
        'order_id' => 'require|number',
        'express_company' => 'require|max:50',
        'express_no' => 'require|max:50',
    ];

    protected $message = [
        'order_id.require' => 'order_id_require',
        'order_id.number' => 'order_id_number',
        'express_company.require' => 'express_company_require',
        'express_company.max' => 'express_company_max',
        'express_no.require' => 'express_no_require',
        'express_no.max' => 'express_no_max',
    ];

    protected $scene = [
        'deliver' => ['order_id', 'express_company', 'express_no'],
    ];
}
