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

namespace app\service\core\weapp;

/**
 * 微信小程序模板数据类
 * Class CoreWeappTemplateData
 * @package app\service\core\weapp
 */
class CoreWeappTemplateData
{
    // 微信小程序模板key常量
    public const TEMPLATE_SHOP_ORDER_PAY = 'shop_order_pay';

    /**
     * 获取所有微信小程序模板
     * @return array
     */
    public static function getWeappTemplates()
    {
        return [
            self::TEMPLATE_SHOP_ORDER_PAY => [
                'key' => self::TEMPLATE_SHOP_ORDER_PAY,
                'name' => '订单支付通知',
                'tid' => '30808',
                'content' => [
                    ['订单编号', '{order_no}', 'character_string1'],
                    ['下单时间', '{create_time}', 'time2'],
                    ['商品名称', '{body}', 'thing4'],
                    ['订单金额', '{order_money}', 'amount3'],
                ],
                'kid_list' => [1, 2, 4, 3],
                'scene_desc' => '订单支付之后通知',
                'tips' => '使用该消息请在小程序的服务类目中添加类目：一级类目：商业服务 二级类目：软件/建站/技术开发'
            ],
        ];
    }

    /**
     * 根据key获取特定微信小程序模板
     * @param string $key
     * @return array
     */
    public static function getWeappTemplate(string $key)
    {
        $templates = self::getWeappTemplates();
        return $templates[$key] ?? [];
    }
}
