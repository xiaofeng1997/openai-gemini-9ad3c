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

namespace app\dict\pay;

use app\dict\common\ChannelDict;

class PayChannelDict
{

    /**
     * 支付渠道类型
     * @return array
     */
    public static function getPayChannel(array $types = [])
    {
        $channel = ChannelDict::getType();
        $list = [];
        $pay_type = PayDict::getPayType();
        foreach ($channel as $k => $v) {
            $temp_pay_type = $pay_type;
            $list[ $k ] = [
                'name' => $v,
                'key' => $k,
                'pay_type' => $pay_type
            ];
        }
        return $list;
    }

}
