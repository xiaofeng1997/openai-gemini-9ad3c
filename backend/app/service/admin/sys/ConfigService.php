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

namespace app\service\admin\sys;

use app\service\core\channel\CoreH5Service;
use app\service\core\sys\CoreConfigService;
use app\service\core\sys\CoreSysConfigService;
use core\base\BaseAdminService;

/**
 * 配置服务层
 * Class ConfigService
 * @package app\service\core\sys
 */
class ConfigService extends BaseAdminService
{
    //系统配置文件
    public $core_config_service;

    public function __construct()
    {
        parent::__construct();
        $this->core_config_service = new CoreConfigService();
    }

    /**
     * 获取版权信息(网站整体，不按照站点设置)
     * @return array|mixed
     */
    public function getCopyright()
    {
        return ( new CoreSysConfigService() )->getCopyright();
    }

    /**
     * 设置版权信息(整体设置，不按照站点)
     * @param array $value
     * @return bool
     */
    public function setCopyright(array $value)
    {
        $data = [
            'icp' => $value[ 'icp' ],
            'gov_record' => $value[ 'gov_record' ],
            'gov_url' => $value[ 'gov_url' ],
            'market_supervision_url' => $value[ 'market_supervision_url' ],
            'logo' => $value[ 'logo' ],
            'company_name' => $value[ 'company_name' ],
            'copyright_link' => $value[ 'copyright_link' ],
            'copyright_desc' => $value[ 'copyright_desc' ]
        ];
        return $this->core_config_service->setConfig('COPYRIGHT', $data);
    }

    /**
     * 获取网站信息
     * @return array
     */
    public function getWebSite()
    {
        $info = ( new CoreConfigService() )->getConfig('WEB_SITE_INFO');
        $admin_login = (new CoreConfigService())->getConfig('admin_login')['value'] ?? [];
        if (empty($info)) {
            $info = [];
            $info[ 'value' ] = [
                'site_name' => config('install.admin_site_name'),
                'logo' => config('install.admin_logo'),
                'desc' => '',
                'latitude' => '',
                'longitude' => '',
                'province_id' => 0,
                'city_id' => 0,
                'district_id' => 0,
                'address' => '',
                'full_address' => '',
                'phone' => '',
                'business_hours' => '',
                'front_end_name' => '',
                'front_end_logo' => '',
                'front_end_icon' => '',
                'icon' => '',
            ];
        }
        $info[ 'value' ][ 'is_captcha' ] =$admin_login['is_captcha'] ?? 0;
        $info[ 'value' ][ 'login_bg_img' ] = $admin_login['bg'] ?? config('install.admin_login_bg');
        return $info[ 'value' ];

    }

    /**
     * 设置网站信息
     * @return bool
     */
    public function setWebSite($data)
    {
        $web_site = [
            'site_name' => $data[ 'site_name' ],
            'logo' => $data[ 'logo' ],
            'desc' => $data[ 'desc' ],
            'latitude' => $data[ 'latitude' ],
            'longitude' => $data[ 'longitude' ],
            'province_id' => $data[ 'province_id' ],
            'city_id' => $data[ 'city_id' ],
            'district_id' => $data[ 'district_id' ],
            'address' => $data[ 'address' ],
            'full_address' => $data[ 'full_address' ],
            'phone' => $data[ 'phone' ],
            'business_hours' => $data[ 'business_hours' ],
            'front_end_name' => $data[ 'front_end_name' ],
            'front_end_logo' => $data[ 'front_end_logo' ],
            'front_end_icon' => $data[ 'front_end_icon' ],
            'icon' => $data[ 'icon' ],
        ];
        $admin_login = [
            'is_captcha' => $data[ 'is_captcha' ],
            'bg' => $data[ 'login_bg_img' ],
        ];
        (new CoreConfigService())->setConfig('admin_login', $admin_login);
        return $this->core_config_service->setConfig('WEB_SITE_INFO', $web_site);
    }

    /**
     * 获取前端域名
     * @return array|string[]
     */
    public function getSceneDomain()
    {
        return ( new CoreSysConfigService() )->getSceneDomain();
    }

    /**
     * 获取服务信息
     * @return array|mixed
     */
    public function getService()
    {
        $info = ( new CoreConfigService() )->getConfig('SERVICE_INFO')[ 'value' ] ?? [];
        return [
            'wechat_code' => $info[ 'wechat_code' ] ?? '',
            'enterprise_wechat' => $info[ 'enterprise_wechat' ] ?? '',
            'tel' => $info[ 'tel' ] ?? ''
        ];
    }

