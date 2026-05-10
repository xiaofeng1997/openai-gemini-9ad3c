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

namespace app\service\api\diy;

use app\model\diy\DiyTheme;
use app\service\core\addon\CoreAddonService;
use app\service\core\diy\CoreDiyConfigService;
use core\base\BaseApiService;

/**
 * 自定义页面相关配置服务层
 * Class DiyConfigService
 * @package app\service\admin\diy
 */
class DiyConfigService extends BaseApiService
{


    /**
     * 获取底部导航配置
     * @return array
     */
    public function getBottomConfig()
    {
        return ( new CoreDiyConfigService() )->getBottomConfig();
    }

    /**
     * 获取启动页配置
     * @return array
     */
    public function getStartUpPageConfig($type)
    {
        return ( new CoreDiyConfigService() )->getStartUpPageConfig($type);
    }

        /**
     * 获取主题配置
     * @return array
     */
    public function getDiyTheme()
    {
        // 查询当前选中的主题
        $theme_data = (new DiyTheme())->where([['is_selected', '=', 1]])->field('title,theme')->findOrEmpty()->toArray();
        
        if (empty($theme_data)) {
            // 如果没有选中主题，返回默认主题
            return [
                'title' => '默认绿色',
                'theme' => [
                    '--primary-color' => '#00c905',
                    '--primary-light-color' => '#9cff57',
                    '--secondary-color' => '#f5f5f5',
                    '--secondary-light-color' => '#ffffff',
                    '--secondary-dark-color' => '#e6e6e6',
                    '--primary-text-color' => '#3c3c3c',
                    '--secondary-text-color' => '#555555'
                ]
            ];
        }
        
        return $theme_data;
    }

}
