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

use app\service\core\weapp\CoreWeappTemplateNoticeService;
use core\base\BaseAdminService;

/**
 * easywechat主体提供
 * Class WeappTemplateService
 * @package app\service\core\weapp
 */
class WeappTemplateService extends BaseAdminService
{

    /**
     * 获取订阅消息
     * @return array
     */
    public function getList()
    {
        return (new CoreWeappTemplateNoticeService())->getList();
    }

    /**
     * 设置微信小程序模板
     * @param array $data
     * @return true
     */
    public function set(array $data)
    {
        $key = $data['key'] ?? '';
        if (empty($key)) {
            return false;
        }
        
        $update_data = [
            'is_weapp' => $data['status'] ?? 0,
            'weapp_template_id' => $data['weapp_template_id'] ?? ''
        ];
        
        $weapp_notice_service = new CoreWeappTemplateNoticeService();
        return $weapp_notice_service->edit($key, $update_data);
    }

}
