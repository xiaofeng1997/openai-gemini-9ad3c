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

namespace app\validate\api;

use think\Validate;

class Pointshop extends Validate
{
    protected $rule = [
        'goods_id' => 'require|number',
        'address_id' => 'require|number',
        'num' => 'require|number|egt:1',
    ];

    protected $message = [
        'goods_id.require' => '请选择商品',
        'goods_id.number' => '商品ID必须是数字',
        'address_id.require' => '请选择收货地址',
        'address_id.number' => '地址ID必须是数字',
        'num.require' => '请选择兑换数量',
        'num.number' => '数量必须是数字',
        'num.egt' => '数量不能小于1',
    ];

    protected $scene = [
        'exchange' => ['goods_id', 'address_id', 'num'],
    ];
}
