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

namespace app\api\controller\diy;

use app\service\api\diy\DiyService;
use core\base\BaseApiController;
use think\Response;

class Diy extends BaseApiController
{

    /**
     * 自定义页面信息
     * @return Response
     */
    public function info()
    {
        $params = $this->request->params([
            [ 'id', '' ],
            [ 'name', '' ]
        ]);
        return success(( new DiyService() )->getInfo($params));
    }
}
