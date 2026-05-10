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

use EasyWeChat\Kernel\Exceptions\InvalidArgumentException;
use EasyWeChat\Kernel\Exceptions\InvalidConfigException;
use EasyWeChat\Kernel\Support\Collection;
use GuzzleHttp\Exception\GuzzleException;
use Psr\Http\Message\ResponseInterface;

/**
 * 微信模板消息发送类
 */
class CoreWechatTemplateMessage
{
    /**
     * 发送商城订单支付通知
     * @param string $open_id
     * @param string $order_no 订单编号
     * @param string $create_time 下单时间
     * @param string $body 商品名称
     * @param string $order_money 订单金额
     * @param string $url 跳转链接
     * @return array|Collection|object|ResponseInterface|string
     * @throws InvalidArgumentException
     * @throws InvalidConfigException
     * @throws GuzzleException
     */
    public function sendShopOrderPay(string $open_id, string $order_no, string $create_time, string $body, string $order_money, string $url = '')
    {
        $params = [
            'order_no' => $order_no,
            'create_time' => $create_time,
            'body' => $body,
            'order_money' => $order_money
        ];
        $wechat_template_service = new CoreWechatTemplateService();
        return $wechat_template_service->sendTemplate($open_id, 'shop_order_pay', $params, $url);
    }

}