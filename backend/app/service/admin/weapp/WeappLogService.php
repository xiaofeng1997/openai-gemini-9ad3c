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

namespace app\service\admin\weapp;

use app\service\core\weapp\CoreWeappLogService;
use core\base\BaseAdminService;

/**
 * 微信小程序模板消息记录服务
 */
class WeappLogService extends BaseAdminService
{
    /**
     * 微信小程序模板消息记录核心服务
     * @var CoreWeappLogService
     */
    protected $coreWeappLogService;

    /**
     * 构造函数
     */
    public function __construct()
    {
        parent::__construct();
        $this->coreWeappLogService = new CoreWeappLogService();
    }

    /**
     * 获取微信小程序模板消息记录列表
     * @param array $where
     * @return array
     */
    public function getPage(array $where = [])
    {
        return $this->coreWeappLogService->getPage($where);
    }

    /**
     * 获取微信小程序模板消息记录详情
     * @param int $id
     * @return array
     */
    public function getInfo(int $id)
    {
        return $this->coreWeappLogService->getInfo($id);
    }
}