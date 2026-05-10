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

use app\model\sys\SysSmsNotice;
use app\service\core\sms\CoreSmsNoticeService;
use app\service\core\sms\CoreSmsTemplateData;
use core\base\BaseAdminService;
use core\exception\AdminException;

/**
 * 短信通知管理服务层
 */
class SmsNoticeService extends BaseAdminService
{
    public function __construct()
    {
        parent::__construct();
        $this->model = new SysSmsNotice();
    }

    /**
     * 获取短信通知列表
     * @return array
     */
    public function getList()
    {
        return (new CoreSmsNoticeService())->getList();
    }

    /**
     * 获取短信通知详情
     * @param string $key
     * @return array
     */
    public function getInfo(string $key)
    {
        return (new CoreSmsNoticeService())->getInfo($key);
    }

    /**
     * 修改短信通知状态
     * @param string $key
     * @param int $status
     */
    public function editStatus(string $key, int $status)
    {
        return (new CoreSmsNoticeService())->edit($key, ['is_sms' => $status]);
    }

    /**
     * 短信通知编辑
     * @param string $key
     * @param array $data
     */
    public function edit(string $key, array $data)
    {
        $save_data = ['is_sms' => $data['status']];
        $save_data['sms_id'] = $data['sms_id'] ?? '';
        $save_data['sms_content'] = $data['sms_content'] ?? '';
        // 从 CoreSmsTemplateData 获取 param_json 的值
        $templates = CoreSmsTemplateData::getSmsTemplates();
        if (isset($templates[$key]['param_json'])) {
            $save_data['param_json'] = $templates[$key]['param_json'];
            // 如果 param_json 是数组，转换为 JSON 字符串
            if (is_array($save_data['param_json'])) {
                $save_data['param_json'] = json_encode($save_data['param_json'], JSON_UNESCAPED_UNICODE);
            }
        }
        return (new CoreSmsNoticeService())->edit($key, $save_data);
    }

}