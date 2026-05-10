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

namespace app\service\admin\diy;

use app\dict\diy\LinkDict;
use app\model\diy\Diy;
use app\model\sys\SysConfig;
use app\service\core\diy\CoreDiyConfigService;
use core\base\BaseAdminService;
use think\Model;

/**
 * 自定义页面相关配置服务层
 * Class DiyConfigService
 * @package app\service\admin\diy
 */
class DiyConfigService extends BaseAdminService
{

    /**
     * 获取底部导航配置
     * @param $key
     * @return array
     */
    public function getBottomConfig($key = 'app')
    {
        return ( new CoreDiyConfigService() )->getBottomConfig($key);
    }

    /**
     * 底部导航配置
     * @param $data
     * @param $key
     * @return SysConfig|bool|Model
     */
    public function setBottomConfig($data, $key = 'app')
    {
        return ( new CoreDiyConfigService() )->setBottomConfig($data, $key);
    }

    /**
     * 设置启动页
     * @param $data
     * @return SysConfig|bool|Model
     */
    public function setStartUpPageConfig($data)
    {
        return ( new CoreDiyConfigService() )->setStartUpPageConfig($data);
    }

    /**
     * 获取启动页配置
     * @param $name
     * @return array
     */
    public function getStartUpPageConfig($name)
    {
        return ( new CoreDiyConfigService() )->getStartUpPageConfig($name);
    }

    
    /**
     * 获取自定义链接
     * @return array
     * @throws DataNotFoundException
     * @throws DbException
     * @throws ModelNotFoundException
     */
    public function getLink()
    {
        $link = LinkDict::getLink();
        foreach ($link as $k => $v) {
            $link[ $k ][ 'name' ] = $k;
            if (!empty($v[ 'child_list' ])) {
                foreach ($v[ 'child_list' ] as $ck => $cv) {
                    $link[ $k ][ 'child_list' ][ $ck ][ 'parent' ] = $k;
                }
            }

            if ($k == 'DIY_LINK') {
                $link[ $k ][ 'parent' ] = 'DIY_LINK';
            }

        }
        return $link;
    }

}
