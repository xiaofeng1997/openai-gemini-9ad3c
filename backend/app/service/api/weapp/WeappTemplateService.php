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

namespace app\service\api\weapp;

use app\model\weapp\WeappNotice;
use app\model\weapp\WeappLog;
use core\base\BaseApiService;

/**
 * 微信小程序模板服务
 * Class WeappTemplateService
 * @package app\service\api\weapp
 */
class WeappTemplateService extends BaseApiService
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * 获取微信小程序订阅消息模板id
     * @param string $keys
     * @return array
     */
    public function getWeappNoticeTemplateId(string $keys) {
        return (new WeappNotice())->where([ ['key', 'in', explode(',', $keys) ], ['weapp_template_id', '<>', ''], ['is_weapp', '=', 1] ])->column('weapp_template_id');
    }

}