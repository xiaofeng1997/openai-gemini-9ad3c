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

namespace app\validate\volunteer;

use think\Validate;

class VolunteerApply extends Validate
{
    protected $rule = [
        'nickname' => 'require|max:50',
        'phone' => 'require|phone',
        'intro' => 'max:500',
    ];

    protected $message = [
        'nickname.require' => 'nickname_require',
        'phone.require' => 'phone_require',
    ];

    protected $scene = [
        'add' => ['nickname', 'phone'],
    ];
}
