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

namespace app\validate\pointshop;

use think\Validate;

class PointCategory extends Validate
{
    protected $rule = [
        'category_name' => 'require|max:50',
        'parent_id' => 'number|egt:0',
        'sort' => 'number|egt:0',
        'is_show' => 'require|number|in:0,1',
    ];

    protected $message = [
        'category_name.require' => '分类名称不能为空',
        'category_name.max' => '分类名称最多50个字符',
        'parent_id.number' => '上级分类ID必须为数字',
        'parent_id.egt' => '上级分类ID不能小于0',
        'sort.number' => '排序必须为数字',
        'sort.egt' => '排序不能小于0',
        'is_show.require' => '显示状态不能为空',
        'is_show.in' => '显示状态值不正确',
    ];

    protected $scene = [
        'add' => ['category_name', 'sort', 'is_show'],
        'edit' => ['category_name', 'sort', 'is_show'],
    ];
}
