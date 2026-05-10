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

use app\service\core\weapp\CoreWeappTemplateMessage;
use core\base\BaseController;

/**
 * 微信小程序消息测试
 */
class Weapp extends BaseController
{
    /**
     * 发送商城订单支付通知
     * @return 	hink\response\Json
     */
    public function sendShopOrderPay()
    {
        $params = $this->request->params([
            [ 'open_id', '' ],
            [ 'order_no', '' ],
            [ 'create_time', '' ],
            [ 'body', '' ],
            [ 'order_money', '' ],
            [ 'page', '' ]
        ]);
        $weapp_template_message = new CoreWeappTemplateMessage();
        $result = $weapp_template_message->sendShopOrderPay(
            $params['open_id'],
            $params['order_no'],
            $params['create_time'],
            $params['body'],
            $params['order_money'],
            $params['page']
        );
        
        return success($result);
    }
}