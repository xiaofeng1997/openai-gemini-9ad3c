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

namespace app\adminapi\controller\diy;

use app\service\admin\diy\DiyConfigService;
use core\base\BaseAdminController;
use think\Response;


/**
 * 自定义配置相关
 * Class Config
 * @description 自定义配置
 * @package app\adminapi\controller\diy
 */
class Config extends BaseAdminController
{

    /**
     * 获取底部导航
     * @description 获取底部导航
     * @return Response
     */
    public function getBottomConfig()
    {
        return success(( new DiyConfigService() )->getBottomConfig());
    }

    /**
     * 设置底部导航
     * @description 设置底部导航
     * @return Response
     */
    public function setBottomConfig()
    {
        $data = $this->request->params([
            [ 'value', [] ]
        ]);
        ( new DiyConfigService() )->setBottomConfig($data[ 'value' ]);
        return success();
    }

        /**
     * 获取自定义链接列表
     * @description 获取自定义链接列表
     */
    public function getLink()
    {
        $diy_service = new DiyConfigService();
        return success($diy_service->getLink());
    }


}
