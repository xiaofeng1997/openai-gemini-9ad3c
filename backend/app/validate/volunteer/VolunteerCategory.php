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

class VolunteerCategory extends Validate
{
    protected $rule = [
        'category_name' => 'require|max:50',
        'sort' => 'number|egt:0',
        'is_show' => 'require|number|in:0,1',
    ];

    protected $message = [
        'category_name.require' => 'category_name_require',
        'category_name.max' => 'category_name_max',
        'sort.number' => 'sort_number',
        'is_show.require' => 'is_show_require',
        'is_show.in' => 'is_show_in',
    ];

    protected $scene = [
        'add' => ['category_name', 'sort', 'is_show'],
        'edit' => ['category_name', 'sort', 'is_show'],
    ];
}
