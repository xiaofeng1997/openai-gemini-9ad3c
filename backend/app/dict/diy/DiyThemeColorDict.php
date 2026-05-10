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
 * 基础组件
 * Class ComponentDict
 * @package app\dict\diy
 */
class DiyThemeColorDict
{

    public static function getThemeColor()
    {
        return [
            '--page-bg-color' => [
                'title' => '页面背景色',
                'default' => '#F6F6F6'
            ],
            '--primary-color' => [
                'title' => '主色调',
                'default' => 'rgba(51, 51, 51, 1)'
            ],
            '--primary-color-light' => [
                'title' => '主色调浅色（淡）',
                'default' => 'rgba(51, 51, 51, 0.1)'
            ],
            '--primary-color-light2' => [
                'title' => '主色调深色（深）',
                'default' => 'rgba(51, 51, 51, 0.8)'
            ],
            '--primary-help-color2' => [
                'title' => '辅色调',
                'default' => 'rgba(51, 51, 51, 1)'
            ],
            '--primary-color-dark' => [
                'title' => '灰色调',
                'default' => '#999999'
            ],
            '--primary-color-disabled' => [
                'title' => '禁用色',
                'default' => '#CCCCCC'
            ]
        ];
    }
}
