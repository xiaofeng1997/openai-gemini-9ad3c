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
 * 短信模块 相关路由
 */
Route::group('sms', function () {

    /***************************************************** 短信管理 ****************************************************/

    //短信配置列表
    Route::get('config', 'sms.Sms/config');
    //短信配置详情
    Route::get('config/:sms_type', 'sms.Sms/configDetail');
    //短信配置修改
    Route::put('config/:sms_type', 'sms.Sms/editConfig');
    //短信通知消息模版管理    阿里云 腾讯云
    Route::get('notice', 'sms.SmsNotice/lists');
    Route::get('notice/:key', 'sms.SmsNotice/info');
    Route::post('notice/edit', 'sms.SmsNotice/edit');
    Route::post('notice/editstatus', 'sms.SmsNotice/editStatus');
    
     //短信发送记录
    Route::get('log', 'sms.SmsLog/lists');
    //短信发送记录详情
    Route::get('log/:id', 'sms.SmsLog/info');
    
    //牛云特殊业务
    Route::group('niusms', function () {
        Route::get('packages', 'sms.NiuSms/getSmsPackageList');
        //发送验证短信
        Route::post('send', 'sms.NiuSms/sendMobileCode');
        Route::get('captcha', 'sms.NiuSms/captcha');

        Route::get('config', 'sms.NiuSms/getConfig');
        Route::put('enable', 'sms.NiuSms/enable');
        Route::group('account', function () {
            Route::post('register', 'sms.NiuSms/registerAccount');
            Route::post('login', 'sms.NiuSms/loginAccount');
            Route::post('edit/:username', 'sms.NiuSms/editAccount');
            Route::post('reset/password/:username', 'sms.NiuSms/resetPassword');
            Route::post('forget/password/:username', 'sms.NiuSms/forgetPassword');
            Route::get('info/:username', 'sms.NiuSms/accountInfo');
        });

        Route::group('order', function () {
            Route::get('list/:username', 'sms.NiuSms/orderList');
            Route::post('calculate/:username', 'sms.NiuSms/calculate');
            Route::post('create/:username', 'sms.NiuSms/createOrder');
            Route::get('info/:username', 'sms.NiuSms/orderInfo');
            Route::get('status/:username', 'sms.NiuSms/orderStatus');
            Route::get('pay/:username', 'sms.NiuSms/getPayInfo');
        });
        Route::group('sign', function () {
            Route::get('list/:username', 'sms.NiuSms/signList');
            Route::get('info/:username', 'sms.NiuSms/signInfo');
            Route::get('report/config', 'sms.NiuSms/signCreateConfig');
            Route::post('report/:username', 'sms.NiuSms/signCreate');
            Route::post('delete/:username', 'sms.NiuSms/signDelete');
        });


    });


    /***************************************************** 短信管理 end ****************************************************/

})->middleware([
    AdminCheckToken::class,
    AdminCheckRole::class,
    AdminLog::class
]);