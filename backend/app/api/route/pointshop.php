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

Route::group('pointshop', function () {
    Route::get('index', 'pointshop.Pointshop/index');
    Route::get('goods/list', 'pointshop.Pointshop/goodsList');
    Route::get('goods/detail/:goods_id', 'pointshop.Pointshop/goodsDetail');
    Route::post('exchange', 'pointshop.Pointshop/exchange');
    Route::get('order/list', 'pointshop.Pointshop/orderList');
    Route::get('order/detail/:order_id', 'pointshop.Pointshop/orderDetail');
    Route::put('order/cancel/:order_id', 'pointshop.Pointshop/cancelOrder');
    Route::put('order/confirm/:order_id', 'pointshop.Pointshop/confirmReceive');
})->middleware(\app\http\middleware\ApiAuthMiddleware::class);
