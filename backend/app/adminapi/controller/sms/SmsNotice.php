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

use app\service\admin\sms\SmsNoticeService;
use core\base\BaseAdminController;
use think\Response;

/**
 * 短信通知管理
 * Class SmsNotice
 * @description 短信通知管理
 * @package app\adminapi\controller\sms
 */
class SmsNotice extends BaseAdminController
{

    /**
     * 短信通知列表
     * @description 短信通知列表
     * @return Response
     */
    public function lists()
    {

        $res = (new SmsNoticeService())->getList();
        return success($res);
    }

    /**
     * 短信通知详情
     * @description 短信通知详情
     * @param $key
     * @return Response
     */
    public function info($key)
    {
        $res = (new SmsNoticeService())->getInfo($key);
        return success($res);
    }

    /**
     * 短信通知编辑
     * @description 短信通知编辑
     * @return Response
     */
    public function edit()
    {
        $data = $this->request->params([
            ['key', ''],
            ['status', 0],
            ['sms_id', ''],
            ['sms_content', ''],
        ]);
        (new SmsNoticeService())->edit($data['key'], $data);
        return success();
    }

    /**
     * 短信通知状态修改
     * @description 短信通知状态修改
     * @return Response
     */
    public function editStatus()
    {
        $data = $this->request->params([
            ['key', ''],
            ['status', 0],
        ]);
        (new SmsNoticeService())->editStatus($data['key'], $data['status']);
        return success();
    }

}