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

use think\facade\Route;

Route::group('volunteer', function () {
    Route::get('category/lists', 'volunteer.VolunteerCategory/lists');
    Route::get('category/info/:category_id', 'volunteer.VolunteerCategory/info');
    Route::post('category/add', 'volunteer.VolunteerCategory/add');
    Route::put('category/edit/:category_id', 'volunteer.VolunteerCategory/edit');
    Route::delete('category/del/:category_id', 'volunteer.VolunteerCategory/del');

    Route::get('service/lists', 'volunteer.VolunteerService/lists');
    Route::get('service/info/:service_id', 'volunteer.VolunteerService/info');
    Route::post('service/add', 'volunteer.VolunteerService/add');
    Route::put('service/edit/:service_id', 'volunteer.VolunteerService/edit');
    Route::delete('service/del/:service_id', 'volunteer.VolunteerService/del');
    Route::post('service/audit', 'volunteer.VolunteerService/audit');
    Route::put('service/setStatus', 'volunteer.VolunteerService/setStatus');

    Route::get('apply/lists', 'volunteer.VolunteerApply/lists');
    Route::get('apply/info/:volunteer_id', 'volunteer.VolunteerApply/info');
    Route::post('apply/audit', 'volunteer.VolunteerApply/audit');

    Route::get('order/lists', 'volunteer.VolunteerOrder/lists');
    Route::get('order/info/:order_id', 'volunteer.VolunteerOrder/info');
    Route::post('order/updateStatus', 'volunteer.VolunteerOrder/updateStatus');
    Route::get('order/getStatusList', 'volunteer.VolunteerOrder/getStatusList');
})->middleware(\app\http\middleware\AdminAuthMiddleware::class);
