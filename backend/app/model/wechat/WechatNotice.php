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

namespace app\model\wechat;

use core\base\BaseModel;

/**
 * 微信公众号通知配置模型
 */
class WechatNotice extends BaseModel
{
    protected $pk = 'id';

    protected $name = 'wechat_notice';

    protected $type = [
        'is_wechat' => 'integer',
        'create_time' => 'integer',
    ];

}
