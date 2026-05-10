<?php
return [
    'bind' => [
    ],
    'listen' => [
        /**
         * 系统事件
         */
        'AppInit' => ['app\listener\system\AppInitListener'],
        'HttpRun' => [],
        'HttpEnd' => [],
        'LogLevel' => [],
        'LogWrite' => [],
        /**
         * 会员相关事件
         */
        //会员注册事件
        'MemberRegister' => ['app\listener\member\MemberRegisterListener'],
        //会员登录事件
        'MemberLogin' => ['app\listener\member\MemberLoginListener'],
        //会员账户变化事件
        'MemberAccount' => ['app\listener\member\MemberAccountListener'],
        //扫码事件
        'Scan' => ['app\listener\scan\ScanListener'],
        /**
         * 支付相关事件
         */
        'PayCreate' => ['app\listener\pay\PayCreateListener'],
        //支付成功
        'PaySuccess' => ['app\listener\pay\PaySuccessListener'],
        //退款成功
        'RefundSuccess' => ['app\listener\pay\RefundSuccessListener'],
        //转账成功
        'TransferSuccess' => ['app\listener\pay\TransferSuccessListener'],
        // 任务失败统一回调,有四种定义方式
        'queue_failed' => [
            ['app\listener\job\QueueFailedLoggerListener', 'report'],
        ],

        //小程序包替换
        'AppletReplace' => [
            'app\listener\applet\WeappListener',//微信小程序
        ],
        //创建二维码
        'GetQrcodeOfChannel' => [
            // 微信公众号二维码
            'app\listener\qrcode\WechatQrcodeListener',
            // 微信小程序二维码
            'app\listener\qrcode\WeappQrcodeListener'
        ],


        // 小程序授权变更事件
        'WeappAuthChangeAfter' => ['app\listener\system\WeappAuthChangeAfter'],
        //获取微信转账场景配置
        'GetWechatTransferTradeScene' => [
            'app\listener\transfer\TransferCashOutListener'
        ],
    ],
    'subscribe' => [
    ],
];
