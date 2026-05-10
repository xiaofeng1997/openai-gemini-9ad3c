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

namespace app\service\core\weapp;

use app\model\weapp\WeappNotice;
use core\base\BaseCoreService;
use app\service\core\weapp\CoreWeappTemplateData;

/**
 * 核心微信小程序模板通知服务层
 */
class CoreWeappTemplateNoticeService extends BaseCoreService
{
    public function __construct()
    {
        parent::__construct();
        $this->model = new WeappNotice();
    }

    /**
     * 获取微信小程序通知列表
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
                    'is_weapp' => 0,
                    'weapp_template_id' => ''
                ];
                $result[] = array_merge($v, $data);
            }
        }
        return $result;
    }

    /**
     * 获取微信小程序通知详情
     * @param string $key
     * @return array
     */
    public function getInfo(string $key)
    {
        $info = $this->model->where([['key', '=', $key]])->find();
        if (empty($info)) {
            $data = [
                'is_weapp' => 0,
                'weapp_template_id' => ''
            ];
            return array_merge($this->getNotice($key), $data);
        }
        return array_merge($this->getNotice($key), $info->toArray());
    }

    /**
     * 编辑微信小程序通知
     * @param string $key
     * @param array $data
     * @return bool
     */
    public function edit(string $key, array $data)
    {
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
     * 获取微信小程序通知模板
     * @param string $key
     * @return array
     */
    private function getNotice(string $key = '')
    {
        $notice = CoreWeappTemplateData::getWeappTemplates();
        if (!empty($key)) {
            return $notice[$key] ?? [];
        }
        return $notice;
    }

    /**
     * 根据key获取微信小程序通知配置
     * @param string $key
     * @return array
     */
    public function find(string $key)
    {
        return $this->getInfo($key);
    }

}