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

namespace app\model\sys;

use core\base\BaseModel;

/**
 * 短信通知配置模型
 */
class SysSmsNotice extends BaseModel
{

    protected $pk = 'id';

    protected $name = 'sys_sms_notice';

    protected $type = [
        'is_sms' => 'integer',
        'sms_id' => 'string',
        'create_time' => 'integer',
    ];
}
