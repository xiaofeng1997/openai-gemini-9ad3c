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

use app\service\admin\wechat\WechatTemplateService;
use core\base\BaseAdminController;
use think\Response;

/**
 * 微信公众号管理菜单
 */
class Template extends BaseAdminController
{

    /**
     * 模板消息
     * @description 获取模板消息
     * @return Response
     */
    public function lists()
    {
        $wechat_template_service = new WechatTemplateService();
        return success($wechat_template_service->getList());
    }

    /**
     * 设置微信模板
     * @description 设置微信模板
     * @return Response
     */
    public function set()
    {
        $data = $this->request->params([
            [ 'key', '' ],
            [ 'status', 0 ],
            [ 'wechat_template_id', '' ]
        ]);
        $wechat_template_service = new WechatTemplateService();
        return success(data:$wechat_template_service->set($data));
    }

}
