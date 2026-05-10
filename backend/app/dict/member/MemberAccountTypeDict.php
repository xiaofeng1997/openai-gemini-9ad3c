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

namespace app\dict\member;


/**
 * 会员账户类型
 * Class MemberAccountTypeDict
 * @package app\dict\member
 */
class MemberAccountTypeDict
{
    //会员积分
    public const POINT = 'point';
    //会员余额
    public const BALANCE = 'balance';

    //会员可提现余额
    public const MONEY = 'money';

    //会员佣金
    public const COMMISSION = 'commission';

    public const GROWTH = 'growth';

    public static function getType($type = '')
    {
        $data = [
            self::POINT => get_lang('dict_member.account_point'),
            self::BALANCE => get_lang('dict_member.account_balance'),
            self::MONEY => get_lang('dict_member.account_money'),
            self::COMMISSION => get_lang('dict_member.account_commission'),
            self::GROWTH => get_lang('dict_member.account_growth'),
        ];
        if (empty($type)) {
            return $data;
        }
        return $data[$type] ?? '';
    }

    /**
     * 权益规则
     * @return array
     */
    public static function getBenifitRule()
    {
        return [
            'discount' => [
                'key' => 'discount',
                'name' => '下单折扣', // 权益名称
                'desc' => '商品购买享受折扣优惠', // 权益说明
                "content" => [
                    'admin' => function ($config) {
                        return "下单享受{$config['discount']}折折扣";
                    },
                    'member_level' => function ($config) {
                        return [
                            'title' => "可享{$config['discount']}折",
                            'desc' => '购物折扣',
                            'icon' => '/static/resource/images/member/benefits/benefits_discount.png'
                        ];
                    }
                ]
            ]
        ];
    }

    /**
     * 成长值发放规则
     * @return array
     */
    public static function getGrowthRule()
    {
        return [
            'member_register' => [
                'key' => 'member_register',
                'name' => '用户注册',
                'desc' => '用户注册之后发放成长值',
                'calculate' => '', // 计算成长值
                'content' => [
                    'admin' => function ($config) {
                        return "用户注册之后发放{$config['growth']}成长值";
                    }
                ]
            ],
        ];
    }

    /**
     * 会员礼包规则
     * @return array
     */
    public static function getMemberGiftRule()
    {
            $dict =  [
                'balance' => [
                    'key' => 'balance',
                    'name' => '送红包', // 礼包名称
                    'desc' => '发放红包', // 礼包说明
                    'grant' => function ($member_id, $config, $param) {
                        $account_type = \app\dict\member\MemberAccountTypeDict::BALANCE;
                        $service = new \app\service\core\member\CoreMemberAccountService();
                        $service->addLog($member_id, $account_type, $config['money'], $param['from_type'] ?? '', $param['memo'] ?? '', $param['related_id'] ?? '');
                    },
                    'content' => [
                        'admin' => function ($config) {
                            return "{$config['money']}元红包";
                        },
                        // 会员等级
                        'member_level' => function ($config) {
                            $content = [];
                            $content[] = [
                                'text' => "{$config['money']}元",
                                'background' => '/static/resource/images/member/gift/gift_balance_bg.png'
                            ];
                            return $content;
                        },
                        // 会员签到（日签）
                        'member_sign' => function ($config) {
                            $content = [];
                            $content[] = [
                                'text' => "{$config['money']}元",
                                'icon' => '/static/resource/images/member/sign/packet.png'
                            ];
                            return $content;
                        },
                        // 会员签到（连签）
                        'member_sign_continue' => function ($config) {
                            $content = [];
                            $content[] = [
                                'text' => "{$config['money']}元",
                                'icon' => '/static/resource/images/member/sign/packet01.png'
                            ];
                            return $content;
                        }
                    ]
                ],
                'point' => [
                    'key' => 'point',
                    'name' => '送积分', // 礼包名称
                    'desc' => '发放积分', // 礼包说明
                    'grant' =>  function ($member_id, $config, $param) {
                        $account_type = \app\dict\member\MemberAccountTypeDict::POINT;
                        $service = new \app\service\core\member\CoreMemberAccountService();
                        $service->addLog($member_id, $account_type, $config['num'], $param['from_type'] ?? '', $param['memo'] ?? '', $param['related_id'] ?? '');
                    },
                    'content' => [
                        'admin' => function ($config) {
                            return "{$config['num']}积分";
                        },
                        'member_level' => function ($config) {
                            $content = [];
                            $content[] = [
                                'text' => "{$config['num']}积分",
                                'background' => '/static/resource/images/member/gift/gift_point_bg.png'
                            ];
                            return $content;
                        },
                        // 会员签到（日签）
                        'member_sign' => function ($config) {
                            $content = [];
                            $content[] = [
                                'text' => "{$config['num']}积分",
                                'icon' => '/static/resource/images/member/sign/point.png'
                            ];
                            return $content;
                        },
                        // 会员签到（连签）
                        'member_sign_continue' => function ($config) {
                            $content = [];
                            $content[] = [
                                'text' => "{$config['num']}积分",
                                'icon' => '/static/resource/images/member/sign/point01.png'
                            ];
                            return $content;
                        }
                    ]
                ]
            ];
            return $dict;

    }

        /**
     * 积分发放规则
     * @return array
     */
    public static function getPointGrantRule()
    {
        return [
            [
                'member_register' => [
                    'key' => 'member_register',
                    'name' => '用户注册',
                    'desc' => '用户注册之后发放积分',
                    'calculate' => '', // 计算成长值,
                    'content' => [
                        'admin' => function ($config) {
                            return "用户注册之后发放{$config['point']}积分";
                        }
                    ]
                ],
            ],
        ];
    }
    /**
     * 积分消费规则
     * @return array
     */
    public static function getPointConsumRule()
    {
        return [
           
        ];
    }

}
