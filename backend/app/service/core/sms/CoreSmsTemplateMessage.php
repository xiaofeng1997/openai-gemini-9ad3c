<?php
namespace app\service\core\sms;

class CoreSmsTemplateMessage
{



    
    /**
     * 发送管理端手机验证码
     * @param string $mobile 手机号
     * @param string $code 验证码
     * @return bool
     */
    public function sendVerifyCode(string $mobile, string $code)
    {
        $params = [
            'code' => $code
        ];
        $core_sms_service = new CoreSmsDriver();
        return $core_sms_service->sendTemplate($mobile, CoreSmsTemplateData::TEMPLATE_VERIFY_CODE, $params);
    }

    /**
     * 发送客户端手机验证码
     * @param string $mobile 手机号
     * @param string $code 验证码
     * @return bool
     */
    public function sendMemberVerifyCode(string $mobile, string $code)
    {
        $params = [
            'code' => $code
        ];
        $core_sms_service = new CoreSmsDriver();
        return $core_sms_service->sendTemplate($mobile, CoreSmsTemplateData::TEMPLATE_MEMBER_VERIFY_CODE, $params);
    }

    /**
     * 发送业务通知短信
     * @param string $mobile 手机号
     * @param string $amount 金额
     * @param string $date 通知时间
     * @param string $chinese 业务备注
     * @param string $others 其他信息
     * @return bool
     */
    public function sendBusinessNotice(string $mobile, string $amount, string $date, string $chinese, string $others)
    {
        $params = [
            'amount' => $amount,
            'date' => $date,
            'chinese' => $chinese,
            'others' => $others
        ];
        $core_sms_service = new CoreSmsDriver();
        return $core_sms_service->sendTemplate($mobile, CoreSmsTemplateData::TEMPLATE_BUSINESS_NOTICE, $params);
    }
}