    /**
     * 设置服务信息
     * @param array $value
     * @return bool
     */
    public function setService(array $value)
    {
        $data = [
            "wechat_code" => $value[ 'wechat_code' ],
            "enterprise_wechat" => $value[ 'enterprise_wechat' ],
            "tel" => $value[ 'tel' ]
        ];

        return $this->core_config_service->setConfig('SERVICE_INFO', $data);
    }

    /**
     * 设置地图key
     * @param array $value
     * @return bool
     */
    public function setMap(array $value)
    {
        $data = [
            'map_type' => $value[ 'map_type' ] ?? 'tencent', // 地图类型
            'key' => $value[ 'key' ],
            'amap_key' => $value['amap_key'] ?? '',
            'tianditu_map_key' => $value[ 'tianditu_map_key' ] ?? '', // 天地图服务端Key
            'tianditu_map_web_key' => $value[ 'tianditu_map_web_key' ] ?? '', // 天地图浏览器端Key
            'is_open' => $value[ 'is_open' ], // 是否开启定位
            'valid_time' => $value[ 'valid_time' ] // 定位有效期/分钟，过期后将重新获取定位信息，0为不过期
        ];
        return $this->core_config_service->setConfig('MAPKEY', $data);
    }

    /**
     * 获取地图key
     */
    public function getMap()
    {
        $info = ( new CoreConfigService() )->getConfig('MAPKEY');
        if (empty($info)) {
            $info = [];
            $info[ 'value' ] = [
                'map_type' => 'tencent', // 地图类型：tencent/腾讯地图, tianditu/天地图
                'key' => '',
                'amap_key' => '',
                'tianditu_map_key' => '', // 天地图服务端Key
                'tianditu_map_web_key' => '', // 天地图浏览器端Key
                'is_open' => 1, // 是否开启定位
                'valid_time' => 5 // 定位有效期/分钟，过期后将重新获取定位信息，0为不过期
            ];
        }

        $info[ 'value' ][ 'map_type' ] = $info[ 'value' ][ 'map_type' ] ?? 'tencent';
        $info[ 'value' ][ 'is_open' ] = $info[ 'value' ][ 'is_open' ] ?? 1;
        $info[ 'value' ][ 'valid_time' ] = $info[ 'value' ][ 'valid_time' ] ?? 5;
        $info[ 'value' ][ 'amap_key' ] = $info[ 'value' ][ 'amap_key' ] ?? '';
        $info[ 'value' ][ 'tianditu_map_key' ] = $info[ 'value' ][ 'tianditu_map_key' ] ?? '';
        $info[ 'value' ][ 'tianditu_map_web_key' ] = $info[ 'value' ][ 'tianditu_map_web_key' ] ?? '';

        return $info[ 'value' ];
    }

    /**
     * 获取手机端首页列表
     * @param $data
     * @return array
     */
    public function getWapIndexList($data = [])
    {
        return ( new CoreSysConfigService() )->getWapIndexList($data);
    }

    /**
     * 获取开发者key
     * @return array
     */
    public function getDeveloperToken()
    {
        return ( new CoreConfigService() )->getConfigValue("DEVELOPER_TOKEN");
    }

    /**
     * 设置开发者key
     * @param array $data
     * @return array
     */
    public function setDeveloperToken(array $data)
    {
        return ( new CoreConfigService() )->setConfig("DEVELOPER_TOKEN", $data);
    }

    /**
     * 获取开发者key
     * @return array
     */
    public function getLayout()
    {
        return ( new CoreConfigService() )->getConfigValue("LAYOUT_SETTING");
    }

    /**
     * 设置布局风格
     * @param array $data
     * @return array
     */
    public function setLayout(array $data)
    {
        $config_service = new CoreConfigService();
        $config = $config_service->getConfigValue( "LAYOUT_SETTING");
        $config[ $data[ 'key' ] ] = $data[ 'value' ];
        return ( new CoreConfigService() )->setConfig( "LAYOUT_SETTING", $config);
    }

    /**
     * 获取色调设置
     * @return array
     */
    public function getThemeColor()
    {
        return ( new CoreConfigService() )->getConfigValue( "THEMECOLOR_SETTING");
    }

    /**
     * 设置色调
     * @param array $data
     * @return array
     */
    public function setThemeColor(array $data)
    {
        $config_service = new CoreConfigService();
        $config = $config_service->getConfigValue("THEMECOLOR_SETTING");
        $config[ $data[ 'key' ] ] = $data[ 'value' ];
        return ( new CoreConfigService() )->setConfig("THEMECOLOR_SETTING", $config);
    }


}
