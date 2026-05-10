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

namespace app\service\core\sms;

/**
 * 短信模板数据类
 * Class CoreSmsTemplateData
 * @package app\service\core\sms
 */
class CoreSmsTemplateData
{
    // 短信模板key常量
    public const TEMPLATE_VERIFY_CODE = 'verify_code';
    public const TEMPLATE_MEMBER_VERIFY_CODE = 'member_verify_code';
    public const TEMPLATE_BUSINESS_NOTICE = 'business_notice';

    /**
     * 获取所有短信模板
     * @return array
     */
    public static function getSmsTemplates()
    {
        return [
            //管理端手机验证码
            self::TEMPLATE_VERIFY_CODE => [
                'key' => self::TEMPLATE_VERIFY_CODE,
                'receiver_type' => 0,
                'name' => '管理端手机验证码',
                'title' => '管理端验证码登录',
                'async' => false,
                'variable' => [
                    'code' => '验证码'
                ],
                'is_need_closure_content' => 0,
                'content' => '您的手机验证码{code}，请不要轻易告诉其他人',
                // 模版参数   !!牛云短信特有
                'param_json' =>[]
            ],
            //客户端手机验证码
            self::TEMPLATE_MEMBER_VERIFY_CODE => [
                'key' => self::TEMPLATE_MEMBER_VERIFY_CODE,
                'receiver_type' => 1,
                'name' => '客户端手机验证码',
                'title' => '前端验证码登录，注册，手机验证',
                'async' => false,
                'variable' => [
                    'code' => '验证码'
                ],
                'is_need_closure_content' => 0,
                'content' => '您的手机验证码{code}，请不要轻易告诉其他人',
              // 模版参数   !!牛云短信特有
                'param_json' => [
                    'code' => 'valid_code'
                ]
            ],
            //业务通知短信  (测试使用)
            self::TEMPLATE_BUSINESS_NOTICE => [
                'key' => self::TEMPLATE_BUSINESS_NOTICE,
                'receiver_type' => 1,
                'name' => '业务通知短信',
                'title' => '业务通知',
                'async' => false,
                'variable' => [
                    'amount' => '金额',
                    'date' => '通知时间',
                    'chinese' => '业务备注',
                    'others' => '其他信息'
                ],
                'is_need_closure_content' => 0,
                'content' => '您涉及金额 {amount}，通知时间 {date}，业务备注 {chinese}，其他信息 {others}。请及时核对。',
                // 模版参数   !!牛云短信特有
                'param_json' => [
                    'amount' => 'amount',
                    'date' => 'date',
                    'chinese' => 'chinese',
                    'others' => 'others'
                ]
            ]
        ];
    }

    /**
     * 根据key获取特定短信模板
     * @param string $key
     * @return array
     */
    public static function getSmsTemplate(string $key)
    {
        $templates = self::getSmsTemplates();
        return $templates[$key] ?? [];
    }
}