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

namespace app\service\admin\wechat;

use app\service\core\wechat\CoreWechatLogService;
use core\base\BaseAdminService;

/**
 * 微信模板消息记录服务
 */
class WechatLogService extends BaseAdminService
{
    /**
     * 微信模板消息记录核心服务
     * @var CoreWechatLogService
     */
    protected $coreWechatLogService;

    /**
     * 构造函数
     */
    public function __construct()
    {
        parent::__construct();
        $this->coreWechatLogService = new CoreWechatLogService();
    }

    /**
     * 获取微信模板消息记录列表
     * @param array $where
     * @return array
     */
    public function getPage(array $where = [])
    {
        return $this->coreWechatLogService->getPage($where);
    }

    /**
     * 获取微信模板消息记录详情
     * @param int $id
     * @return array
     */
    public function getInfo(int $id)
    {
        return $this->coreWechatLogService->getInfo($id);
    }
}
