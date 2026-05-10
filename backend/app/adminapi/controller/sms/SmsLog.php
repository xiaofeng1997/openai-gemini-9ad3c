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

use app\service\admin\sms\SmsLogService;
use core\base\BaseAdminController;
use think\Response;

/**
 * 短信发送记录
 * Class SmsLog
 * @description 短信发送记录
 * @package app\adminapi\controller\sms
 */
class SmsLog extends BaseAdminController
{

    /**
     * 短信发送记录列表
     * @description 短信发送记录列表
     * @return Response
     */
    public function lists()
    {
        $data = $this->request->params([
            ['mobile', ''],
            ['sms_type', ''],
            ['key', ''],
            ['create_time', []],
        ]);

        $res = (new SmsLogService())->getPage($data);
        return success($res);
    }

    /**
     * 短信发送记录详情
     * @description 短信发送记录详情
     * @param $id
     * @return Response
     */
    public function info($id)
    {
        $res = (new SmsLogService())->getInfo($id);
        return success($res);
    }

}
