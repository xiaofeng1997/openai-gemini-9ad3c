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
 * 测试路由 - 短信发送示例
 * 这些路由用于帮助客户快速熟悉短信发送功能
 */
Route::group('demo', function () {
    // 发送业务通知短信
    Route::post('sms/business', 'demo.Sms/sendBusinessNotice');
    // 发送验证码短信
    Route::post('sms/memberverify', 'demo.Sms/sendMemberVerifyCode');
    
    // 微信消息推送测试
    Route::post('wechat/shop-order-pay', 'demo.Wechat/sendShopOrderPay');
    
    // 微信小程序消息推送测试
    Route::post('weapp/shop-order-pay', 'demo.Weapp/sendShopOrderPay');
    
})->middleware(ApiChannel::class)
    ->middleware(ApiCheckToken::class)
    ->middleware(ApiLog::class);
