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

use app\adminapi\middleware\AdminCheckRole;
use app\adminapi\middleware\AdminCheckToken;
use app\adminapi\middleware\AdminLog;
use think\facade\Route;


/**
 * 自定义页面控制器
 */
Route::group('diy', function() {


    /***************************************************** 自定义主题配色管理 ****************************************************/

    // 获取主题列表
    Route::get('theme', 'diy.DiyTheme/getDiyTheme');

    // 添加主题
    Route::post('theme/add', 'diy.DiyTheme/addDiyTheme');

    // 编辑主题
    Route::put('theme/edit/:id', 'diy.DiyTheme/editDiyTheme');

    // 删除主题
    Route::delete('theme/delete/:id', 'diy.DiyTheme/delDiyTheme');

    // 设置主题
    Route::put('theme/use/:id', 'diy.DiyTheme/setDiyTheme');

    // 获取主题色字典
    Route::get('theme/color/dict', 'diy.DiyTheme/getThemeColorDict');

    /***************************************************** 配置相关 *****************************************************/

    // 底部导航配置
    Route::get('bottom/config', 'diy.Config/getBottomConfig');
    // 底部导航配置
    Route::get('bottom', 'diy.Config/getBottomConfig');

    // 设置底部导航
    Route::post('bottom', 'diy.Config/setBottomConfig');
    
    // 获取自定义链接列表
    Route::get('link', 'diy.Config/getLink');



})->middleware([
    AdminCheckToken::class,
    AdminCheckRole::class,
    AdminLog::class
]);
