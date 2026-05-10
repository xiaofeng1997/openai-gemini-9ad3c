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


/**
 * 文件上传
 */
Route::group('file', function() {
    //上传图片
    Route::post('image', 'upload.Upload/image');
    //上传视频
    Route::post('video', 'upload.Upload/video');
    //拉取图片
    Route::post('image/fetch', 'upload.Upload/imageFetch');
    //base64图片
    Route::post('image/base64', 'upload.Upload/imageBase64');

})->middleware(ApiChannel::class)
    ->middleware(ApiCheckToken::class, false)
    ->middleware(ApiLog::class);
