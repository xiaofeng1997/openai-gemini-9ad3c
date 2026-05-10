<?php
// +----------------------------------------------------------------------
// | 控制台配置
// +----------------------------------------------------------------------
return [
    // 指令定义
    'commands' => [
        //消息队列 自定义命令
        'queue:work' => 'app\command\queue\Queue',
        'queue:restart' => 'app\command\queue\Queue',
        'queue:listen' => 'app\command\queue\Queue',
        //计划任务 自定义命令
        'cron:schedule' => 'app\command\schedule\Schedule',
        //wokrerman的启动停止和重启
        'workerman' => 'app\command\workerman\Workerman',
        //重置管理员密码
        'refresh:area' => 'app\command\refreshAreaCommand',
    ],
];
