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

namespace app\api\controller\demo;

use app\service\core\wechat\CoreWechatTemplateMessage;
use core\base\BaseApiController;
use EasyWeChat\Kernel\Exceptions\InvalidArgumentException;
use EasyWeChat\Kernel\Exceptions\InvalidConfigException;
use GuzzleHttp\Exception\GuzzleException;
use think\Response;

/**
 * 微信消息推送测试控制器
 */
class Wechat extends BaseApiController
{
    /**
     * 发送商城订单支付通知
     * @return Response
     * @throws InvalidArgumentException
     * @throws InvalidConfigException
     * @throws GuzzleException
     */
    public function sendShopOrderPay()
    {
        $data = $this->request->params([
            [ 'open_id', '' ],
            [ 'order_no', '' ],
            [ 'create_time', '' ],
            [ 'body', '' ],
            [ 'order_money', '' ],
            [ 'url', '' ]
        ]);
        
        if (empty($data['open_id'])) {
            return fail('open_id不能为空');
        }
        
        if (empty($data['order_no'])) {
            return fail('order_no不能为空');
        }
        
        if (empty($data['create_time'])) {
            return fail('create_time不能为空');
        }
        
        if (empty($data['body'])) {
            return fail('body不能为空');
        }
        
        if (empty($data['order_money'])) {
            return fail('order_money不能为空');
        }
        
        try {
            $wechat_message = new CoreWechatTemplateMessage();
            $result = $wechat_message->sendShopOrderPay(
                $data['open_id'],
                $data['order_no'],
                $data['create_time'],
                $data['body'],
                $data['order_money'],
                $data['url']
            );
            
            return success('微信消息推送成功', $result);
        } catch (\Exception $e) {
            return fail($e->getMessage());
        }
    }
}
