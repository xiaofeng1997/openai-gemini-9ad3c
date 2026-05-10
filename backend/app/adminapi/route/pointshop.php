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
    Route::get('goods/lists', 'pointshop.PointGoods/lists');
    Route::get('goods/info/:goods_id', 'pointshop.PointGoods/info');
    Route::post('goods/add', 'pointshop.PointGoods/add');
    Route::put('goods/edit/:goods_id', 'pointshop.PointGoods/edit');
    Route::delete('goods/del/:goods_id', 'pointshop.PointGoods/del');
    Route::put('goods/setStatus', 'pointshop.PointGoods/setStatus');
    Route::get('goods/getCategory', 'pointshop.PointGoods/getCategory');

    Route::get('category/lists', 'pointshop.PointCategory/lists');
    Route::get('category/info/:category_id', 'pointshop.PointCategory/info');
    Route::post('category/add', 'pointshop.PointCategory/add');
    Route::put('category/edit/:category_id', 'pointshop.PointCategory/edit');
    Route::delete('category/del/:category_id', 'pointshop.PointCategory/del');

    Route::get('order/lists', 'pointshop.PointOrder/lists');
    Route::get('order/info/:order_id', 'pointshop.PointOrder/info');
    Route::post('order/deliver', 'pointshop.PointOrder/deliver');
    Route::get('order/getStatusList', 'pointshop.PointOrder/getStatusList');
})->middleware(\app\http\middleware\AdminAuthMiddleware::class);
