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

namespace app\service\core\sms;

use app\model\sys\SysSmsNotice;
use core\base\BaseCoreService;
use app\service\core\sms\CoreSmsTemplateData;

/**
 * 核心短信通知服务层
 */
class CoreSmsNoticeService extends BaseCoreService
{
    public function __construct()
    {
        parent::__construct();
        $this->model = new SysSmsNotice();
    }

    /**
     * 获取短信通知配置
     * @param string $key
     * @return array
     */
    private function getNotice(string $key = '')
    {
        $notice = CoreSmsTemplateData::getSmsTemplates();
        if (!empty($key)) {
            return $notice[$key] ?? [];
        }
        return $notice;
    }

    /**
     * 获取短信通知列表
     * @return array
     */
    public function getList()
    {
        $list = $this->model->select()->toArray();
        if (!empty($list)) {
            $list_key = array_column($list, 'key');
            $list = array_combine($list_key, $list);
        }
        $notice = $this->getNotice();
        $result = [];
        foreach ($notice as $k => $v) {
            if (array_key_exists($k, $list)) {
                $result[] = array_merge($v, $list[$k]);
            } else {
                $data = [
                    'is_sms' => 0,
                    'sms_content' => '',
                    'sms_id' => '',
                    'param_json' => ''
                ];
                $result[] = array_merge($v, $data);
            }
        }
        return $result;
    }

    /**
     * 获取短信通知详情
     * @param string $key
     * @return array
     */
    public function getInfo(string $key)
    {
        $info = $this->model->where([['key', '=', $key]])->find();
        if (empty($info)) {
            $data = [
                'is_sms' => 0,
                'sms_content' => '',
                'sms_id' => '',
                'param_json' => ''
            ];
            return array_merge($this->getNotice($key), $data);
        }
        return array_merge($this->getNotice($key), $info->toArray());
    }

    /**
     * 编辑短信通知
     * @param string $key
     * @param array $data
     * @return bool
     */
    public function edit(string $key, array $data)
    {
        // 如果 param_json 是数组，转换为 JSON 字符串
        if (isset($data['param_json']) && is_array($data['param_json'])) {
            $data['param_json'] = json_encode($data['param_json'], JSON_UNESCAPED_UNICODE);
        }
        $info = $this->model->where([['key', '=', $key]])->find();
        if (empty($info)) {
            $data['key'] = $key;
            $data['create_time'] = time();
            $this->model->create($data);
        } else {
            $this->model->where([['key', '=', $key]])->update($data);
        }
        return true;
    }

    /**
     * 根据key获取短信通知配置
     * @param string $key
     * @return array
     */
    public function find(string $key)
    {
        return $this->getInfo($key);
    }

}