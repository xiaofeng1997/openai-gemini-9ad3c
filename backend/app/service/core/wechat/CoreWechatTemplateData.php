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

namespace app\service\core\wechat;

/**
 * 微信公众号模板数据类
 * Class CoreWechatTemplateData
 * @package app\service\core\wechat
 */
class CoreWechatTemplateData
{
    // 微信模板key常量
    public const TEMPLATE_SHOP_ORDER_PAY = 'shop_order_pay';

    /**
     * 获取所有微信模板
     * @return array
     */
    public static function getWechatTemplates()
    {
        return [
            self::TEMPLATE_SHOP_ORDER_PAY => [
                'key' => self::TEMPLATE_SHOP_ORDER_PAY,
                'name' => '订单支付通知',
                'temp_key' => '43216',
                'content' => [
                    ['下单时间', '{create_time}', 'time4'],
                    ['订单编号', '{order_no}', 'character_string2'],
                    ['商品信息', '{body}', 'thing3'],
                    ['订单金额', '{order_money}', 'amount5']
                ],
                'keyword_name_list' => ["下单时间", "订单号", "商品名称", "支付金额"],
                'tips' => '使用该消息请将微信公众号服务类目选择为：生活服务——>百货/超市/便利店'
            ],
        ];
    }

    /**
     * 根据key获取特定微信模板
     * @param string $key
     * @return array
     */
    public static function getWechatTemplate(string $key)
    {
        $templates = self::getWechatTemplates();
        return $templates[$key] ?? [];
    }
}
