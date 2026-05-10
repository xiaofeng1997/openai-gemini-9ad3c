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

namespace app\dict\schedule;

class ScheduleDict
{

    public const CRON = 'cron';//定时任务
    public const CROND = 'crond';//周期任务

    public const ON = 1;
    public const OFF = 2;
    public const MIN = 'min';
    public const HOUR = 'hour';
    public const DAY = 'day';//每隔几分钟
    public const WEEK = 'week';//每隔几小时
    public const MONTH = 'month';//每隔几天

    /**
     * 任务模式
     * @return array
     */
    public static function getType()
    {
        return [
            self::CRON => get_lang('dict_schedule.type_cron'),//定时任务
            self::CROND => get_lang('dict_schedule.type_crond'),//周期任务
        ];
    }//每周

    /**
     * 任务启用状态
     * @return array
     */
    public static function getStatus()
    {
        return [
            self::ON => get_lang('dict_schedule.on'),//启用
            self::OFF => get_lang('dict_schedule.off'),//关闭
        ];
    }//每月

    public static function getDateType()
    {
        return [
            self::MIN => get_lang('dict_schedule.min'),
            self::HOUR => get_lang('dict_schedule.hour'),
            self::DAY => get_lang('dict_schedule.day'),
            self::WEEK => get_lang('dict_schedule.week'),
            self::MONTH => get_lang('dict_schedule.month'),
        ];
    }

    public  static function getTemplateList()
    {
        return [
            [
                'key' => 'auto_clear_schedule_log',
                'name' => '定时清理计划任务日志表',
                'desc' => '',
                'time' => [
                    'type' => 'day',
                    'day' => 1,
                    'hour' => 1,
                    'min' => 1
                ],
                'class' => 'app\job\schedule\AutoClearScheduleLog',
                'function' => ''
            ],    [
                'key' => 'auto_clear_poster_qrcode',
                'name' => '定时清理海报及二维码数据',
                'desc' => '',
                'time' => [
                    'type' => 'day',
                    'day' => 1,
                    'hour' => 1,
                    'min' => 1
                ],
                'class' => 'app\job\schedule\AutoClearPosterAndQrcode',
                'function' => ''
            ],
            [
                'key' => 'transfer_check_finish',
                'name' => '检验在线转账是否处理完毕',
                'desc' => '',
                'time' => [
                    'type' => 'min',
                    'min' => 5
                ],
                'class' => 'app\job\transfer\schedule\CheckFinish',
                'function' => ''
            ],
            [
                'key' => 'auto_clear_upgrade_records',
                'name' => '定时清理升级/备份记录表',
                'desc' => '',
                'time' => [
                    'type' => 'day',
                    'day' => 1,
                    'hour' => 1,
                    'min' => 1
                ],
                'class' => 'app\job\upgrade\AutoClearUpgradeRecords',
                'function' => ''
            ],[
                'key' => 'auto_clear_user_log',
                'name' => '定时清理用户操作日志',
                'desc' => '',
                'time' => [
                    'type' => 'day',
                    'day' => 1,
                    'hour' => 1,
                    'min' => 1
                ],
                'class' => 'app\job\sys\ClearUserLog',
                'function' => ''
            ]
        ];
    }
}