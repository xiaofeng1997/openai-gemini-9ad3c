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

use app\api\middleware\ApiChannel;
use app\api\middleware\ApiCheckToken;
use app\api\middleware\ApiLog;
use think\facade\Route;

//公众号消息推送
Route::any('wechat/serve', 'wechat.Serve/serve')
    ->middleware(ApiChannel::class)
    ->middleware(ApiCheckToken::class)
    ->middleware(ApiLog::class);

// 微信小程序消息推送
Route::any('weapp/serve', 'weapp.Serve/serve')
    ->middleware(ApiChannel::class)
    ->middleware(ApiCheckToken::class)
    ->middleware(ApiLog::class);


/**
 * 路由
 */
Route::group(function () {
    /***************************************************** 版权相关设置**************************************************/
    Route::get('copyright', 'sys.Config/getCopyright');
    // 站点信息
    Route::get('site', 'sys.Config/site');
    //场景域名
    Route::get('scene_domain', 'sys.Config/getSceneDomain');

    // 获取地图设置
    Route::get('map', 'sys.Config/getMap');

    // 获取初始化数据信息
    Route::get('init', 'sys.Config/init');

    /***************************************************** 地区管理 ****************************************************/
    //通过pid获取列表
    Route::get('area/list_by_pid/:pid', 'sys.Area/listByPid');
    //通过层级获取列表
    Route::get('area/tree/:level', 'sys.Area/tree');
    // 获取省市县数据根据地址id
    Route::get('area/code/:code', 'sys.Area/areaByAreaCode');

    // 通过经纬度查询地址
    Route::get('area/address_by_latlng', 'sys.Area/getAddressByLatlng');
    /***************************************************** 任务管理 ****************************************************/
    // 获取成长值任务
    Route::get('task/growth', 'sys.Task/growth');
    // 获取积分任务
    Route::get('task/point', 'sys.Task/point');
    
    Route::get('diy/tabbar', 'diy.DiyConfig/tabbar');

    Route::get('diy/share', 'diy.DiyConfig/share');
   })->middleware(ApiChannel::class)
    ->middleware(ApiCheckToken::class)
    ->middleware(ApiLog::class);
