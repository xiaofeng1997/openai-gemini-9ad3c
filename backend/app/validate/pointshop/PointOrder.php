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
        'order_id.require' => '订单ID不能为空',
        'order_id.number' => '订单ID必须为数字',
        'express_company.require' => '快递公司不能为空',
        'express_company.max' => '快递公司最多50个字符',
        'express_no.require' => '快递单号不能为空',
        'express_no.max' => '快递单号最多50个字符',
    ];

    protected $scene = [
        'deliver' => ['order_id', 'express_company', 'express_no'],
    ];
}
