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

namespace app\dict\diy;

/**
 * 自定义链接
 * Class LinkDict
 * @package app\dict\diy
 */
class LinkDict
{
    /**
     * @param array $params
     * @return array|null
     */
    public static function getLink()
    {
            $links = [
                'SYSTEM_BASE_LINK' => [
                    'title' => '系统页面',
                    'type' => 'folder', // 类型，folder 表示文件夹，link 表示链接
                    'child_list' => [
                        [
                            'name' => 'SYSTEM_LINK',
                            'title' => get_lang('dict_diy.system_link'),
                            'child_list' => [
                                [
                                    'name' => 'INDEX',
                                    'title' => get_lang('dict_diy.system_link_index'),
                                    'url' => '/pages/index/index',
                                    'is_share' => 1,
                                    'action' => 'decorate' // 默认空，decorate 表示支持装修
                                ],
                            ]
                        ],
                        [
                            'name' => 'MEMBER_LINK',
                            'title' => get_lang('dict_diy.member_link'),
                            'child_list' => [
                                [
                                    'name' => 'MEMBER_CENTER',
                                    'title' => get_lang('dict_diy.member_index'),
                                    'url' => '/pages/member/index',
                                    'is_share' => 1,
                                    'action' => 'decorate'
                                ],
                                [
                                    'name' => 'MEMBER_PERSONAL',
                                    'title' => get_lang('dict_diy.member_my_personal'),
                                    'url' => '/pages/member/personal',
                                    'is_share' => 0,
                                    'action' => ''
                                ],
                                [
                                    'name' => 'MEMBER_BALANCE',
                                    'title' => get_lang('dict_diy.member_my_balance'),
                                    'url' => '/pages/member/balance',
                                    'is_share' => 0,
                                    'action' => ''
                                ],
                                [
                                    'name' => 'MEMBER_POINT',
                                    'title' => get_lang('dict_diy.member_my_point'),
                                    'url' => '/pages/member/point',
                                    'is_share' => 0,
                                    'action' => ''
                                ],
                                [
                                    'name' => 'MEMBER_ADDRESS',
                                    'title' => get_lang('dict_diy.member_my_address'),
                                    'url' => '/pages/member/address',
                                    'is_share' => 0,
                                    'action' => ''
                                ],
                                [
                                    'name' => 'MEMBER_MY_LEVEL',
                                    'title' => get_lang('dict_diy.member_my_level'),
                                    'url' => '/pages/member/level',
                                    'is_share' => 0,
                                    'action' => ''
                                ],
                                [
                                    'name' => 'MEMBER_MY_SIGN_IN',
                                    'title' => get_lang('dict_diy.member_my_sign_in'),
                                    'url' => '/pages/member/sign_in',
                                    'is_share' => 0,
                                    'action' => ''
                                ],
                                [
                                    'name' => 'MEMBER_CONTACT',
                                    'title' => get_lang('dict_diy.member_contact'),
                                    'url' => '/pages/member/contact',
                                    'is_share' => 0,
                                    'action' => ''
                                ],
                            ]
                        ]
                    ]
                ],
                'OTHER_LINK' => [
                    'title' => '其他页面',
                    'type' => 'folder', // 类型，folder 表示文件夹，link 表示链接
                    'child_list' => [
                        [
                            'name' => 'DIY_LINK',
                            'title' => get_lang('dict_diy.diy_link'),
                        ],
                        [
                            'name' => 'DIY_JUMP_OTHER_APPLET',
                            'title' => get_lang('dict_diy.diy_jump_other_applet'),
                        ],
                        [
                            'name' => 'DIY_MAKE_PHONE_CALL',
                            'title' => get_lang('dict_diy.diy_make_phone_call'),
                        ]
                    ]
                ],
            ];
           
            return $links;
        }

}
