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

namespace app\service\admin\sms;

use app\model\sys\SysSmsLog;
use app\service\core\sms\CoreSmsLogService;
use core\base\BaseAdminService;

/**
 * 短信消息管理服务层
 */
class SmsLogService extends BaseAdminService
{
    public function __construct()
    {
        parent::__construct();
        $this->model = new SysSmsLog();
    }

    /**
     * 获取当前站点消息
     * @return array
     */
    public function getPage($where)
    {
        return (new CoreSmsLogService())->getPage($where);
    }

    /**
     * 获取消息内容
     * @param int $id
     * @return array
     */
    public function getInfo(int $id)
    {
        return (new CoreSmsLogService())->getInfo($id);
    }
}
