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

use app\model\weapp\WeappLog;
use core\base\BaseCoreService;

/**
 * 微信小程序模板消息发送记录服务层
 * Class CoreWeappLogService
 * @package app\service\core\weapp
 */
class CoreWeappLogService extends BaseCoreService
{
    public function __construct()
    {
        parent::__construct();
        $this->model = new WeappLog();
    }

    /**
     * 获取微信小程序模板消息发送记录列表
     * @param array $where
     * @return array
     */
    public function getPage(array $where = [])
    {
        $field = 'id,receiver,key,content,params,status,result,create_time,send_time,update_time';
        $order = 'create_time desc';
        $search_model = $this->model->where([['id', '>', 0]])->withSearch(['key', 'receiver', 'create_time'], $where)->field($field)->order($order)->append(['name']);
        return $this->pageQuery($search_model);
    }


    /**
     * 获取微信小程序模板消息发送记录信息
     * @param int $id
     * @return array
     */
    public function getInfo(int $id)
    {
        $field = 'id, receiver,key,content,params,status,result,create_time,send_time,update_time';
        return $this->model->field($field)->where([['id', '=', $id]])->append(['name'])->findOrEmpty()->toArray();
    }

    /**
     * 添加微信小程序模板消息发送记录
     * @param array $data
     * @return mixed|null
     */
    public function add(array $data)
    {
        $log = $this->model->create($data);
        return $log?->id;

    }

    /**
     * 微信小程序模板消息发送记录编辑
     * @param int $id
     * @param array $data
     * @return true
     */
    public function edit(int $id, array $data)
    {
        $data['update_time'] = time();
        $this->model->where([['id', '=', $id]])->update($data);
        return true;
    }

    /**
     * 删除微信小程序模板消息发送记录
     * @param int $id
     * @return bool
     */
    public function del(int $id)
    {
        return $this->model->where([['id', '=', $id]])->delete();
    }
}