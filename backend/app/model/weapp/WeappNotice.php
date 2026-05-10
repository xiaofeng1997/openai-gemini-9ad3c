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

namespace app\model\weapp;

use core\base\BaseModel;

/**
 * 微信小程序通知配置模型
 */
class WeappNotice extends BaseModel
{

   protected $pk = 'id';

    protected $name = 'weapp_notice';

    protected $type = [
        'is_weapp' => 'integer',
        'create_time' => 'integer',
    ];

}
