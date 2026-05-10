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

namespace app\adminapi\controller\wechat;

use app\service\admin\wechat\WechatLogService;
use core\base\BaseAdminController;
use think\Response;

/**
 * 微信模板消息记录
 * Class WechatLog
 * @description 微信模板消息记录
 * @package app\adminapi\controller\wechat
 */
class WechatLog extends BaseAdminController
{

    /**
     * 微信模板消息记录列表
     * @description 微信模板消息记录列表
     * @return Response
     */
    public function lists()
    {
        $data = $this->request->params([
            [ 'receiver', '' ],
            [ 'key', '' ],
            [ 'create_time', [] ],
        ]);

        $res = (new WechatLogService())->getPage($data);
        return success($res);
    }

    /**
     * 微信模板消息记录详情
     * @description 微信模板消息记录详情
     * @param $id
     * @return Response
     */
    public function info($id)
    {
        $res = (new WechatLogService())->getInfo($id);
        return success($res);
    }

}
