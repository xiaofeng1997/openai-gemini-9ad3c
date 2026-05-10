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

namespace app\service\api\sms;

use app\service\core\sms\CoreSmsTemplateMessage;
use app\service\core\sms\CoreSmsTemplateData;
use core\base\BaseApiService;

/**
 * 短信服务
 * Class SmsService
 * @package app\service\api\sms
 */
class SmsService extends BaseApiService
{
    /**
     * 核心短信模板消息服务
     * @var CoreSmsTemplateMessage
     */
    protected $coreSmsTemplateMessage;

    public function __construct()
    {
        parent::__construct();
        $this->coreSmsTemplateMessage = new CoreSmsTemplateMessage();
    }

    /**
     * 通用发送方法
     * @param string $template_type 模板类型
     * @param string $mobile 手机号
     * @param array $params 参数
     * @return bool
     */
    public function send(string $template_type, string $mobile, array $params) {
        switch ($template_type) {
            case CoreSmsTemplateData::TEMPLATE_MEMBER_VERIFY_CODE:
                return $this->coreSmsTemplateMessage->sendMemberVerifyCode($mobile, $params['code']);
            case CoreSmsTemplateData::TEMPLATE_BUSINESS_NOTICE:
                return $this->coreSmsTemplateMessage->sendBusinessNotice(
                    $mobile,
                    $params['amount'],
                    $params['date'],
                    $params['chinese'],
                    $params['others']
                );
            case CoreSmsTemplateData::TEMPLATE_VERIFY_CODE:
                return $this->coreSmsTemplateMessage->sendVerifyCode($mobile, $params['code']);
            default:
                return false;
        }
    }

}
