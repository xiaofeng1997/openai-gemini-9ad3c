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

namespace app\adminapi\controller\sms;

use app\service\admin\sms\SmsService;
use core\base\BaseAdminController;
use think\Response;

/**
 * 短信配置控制器
 */
class Sms extends BaseAdminController
{

    /**
     * 获取短信配置列表
     * @return Response
     */
    public function config()
    {
        $data = (new SmsService())->getList();
        return success($data);
    }

    /**
     * 获取短信配置详情
     * @param string $sms_type
     * @return Response
     */
    public function configDetail(string $sms_type)
    {
        $data = (new SmsService())->getConfig($sms_type);
        return success($data);
    }

    /**
     * 短信配置修改
     * @param string $sms_type
     * @return Response
     */
    public function editConfig(string $sms_type)
    {
        $data = $this->request->only(['is_use', 'params'], 'post');
        (new SmsService())->setConfig($sms_type, $data);
        return success('SUCCESS');
    }

}
