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

use app\service\core\wechat\CoreWechatTemplateData;
use app\service\core\wechat\CoreWechatTemplateNoticeService;
use core\base\BaseAdminService;

/**
 * easywechat主体提供
 * Class WechatConfigService
 * @package app\service\core\wechat
 */
class WechatTemplateService extends BaseAdminService
{


    /**
     * 获取模板消息
     * @return array
     */
    public function getList()
    {
        $wechat_notice_service = new CoreWechatTemplateNoticeService();
        return $wechat_notice_service->getList();
    }

    /**
     * 设置微信模板
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
            'is_wechat' => $data['status'] ?? 0,
            'wechat_template_id' => $data['wechat_template_id'] ?? ''
        ];
        
        $wechat_notice_service = new CoreWechatTemplateNoticeService();
        return $wechat_notice_service->edit($key, $update_data);
    }

}
