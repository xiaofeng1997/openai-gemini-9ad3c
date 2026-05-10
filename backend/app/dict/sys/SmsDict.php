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

namespace app\dict\sys;

/**
 * 短信枚举类
 * Class SmsDict
 * @package app\dict\sys
 */
class SmsDict
{
    //阿里云短信
    public const ALISMS = 'aliyun';
    public const NIUSMS = 'niuyun';
    //腾讯云短信
    public const TENCENTSMS = 'tencent';
    public const SENDING = 'sending';
    public const SUCCESS = 'success';
    public const FAIL = 'fail';
    public const LOGIN = 'login';
    public const REGISTER = 'register';
    public const BIND_MOBILE = 'bind_mobile';
    public const FIND_PASS = 'find_pass';
    public const SCENE_TYPE = [
        self::LOGIN,
        self::REGISTER,
        self::BIND_MOBILE,
        self::FIND_PASS
    ];

    public static function getType()
    {
        $system = [
            self::NIUSMS => [
                'name' => '牛云短信',
                //配置参数
                'params' => [],
                'encrypt_params' => [],
                'show_type'=>'view',
                'view' => '/src/views/setting/sms_niu.vue',
                'component' => '',
            ],
            self::ALISMS => [
                'name' => '阿里云短信',
                //配置参数
                'params' => [
                    'sign' => '短信签名',
                    'app_key' => 'APP_KEY',
                    'secret_key' => 'SECRET_KEY'
                ],
                'encrypt_params' => ['secret_key'],
                'show_type'=>'component',
                'component' => '/src/views/setting/components/sms-ali.vue',
            ],
            self::TENCENTSMS => [
                'name' => '腾讯云短信',
                //配置参数
                'params' => [
                    'sign' => '短信签名',
                    'app_id' => 'APP_ID',
                    'secret_id' => 'SECRET_ID',
                    'secret_key' => 'SECRET_KEY'
                ],
                'encrypt_params' => ['secret_key'],
                'show_type'=>'component',
                'component' => '/src/views/setting/components/sms-tencent.vue',
            ],
        ];
        $extend = event('SmsType');
        return array_merge($system, ...$extend);
    }

    //支持的短信场景

    public static function getStatusType()
    {
        return [
            self::SENDING => 'dict_sms.status_sending',
            self::SUCCESS => 'dict_sms.status_success',
            self::FAIL => 'dict_sms.status_fail',
        ];
    }

    // 牛云短信特有的字典方法

    // 签名审核状态
    public const API_AUDIT_RESULT_WAIT = 1;
    public const API_AUDIT_RESULT_PASS = 2;
    public const API_AUDIT_RESULT_REFUSE = 3;

    // 余额分配类型
    public const BALANCE_RECHARGE_ADD = 1;
    public const BALANCE_RECHARGE_REDUCE = 2;

    // 参数类型
    public const PARAMS_TYPE_VALID_CODE = 'valid_code';
    public const PARAMS_TYPE_MOBILE_NUMBER = 'mobile_number';
    public const PARAMS_TYPE_OTHER_NUMBER = 'other_number';
    public const PARAMS_TYPE_AMOUNT = 'amount';
    public const PARAMS_TYPE_DATE = 'date';
    public const PARAMS_TYPE_CHINESE = 'chinese';
    public const PARAMS_TYPE_OTHERS = 'others';

    /**
     * 获取签名审核状态
     * @param string $type
     * @return array|string
     */
    public static function getSignAuditType(string $type = '')
    {
        $data = [
            self::API_AUDIT_RESULT_WAIT => get_lang('dict_sms_api.sign_audit_status_wait'),
            self::API_AUDIT_RESULT_PASS => get_lang('dict_sms_api.sign_audit_status_pass'),
            self::API_AUDIT_RESULT_REFUSE => get_lang('dict_sms_api.sign_audit_status_refuse'),
        ];
        return $type ? $data[$type] : $data;
    }

    /**
     * 获取余额分配类型
     * @param string $type
     * @return array|string
     */
    public static function getBalanceAllocateType(string $type = '')
    {
        $data = [
            self::BALANCE_RECHARGE_ADD => get_lang('dict_sms_api.balance_add'),
            self::BALANCE_RECHARGE_REDUCE => get_lang('dict_sms_api.balance_reduce'),
        ];
        return $type ? $data[$type] : $data;
    }

    /**
     * 获取签名来源
     * @param string $source
     * @return array
     */
    public static function getSignSource(string $source = '')
    {
        $data = [
            ['type' => 1, 'name' => '企业名称'],
            ['type' => 2, 'name' => '事业单位'],
            ['type' => 3, 'name' => '商标'],
            ['type' => 4, 'name' => 'APP'],
            ['type' => 5, 'name' => '小程序'],
        ];
        return $source ? [] : $data;
    }

    /**
     * 获取签名类型
     * @param string $type
     * @return array
     */
    public static function getSignType(string $type = '')
    {
        $data = [
            ['type' => 0, 'name' => '全称'],
            ['type' => 1, 'name' => '简称'],
        ];
        return $type ? [] : $data;
    }

    /**
     * 获取签名默认设置
     * @param string $type
     * @return array
     */
    public static function getSignDefault(string $type = '')
    {
        $data = [
            ['type' => 0, 'name' => '否'],
            ['type' => 1, 'name' => '是'],
        ];
        return $type ? [] : $data;
    }

    /**
     * 获取API参数类型
     * @return array
     */
    public static function getApiParamsType()
    {
        return [
            [
                'name' => '验证码',
                'type' => self::PARAMS_TYPE_VALID_CODE,
                'desc' => '4-6位纯数字',
                'rule' => '/^\d$/',
                'min'=>4,
                'max'=>6
            ],
            [
                'name' => '手机号',
                'type' => self::PARAMS_TYPE_MOBILE_NUMBER,
                'desc' => '1-15位纯数字',
                'rule' => '/^\d$/',
                'min'=>1,
                'max'=>15
            ],
            [
                'name' => '其他号码',
                'type' => self::PARAMS_TYPE_OTHER_NUMBER,
                'desc' => '1-32位字母+数字组合',
                'rule'=>'/^[a-zA-Z0-9]$/',
                'min'=>1,
                'max'=>32
            ],
            [
                'name' => '金额',
                'type' => self::PARAMS_TYPE_AMOUNT,
                'desc' => '支持数字或数字的中文 （壹贰叁肆伍陆柒捌玖拾佰仟万亿 圆元整角分厘毫）',
                'rule' => "/^(?:\d+|(?:[零壹贰叁肆伍陆柒捌玖拾佰仟万亿圆角分厘毫]+|圆|元|整)+)$/u"
            ],
            [
                'name' => '日期',
                'type' => self::PARAMS_TYPE_DATE,
                'desc' => '符合时间的表达方式 也支持中文：2019年9月3日16时24分35秒',
                'rule' => ''
            ],
            [
                'name' => '中文',
                'type' => self::PARAMS_TYPE_CHINESE,
                'desc' => '1-32中文，支持中文园括号()',
                'rule' => '/^[\p{Han}()（）]$/u',
                'min'=>1,
                'max'=>32
            ],
            [
                'name' => '其他',
                'type' => self::PARAMS_TYPE_OTHERS,
                'desc' => ' 1-35个中文数字字母组合，支持中文符号和空格',
                'rule' => '/^[\p{Han}\p{N}\p{L}\p{P}\p{S}\s]$/u',
                'min'=>1,
                'max'=>35
            ],
        ];
    }

}
