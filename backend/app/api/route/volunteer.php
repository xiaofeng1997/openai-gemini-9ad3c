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
    Route::get('index', 'volunteer.Volunteer/index');
    Route::get('category', 'volunteer.Volunteer/category');

    Route::get('service/lists', 'volunteer.Volunteer/serviceLists');
    Route::get('service/detail/:service_id', 'volunteer.Volunteer/serviceDetail');
    Route::get('volunteer/profile/:volunteer_id', 'volunteer.Volunteer/volunteerProfile');

    Route::post('apply', 'volunteer.Volunteer/apply');
    Route::get('myVolunteer', 'volunteer.Volunteer/myVolunteer');
    Route::get('isVolunteer', 'volunteer.Volunteer/isVolunteer');

    Route::post('publishService', 'volunteer.Volunteer/publishService');
    Route::get('myService', 'volunteer.Volunteer/myService');
    Route::put('editService/:service_id', 'volunteer.Volunteer/editService');

    Route::post('createOrder', 'volunteer.Volunteer/createOrder');
    Route::get('order/lists', 'volunteer.Volunteer/orderLists');
    Route::get('myServe/order/lists', 'volunteer.Volunteer/myServeOrderLists');
    Route::get('order/detail/:order_id', 'volunteer.Volunteer/orderDetail');
    Route::put('cancelOrder/:order_id', 'volunteer.Volunteer/cancelOrder');
    Route::post('confirmOrder', 'volunteer.Volunteer/confirmOrder');
    Route::put('startService/:order_id', 'volunteer.Volunteer/startService');
    Route::put('finishService/:order_id', 'volunteer.Volunteer/finishService');

    Route::post('createEvaluation', 'volunteer.Volunteer/createEvaluation');
    Route::post('replyEvaluation', 'volunteer.Volunteer/replyEvaluation');
})->middleware(\app\http\middleware\ApiAuthMiddleware::class);
