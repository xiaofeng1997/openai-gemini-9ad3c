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
return [
    //系统常用
    'SUCCESS' => '操作成功',
    'EDIT_SUCCESS' => '编辑成功',
    'DELETE_SUCCESS' => '删除成功',
    'MODIFY_SUCCESS' => '更新成功',
    'VERIFY_SUCCESS' => '核销成功',
    'FAIL' => '操作失败',
    'SAVE_FAIL' => '保存失败',
    'EDIT_FAIL' => '修改失败',
    'DELETE_FAIL' => '删除失败',
    'MODIFY_FAIL' => '更新失败',
    'ADD_FAIL' => '添加失败',
    'ADD_SUCCESS' => '添加成功',
    'UPLOAD_FAIL' => '上传失败',
    'RELEASE_SUCCESS' => '发布成功',
    'ATTACHMENT_DELETE_FAIL' => '附件删除失败',
    'DATA_NOT_EXIST' => '数据不存在',
    'DOWNLOAD_FAIL' => '下载失败',
    'SET_SUCCESS' => '设置成功',
    'AGREEMENT_TYPE_NOT_EXIST' => '协议类型不存在',
    'FIELD_NOT_FOUND' => '找不到要修改的字段',
    'REFRESH_SUCCESS' => '刷新成功',
    'CAPTCHA_ERROR' => '验证码有误',
    'ADDON_INSTALL_SUCCESS' => '插件安装成功',
    'ADDON_UNINSTALL_SUCCESS' => '插件卸载成功',
    'DATA_GET_FAIL' => '数据获取失败',
    'SERVER_CROSS_REQUEST_FAIL' => '服务器跨域请求异常',
    'ADDON_INSTALL_NOT_EXIST' => '未找到插件安装任务',
    'ADDON_INSTALL_EXECUTED' => '插件安装任务已执行',
    'ADDON_INSTALLING' => '插件安装中',
    'INSTALL_CHECK_NOT_PASS' => '安装校验未通过',
    'ADMIN_INDEX_VIEW_PATH_NOT_EXIST' => '当前首页路径不存在',
    'ADDON_SQL_FAIL' => '插件sql执行失败',
    'ADDON_DIR_FAIL' => '插件文件操作失败',
    'LAYOUT_NOT_EXIST' => '该布局不存在',
    'ZIP_FILE_NOT_FOUND' => '找不到可用的压缩文件',
    'ZIP_ARCHIVE_NOT_INSTALL' => 'ZipArchive扩展未安装',
    'DOWNLOAD_SUCCESS' => '下载成功',
    'ADDON_INSTALL_FAIL' => '插件安装失败',
    'ADMIN_DIR_NOT_EXIST' => '未找到admin源码所在目录, <a style="text-decoration: underline;" href="https://www.kancloud.cn/niucloud/niucloud-admin-develop/3213544" target="blank">点击查看相关手册</a>',
    'WEB_DIR_NOT_EXIST' => '未找到web源码所在目录, <a style="text-decoration: underline;" href="https://www.kancloud.cn/niucloud/niucloud-admin-develop/3213544" target="blank">点击查看相关手册</a>',
    'UNIAPP_DIR_NOT_EXIST' => '未找到uni-app源码所在目录, <a style="text-decoration: underline;" href="https://www.kancloud.cn/niucloud/niucloud-admin-develop/3213544" target="blank">点击查看相关手册</a>',
    'OPEN_BASEDIR_ERROR' => '请关闭防跨站攻击, 具体操作方法<a style="text-decoration: underline;" href="https://www.kancloud.cn/niucloud/niucloud-admin-develop/3213542" target="blank">点击查看相关手册</a>',
    'ADDON_DOWNLOAD_VERSION_EMPTY' => '该插件还没有发布过版本',
    'ADDON_IS_NOT_EXIST' => '插件不存在',
    'ADDON_KEY_IS_EXIST' => '已存在相同插件标识的应用',
    'ADDON_IS_INSTALLED_NOT_ALLOW_DEL' => '已安装的插件不允许删除',
    'ADDON_ZIP_ERROR' => '插件压缩失败',
    'PHP_SCRIPT_RUNNING_OUT_OF_MEMORY' => 'PHP脚本运行内存不足, 具体操作方法<a style="text-decoration: underline;" href="https://www.kancloud.cn/niushop/niushop_v6/3248604" target="blank">点击查看相关手册</a>',
    'BEFORE_UPGRADING_NEED_UPGRADE_FRAMEWORK' => '升级插件前需要先升级框架',
    'UPGRADE_RECORD_NOT_EXIST' => '升级记录不存在',
    'UPGRADE_BACKUP_CODE_NOT_FOUND' => '未找到备份的源码文件',
    'UPGRADE_BACKUP_SQL_NOT_FOUND' => '未找到备份的数据库文件',
    'NOT_EXIST_UPGRADE_CONTENT' => '没有获取到可以升级的内容',
    'CLOUD_BUILD_AUTH_CODE_NOT_FOUND' => '请先填写授权码',
    'TASK_CYCLE_ERROR' => '任务周期填写错误',
    'UPGRADE_TASK_EXIST' => '有正在执行的升级任务，可以展开正在升级的任务，也可以在开发>更新缓存中清除缓存重新开始升级',
    //登录注册重置账号....

    'LOGIN_SUCCESS' => '登录成功',
    'MUST_LOGIN' => '请登录',
    'LOGIN_EXPIRE' => '登录过期,请重新登录',
    'LOGIN_STATE_ERROR' => '登录状态有误,请重新登录',
    'USER_LOCK' => '账号被锁定',
    'USER_ERROR' => '账号或密码错误',
    'LOGOUT' => '登陆退出',
    'OLD_PASSWORD_ERROR' => '原始密码不正确',
    'MOBILE_LOGIN_UNOPENED' => '手机号登录注册未开启',
    'APP_TYPE_NOT_EXIST' => '无效的登录端口',
    "USER_NOT_ALLOW_DEL" => "该用户是一些站点的管理员不允许删除",
    "SUPER_ADMIN_NOT_ALLOW_DEL" => "超级管理员不允许删除",

    //用户组权限

    'NO_PERMISSION' => '您没有访问权限',

    //插件安装相关
    'REPEAT_INSTALL' => '当前插件已安装,不能重复安装',
    'NOT_UNINSTALL' => '当前插件未安装,不能进行卸载操作',
    'ADDON_INFO_FILE_NOT_EXIST' => '未找到插件的info.json文件',

    //菜单管理
    'MENU_NOT_EXIST' => '菜单不存在',
    'MENU_NOT_ALLOW_DELETE' => '存在子级菜单的目录或菜单不允许删除',

    //用户管理
    'USER_NOT_EXIST' => '用户不存在',
    'ADMIN_NOT_ALLOW_EDIT_ROLE' => '超级管理员不允许改动权限',
    'USERNAME_REPEAT' => '账号重复',
    'MOBILE_REPEAT' => '手机号重复',

    //角色管理
    'USER_ROLE_NOT_EXIST' => '角色不存在',
    'USER_ROLE_NOT_ALLOW_DELETE' => '存在管理员使用当前角色,不允许删除',

    //素材管理
    'ATTACHMENT_GROUP_NOT_EXIST' => '附件组不存在',
    'ATTACHMENT_GROUP_NOT_ALLOW_DELETE' => '当前分组,不允许删除',
    'ATTACHMENT_NOE_EXIST' => '附件不存在',
    'ATTACHMENT_GROUP_HAS_IMAGE' => '附件组中存在图片不允许删除',
    'OSS_TYPE_NOT_EXIST' => '云存储类型不存在',
    'URL_FILE_NOT_EXIST' => '获取不到网址指向的文件',
    'PLEACE_SELECT_IMAGE' => '请选择要删除的图片',
    'UPLOAD_TYPE_ERROR' => '不是有效的上传类型',
    'OSS_FILE_URL_NOT_EXIST' => '远程资源文件地址不能为空',
    'BASE_IMAGE_FILE_NOT_EXIST' => 'base图片资源不能为空',
    'UPLOAD_TYPE_NOT_SUPPORT' => '不支持的上传类型',
    'FILE_ERROR' => '无效的资源',
    'UPLOAD_STORAGE_TYPE_ALL_CLOSE' => '至少要有一个启用的存储方式',
    'STORAGE_NOT_HAS_HTTP_OR_HTTPS' => '空间域名请补全http://或https://',


    //消息管理
    'NOTICE_TYPE_NOT_EXIST' => '消息类型不存在',
    'SMS_TYPE_NOT_EXIST' => '短信类型不存在',
    'SMS_DRIVER_NOT_EXIST' => '短信驱动不存在',
    'NO_SMS_DRIVER_OPEN' => '没有启用的短信',
    'SMS_DRIVER_NOT_OPEN' => '短信没有启用',
    'WECHAT_TEMPLATE_NOTICE_NOT_OPEN' => '微信模板消息没有启用',
    'WEAPP_TEMPLATE_NOTICE_NOT_OPEN' => '微信小程序订阅没有启用',
    'SMS_TYPE_NOT_OPEN' => '没有启用的短信方式',
    'NOTICE_TEMPLATE_NOT_EXIST' => '消息模板不存在',
    'WECHAT_TEMPLATE_NEED_NO' => '微信消息模板缺少模板编号',
    'NOTICE_NOT_OPEN_SMS' => '当前消息未开启短信发送',
    'NOTICE_SMS_EMPTY' => '手机号为空',
    'NOTICE_SMS_NOT_OPEN' => '短信未启用',
    'NOTICE_TEMPLATE_IS_NOT_EXIST' => '消息不存在',

    //会员相关
    'MOBILE_IS_EXIST' => '当前手机号已绑定账号',
    'ACCOUNT_INSUFFICIENT' => '账户余额不足',
    'ACCOUNT_OR_PASSWORD_ERROR' => '账号或密码错误',
    'MEMBER_LOCK' => '账号被锁定',
    'MEMBER_NOT_EXIST' => '账号不存在',
    'MEMBER_OPENID_EXIST' => 'openid已存在',
    'MEMBER_LOGOUT' => '账号退出',
    'MEMBER_TYPE_NOT_EXIST' => '账户类型不存在',
    'MEMBER_IS_EXIST' => '账号已存在',
    'MEMBER_NO_IS_EXIST' => '会员编号已存在',
    'MEMBER_NO_CREATE_ERROR' => '会员编号创建失败',
    'REG_CHANNEL_NOT_EXIST' => '无效的注册渠道',
    'MEMBER_USERNAME_LOGIN_NOT_OPEN' => '未开启账号登录注册',
    'AUTH_LOGIN_NOT_OPEN' => '未开启第三方登录注册',
    'MOBILE_NEEDED' => '手机号必须填写',
    'MOBILE_CAPTCHA_ERROR' => '手机验证码有误',
    'MEMBER_IS_BIND_AUTH' => '当前账号已绑定授权',
    'MEMBER_MOBILE_CAPTCHA_ERROR' => '无效的短信验证码',
    'AUTH_LOGIN_TAG_NOT_EXIST' => '第三方授权标识不能为空',
    'PASSWORD_RESET_SUCCESS' => '密码重置成功',
    'MOBILE_NOT_BIND_MEMBER' => '当前填写的手机号没有绑定此账号',
    'MOBILE_NOT_EXIST_MEMBER' => '当前填写的手机号不存在账号',
    'MOBILE_IS_BIND_MEMBER' => '当前账号已绑定手机号',
    'MOBILE_NOT_CHANGE' => '绑定的手机号与原手机号一致',
    'QRCODE_EXPIRE' => '登录二维码失效',
    'PASSWORD_REQUIRE' => '密码不能为空',
    'LEVEL_NOT_ALLOWED_DELETE' => '该等级下存在会员不允许删除',
    'MEMBER_LEVEL_MAX' => '最多只能有十个等级',

    // 地址相关
    'ADDRESS_ANALYSIS_ERROR' => '地址解析异常',

    //会员提现
    'CASHOUT_NOT_OPEN' => '会员提现业务未开启',
    'CASHOUT_TYPE_NOT_OPEN' => '当前会员提现方式未启用',
    'CASHOUT_LOG_NOT_EXIST' => '提现记录不存在',
    'CASHOUT_AUDITED' => '当前提现记录已被审核',
    'TRANSFER_TYPE_NOT_EXIST' => '存在未定义的转账方式',
    'CASHOUT_IS_REFUSE' => '提现被拒绝,返还零钱',
    'MEMBER_APPLY_CASHOUT' => '会员申请提现,扣除零钱',
    'CASHOUT_MONEY_TOO_LITTLE' => '会员提现金额不能小于最低提现金额',
    'CASHOUT_STATUS_NOT_IN_WAIT_TRANSFER' => '当前提现申请未处于待转账状态',
    'CASHOUT_STATUS_NOT_IN_CANCEL' => '只有进行中的提现才可以取消',
    'CASHOUT_STATUS_NOT_IN_WAIT_AUDIT' => '当前提现申请未处于待审核状态',
    'MEMBER_CASHOUT_TRANSFER' => '会员提现转账',
    'CASH_OUT_ACCOUNT_NOT_EXIST' => '提现账户不存在',
    'CASH_OUT_WECHAT_ACCOUNT_NOT_ALLOW_ADMIN' => '在转账到微信零钱的提现场景下,提现操作应该由用户在客户端发起',

    'CASH_OUT_ACCOUNT_NOT_FOUND_VALUE' => '转账到微信零钱缺少参数',

    //DIY
    'PAGE_NOT_EXIST' => '页面不存在',
    'DIY_THEME_COLOR_NOT_EXIST' => '主题配色不存在',
    'DIY_THEME_DEFAULT_COLOR_CAN_NOT_DELETE' => '系统默认配色不能删除',
    'DIY_THEME_SELECTED_CAN_NOT_DELETE' => '主题配色已选中不能删除',

    //海报
    'POSTER_NOT_EXIST' => '海报不存在',
    'POSTER_IN_USE_NOT_ALLOW_MODIFY' => '海报使用中禁止修改状态',
    'POSTER_CREATE_ERROR' => '海报组件未配置完善,请联系管理员',

    //万能表单
    'DIY_FORM_NOT_EXIST' => '表单不存在',
    'DIY_FORM_NOT_OPEN' => '该表单已关闭',
    'DIY_FORM_EXCEEDING_LIMIT' => '已达提交次数上限',
    'ON_STATUS_PROHIBIT_DELETE' => '启用状态下禁止删除',
    'DIY_FORM_TYPE_NOT_EXIST' => '表单类型不存在',

    //渠道相关  占用 4******
    //微信
    'WECHAT_NOT_EXIST' => '微信公众号未配置完善',
    'KEYWORDS_NOT_EXIST' => '关键词回复不存在',
    'WECHAT_EMPOWER_NOT_EXIST' => '微信授权信息不存在',
    'SCAN_SUCCESS' => '扫码成功',
    'WECHAT_SNAPSHOUTUSER' => '返回的是虚拟账号',
    //小程序
    'WEAPP_NOT_EXIST' => '微信小程序未配置完善',
    'WEAPP_EMPOWER_NOT_EXIST' => '微信小程序授信信息不存在',
    'WEAPP_EMPOWER_TEL_NOT_EXIST' => '微信小程序授信手机号不存在',
    'WECHAT_MINI_PROGRAM_CODE_GENERATION_FAILED' => '微信小程序码生成失败',


    //支付相关(todo  注意:7段不共享)
    'ALIPAY_TRANSACTION_NO_NOT_EXIST' => '无效的支付交易号',
    'PAYMENT_METHOD_NOT_SUPPORT' => '您选择到支付方式不受业务支持',
    'WECHAT_TRANSFER_CONFIG_NOT_EXIST' => '微信零钱打款设置未配置完善',
    'PAYMENT_LOCK' => '支付中,请稍后再试',
    'PAY_SUCCESS' => '当前支付已完成',
    'PAY_IS_REMOVE' => '当前支付已取消',
    'PAYMENT_METHOD_NOT_EXIST' => '你选择的支付方式未启用',
    'PAYMENT_METHOD_NOT_SCENE' => '你选择的支付方式不适用于当前场景',
    'TREAT_PAYMENT_IS_OPEN' => '只有待支付时可以关闭',
    'TRANFER_STATUS_NOT_IN_WAIT_TANSFER' => '当前转账未处于待转账状态',
    'TRANSFER_ORDER_INVALID' => '无效的转账单据',
    'TRANSFER_IS_FAILING' => '单据正在撤销中,请等待片刻或稍后再试',
    'TRANFER_CONFIG_ERROR' => '参数有误或未开通转账业务',
    'IS_PAY_REMOVE_NOT_RESETTING' => '已支付和已取消的单据不可以重置',
    'DOCUMENT_IS_PAY_REMOVE' => '当前单据已支付或已取消',
    'PATMENT_METHOD_INVALID' => '无效的支付方式',
    'CHANNEL_MARK_INVALID' => '无效的渠道标识',
    'TEMPLATE_NOT_EXIST' => '模板不存在',
    'IS_EXIST_TEMPLATE_NOT_MODIFY' => '已存在的支付模板不支持修改支付类型',
    'ONLY_PAYING_CAN_PAY' => '只有待支付的订单可以支付',
    'VOUCHER_NOT_EMPTY' => '支付单据不能为空',
    'ONLY_PAYING_CAN_AUDIT' => '只有待支付的订单才可以操作',
    'ONLY_OFFLINEPAY_CAN_AUDIT' => '只有线下支付的单据才可以审核',
    'TRADE_NOT_EXIST' => '支付单据不存在',
    'PAY_NOT_FOUND_TRADE' => '找不到可支付的交易',

    'MERCHANT_TRANSFER_SCENARIOS_THAT_DO_NOT_EXIST' => '不存在的商户转账场景',
    //退款相关
    'REFUND_NOT_EXIST' => '退款单据不存在',
    //订单相关  8***
    'ORDER_NOT_EXIST' => '订单不存在',
    'ORDER_CLOSED' => '订单已关闭',
    'DOCUMENT_IS_PAID' => '单据已支付',
    'REFUND_IS_CHANGE' => '退款状态已发生变化',
    'TRANFER_IS_CHANGE' => '转账状态已发生变化',

    // 退款相关
    'NOT_ALLOW_APPLY_REFUND' => '该订单不允许退款',
    'ITEM_REFUND_NOT_EXIST' => '退款单不存在',
    'REFUND_STATUS_ABNORMAL' => '退款单状态异常',
    'NO_REFUNDABLE_AMOUNT' => '会员账户金额为0不允许进行退款',
    'REFUND_HAD_APPLIED' => '订单已申请退款',
    'ORDER_UNPAID_NOT_ALLOW_APPLY_REFUND' => '订单尚未支付不能进行退款',

    //会员套餐
    'RECHARGE_NOT_EXIST' => '充值套餐不存在',

    // 缓存相关
    'CLEAR_MYSQL_CACHE_SUCCESS' => '数据表缓存清除成功',
    'CACHE_CLEAR_SUCCESS' => '缓存清除成功',

    //任务队列相关
    'JOB_NOT_EXISTS' => '任务类不存在',
    'JOB_CREATE_FAIL' => '任务创建失败',
    'SCHEDULE_NOT_EXISTS' => '人物不存在',
    //小程序版本
    'APPLET_VERSION_NOT_EXISTS' => '小程序版本不存在',
    'APPLET_VERSION_PACKAGE_NOT_EXIST' => '小程序版本包不存在',
    //验证码
    'CAPTCHA_INVALID' => '无效的验证码',

    // 授权相关
    'AUTH_NOT_EXISTS' => '未获取到授权信息',

    //签到相关
    'SIGN_NOT_USE' => '签到未开启',
    'SIGN_NOT_SET' => '签到参数未配置',
    'SIGNED_TODAY' => '今日已签到',
    'CONTINUE_SIGN' => '连签',
    'DAYS' => '天！',
    'SIGN_SUCCESS' => '签到成功',
    'SIGN_AWARD' => '签到奖励',
    'GET_AWARD' => '恭喜您获得以下奖励',
    'WILL_GET_AWARD' => '您将获得以下奖励',
    'SIGN_PERIOD_CANNOT_EMPTY' => '签到周期不能为空',
    'SIGN_PERIOD_BETWEEN_2_365_DAYS' => '签到周期为2-365天',
    'CONTINUE_SIGN_BETWEEN_2_365_DAYS' => '连签天数为2-365天',
    'CONTINUE_SIGN_CANNOT_GREATER_THAN_SIGN_PERIOD' => '连签天数不能大于签到周期',

    //导出相关
    'EXPORT_SUCCESS' => '导出成功',
    'EXPORT_FAIL' => '导出失败',
    'EXPORT_NO_DATA' => '暂无可导出数据',
    'DIRECTORY' => '目录',
    'WAS_NOT_CREATED' => '创建失败',
    /*******************************************牛云短信 start ********************************************************/
    'NIU_SMS_ENABLE_FAILED' => '需登录账号并配置签名后才能启用牛云短信',
    'ACCOUNT_ERROR_RELOGIN' => '牛云短信账号异常,请重新登录账号',
    'ACCOUNT_BIND_MOBILE_ERROR' => '手机号错误',
    'TEMPLATE_NOT_SMS_CONTENT' => '当前模版未配置短信内容',
    'TEMPLATE_IS_PASS' => '审核通过的模版不允许修改',
    'TEMPLATE_NOT_REPORT' => '短信模版暂未报备',
    'URL_NOT_FOUND' => '未配置远程服务地址，请在ENV中配置{NIU_SHOP_PREFIX}',
    'SYSTEM_IS_ERROR' => '远程服务器异常，请联系售后人员',

    'TEMPLATE_ERROR' => '短信模版ID错误或审核未通过',
    'TEMPLATE_USE_ERROR' => '短信模版参数不一致需修改/重新报备',
    /*******************************************牛云短信 end ********************************************************/

      //端口管理
    'dict_app' => [
        'type_admin' => '平台管理端',
        'type_api' => '客户端',
    ],
    'dict_menu' => [
        //菜单类型
        'type_list' => '目录',
        'type_menu' => '菜单',
        'type_button' => '按钮',
        //菜单状态
        'status_on' => '正常',
        'status_off' => '停用',
        'source_system' => '系统文件',
        'source_create' => '新建菜单',
        'source_generator' => '代码生成器'
    ],
    'dict_user' => [
        //用户状态
        'status_on' => '正常',
        'status_off' => '锁定'
    ],
    'dict_role' => [
        //角色状态
        'status_on' => '启用',
        'status_off' => '停用'
    ],
    // 站点
    'dict_site' => [
        //站点类型
        'type_cms' => 'cms',
        'status_on' => '正常',
        'status_experience' => '体验期',
        'status_expire' => '已到期',
        'status_close' => '已停止',
        'pay' => '支付',
        'refund' => '退款',
        'transfer' => '转账',
    ],
    // 站点
    'dict_site_index' => [
        //站点类型
        'system' => '框架首页',
    ],
    // 平台首页
    'dict_admin_index' => [
        //站点类型
        'system' => '框架首页',
    ],
    // 手机端首页
    'dict_wap_index' => [
        //站点类型
        'system' => '框架首页',
        'system_desc' => '系统默认首页',
    ],
    'dict_notice' => [
        'type_sms' => '短信',
        'type_wechat' => '微信公众号',
        'type_weapp' => '微信小程序',
        'var_username' => '用户名',
        'var_nickname' => '用户昵称',
        'var_code' => '验证码',
        'var_mobile' => '手机号',
        'var_balance' => '会员余额',
        'var_point' => '会员积分',
    ],
    'dict_sms_api' => [
        'sign_audit_status_wait' => '待审核',
        'sign_audit_status_pass' => '审核通过',
        'sign_audit_status_refuse' => '审核不通过',

        'balance_add' => '充值',
        'balance_reduce' => '扣减'
    ],

    //上传附件相关
    'dict_file' => [
        //上传附件类型
        'type_image' => '图片',
        'type_video' => '视频',
        'type_audio' => '音频',
        //存储方式
        'storage_type_local' => '本地存储',
        'storage_type_qiniu' => '七牛云',
        'storage_type_image' => '阿里云',
        'storage_type_qcloud' => '腾讯云',

    ],
    'dict_member' => [
        //会员端口
        'register_wechat' => '公众号',
        'register_weapp' => '微信小程序',
        'register_h5' => 'H5',
        'register_pc' => '电脑端',
        'register_app' => 'APP',
        'register_manual' => '商家添加',
        'register_username' => '用户名密码注册',
        'register_mobile' => '手机验证码注册',
        'account_point' => '积分',
        'account_balance' => '余额',
        'account_balance_recharge_refund' => '充值订单退款',
        'account_balance_recharge' => '余额充值',
        'account_point_recharge_give' => '充值赠送',
        'account_money' => '可提现余额',
        'account_commission' => '佣金',
        'account_growth' => '成长值',
        'login_username' => '用户名密码登录',
        'login_mobile' => '手机验证码登录',
        'login_wechat' => '微信公众号授权登录',
        'login_weapp' => '微信小程序授权登录',
        'login_pc' => '电脑端微信授权登录',
        'account_point_adjust' => '账户调整',
        'account_point_member_register' => '会员注册',
        'account_point_level_upgrade' => '升级礼包',
        'account_point_day_sign_award' => '日签奖励',
        'account_point_continue_sign_award' => '连签奖励',
        'account_balance_adjust' => '账户调整',
        'account_balance_member_register' => '会员注册',
        'account_money_award' => '活动奖励',
        'account_money_cash_out' => '账户提现',
        'account_money_adjust' => '账户调整',
        'account_commission_award' => '活动奖励',
        'account_commission_cash_out' => '账户提现',
        'status_on' => '正常',
        'status_off' => '锁定',

        'account_balance_order' => '订单消费',
        'account_balance_order_refund' => '订单退款',
        'account_balance_level_upgrade' => '升级礼包',
        'account_balance_day_sign_award' => '日签奖励',
        'account_balance_continue_sign_award' => '连签奖励',
    ],
    'dict_order' => [


    ],
    'dict_refund' => [
        //订单类型
        'wait' => '待审核',
        'wait_transfer' => "待转账",
        "success" => "退款成功",
        "fail" => "退款失败",
        'all' => '累计退款',
        'have' => '退款中金额',

    ],
    //微信回复
    'dict_wechat_reply' => [
        //微信回复状态
        'status_on' => '启用',
        'status_off' => '停用'
    ],
    //自动任务时间间隔
    'dict_schedule' => [
        'type_cron' => '定时任务',
        'type_crond' => '周期任务',
        'on' => '启用',
        'off' => '关闭',

        'min' => '每隔几分钟',
        'hour' => '每隔几小时',
        'day' => '每隔几天',
        'week' => '每周',
        'month' => '每月',

    ],
    //计划任务执行记录
    'dict_schedule_log' => [
        'success' => '成功',
        'error' => '失败',
    ],
    //支付相关
    'dict_pay' => [
        'type_wechatpay' => '微信支付',
        'type_alipay' => '支付宝支付',
        'type_unipay' => '银联支付',
        'type_offline' => '线下支付',
        'type_balancepay' => '余额支付',

        'status_wait' => '待支付',
        'status_ing' => '支付中',
        'status_finish' => '已支付',
        'status_cancel' => '已取消',
        'status_audit' => '待审核',
        'pay' => '收款',
        'refund' => '退款',
        'transfer' => '转账',
    ],
    //转账相关
    'dict_transfer' => [
        'type_wechat' => '微信零钱',
        'type_ali' => '支付宝',
        'type_bank' => '银行卡',
        'type_offline' => '线下转账',
        'type_wechat_code' => '微信',//微信线下打款

        'status_wait' => '待转账',
        'status_dealing' => '处理中',
        'status_success' => '转账成功',
        'status_fail' => '转账失败',
    ],
    'dict_agreement' => [
        //菜单类型
        'service' => '服务协议',
        'privacy' => '隐私协议',
    ],
    //微信配置
    'dict_wechat_config' => [
        'not_encrypt' => '明文',
        'compatible' => '兼容',
        'safe' => '安全'
    ],
    //性别
    'dict_sex' => [
        'unknown' => '未知',
        'man' => '男',
        'woman' => '女'
    ],
    // 自定义页面
    'dict_diy' => [
        'page_index' => '首页',
        'page_member_index' => '个人中心',
        'page_diy' => '微页面',
        'component_type_basic' => '基础组件',

        'system_title' => '系统页面',
        'system_link' => '启动页',
        'system_link_index' => '首页',

        'member_link' => '会员页面',
        'member_index' => '个人中心',
        'member_my_balance' => '我的余额',
        'member_my_point' => '我的积分',
        'member_my_commission' => '我的佣金',
        'member_my_personal' => '个人资料',
        'member_my_address' => '收货地址',
        'member_my_level' => '会员等级',
        'member_my_sign_in' => '我的签到',
        'member_verify_index' => '核销台',
        'member_contact' => '客服',

        'diy_page' => '自定义页面',
        'diy_link' => '自定义链接',
        'diy_jump_other_applet' => '小程序跳转',
        'diy_make_phone_call' => '拨打电话',

        'system_web_index' => '首页',
        'auth_login' => '登录',
        'auth_register' => '注册',
        'auth_bind' => '手机号绑定',

        'diy_form_select' => '万能表单'
    ],
    // 自定义海报
    'dict_diy_poster' => [
        'component_type_basic' => '基础组件',
    ],
    // 系统自定义表单
    'dict_diy_form' => [
        'component_type_form' => '表单组件',
        'type_diy_form' => '自定义表单',
        'type_diy_form_member_info' => '个人资料',
        'type_sign_registration' => '签到报名登记',
        'type_leave_message_suggestion' => '留言建议',
        'type_write_off_voucher' => '核销凭证',
    ],
    //短信相关
    'dict_sms' => [
        'status_sending' => '发送中',
        'status_success' => '成功',
        'status_fail' => '失败',
    ],
    //渠道
    'dict_channel' => [
        //渠道端口
        'channel_pc' => 'PC',
        'channel_h5' => 'H5',
        'channel_app' => 'APP',
        'channel_wechat' => '微信公众号',
        'channel_weapp' => '微信小程序',
    ],
    //会员提现
    'dict_member_cash_out' => [
        //状态
        'status_wait_audit' => '待审核',
        'status_wait_transfer' => '待转账',
        'status_transfer_ing' => '转账中',
        'status_transfered' => '已转账',
        'status_refuse' => '已拒绝',
        'status_cancel' => '已取消'

    ],

    // 退款支付状态
    'dict_pay_refund' => [
        'success' => '退款成功',
        'dealing' => '退款中',
        'wait' => '待退款',
        'fail' => '退款失败',
        'cancel' => '已取消',
        'wechatpay' => '微信原路退款',
        'alipay' => '支付宝原路退款',
        'unipay' => '银联原路退款',
        'offline' => '线下退款',
        'balance' => '退款到余额',
        'back' => '原路退款',
        'status_success' => '退款成功',
        'status_dealing' => '退款中',
        'status_wait' => '待退款',
        'status_fail' => '退款失败',
    ],
    'dict_order_refund' => [
        'refunding' => '退款中',
        'refund_complete' => '退款完成',
        'refund_fail' => '退款失败'
    ],
    'dict_app_manage' => [
        'system_app' => '基础应用',
        'message_manage' => '消息管理',
    ],
    'dict_setting' => [
        'server_system' => '服务器系统',
        'server_setting' => '服务器web环境',
        'php_version' => 'PHP版本',
        'mysql_version' => 'mysql版本',
        'php_ask' => '大于等于8.0.0',
        'mysql_ask' => '大于等于5.7',
        'php_authority_ask' => '开启',
        'file_authority_ask' => '可读可写'
    ],
    //日期
    'dict_date' => [
        //星期
        'mon' => '周一',
        'tue' => '周二',
        'wed' => '周三',
        'thur' => '周四',
        'fri' => '周五',
        'sat' => '周六',
        'sun' => '周日',
        //月份
        'jan' => '1月',
        'feb' => '2月',
        'mar' => '3月',
        'apr' => '4月',
        'may' => '5月',
        'jun' => '6月',
        'jul' => '7月',
        'aug' => '8月',
        'sept' => '9月',
        'oct' => '10月',
        'nov' => '11月',
        'dec' => '12月',

    ],
    'dict_site_layout' => [
        'default' => '默认'
    ],
    'dict_cloud_applet' => [
        'uploading' => '上传中',
        'upload_success' => '上传成功',
        'upload_fail' => '上传失败',
        'auditing' => '审核中',
        'audit_success' => '审核通过',
        'audit_fail' => '审核失败',
        'published' => '已发布',
        'undo' => '已撤回'
    ],
    'dict_wechat_media' => [
        'type_image' => '图片',
        'type_voice' => '语音',
        'type_video' => '视频',
        'type_news' => '图文',
    ],
    //导出状态
    'dict_export' => [
        'status_exporting' => '导出中',
        'status_success' => '导出成功',
        'status_fail' => '导出失败',
    ],
    //签到类型
    'dict_member_sign_award' => [
        'type_day' => '日签',
        'type_continue' => '连签'
    ],
    //签到状态
    'dict_member_sign' => [
        'status_not_sign' => '未签到',
        'status_signed' => '已签到'
    ],

        //菜单
    'validate_menu' => [
        'menu_name_require' => '菜单名称必须填写',
        'router_path_requireif' => '路由地址必须填写',
        'view_path_requireif' => '菜单路径必须填写',
        'methods_requirewith' => '请求类型必须填写',
        'not_exit_menu_type' => '不存在的菜单类型',
        'not_exit_request_type' => '不存在的菜单类型',
        'exit_menu_key' => '菜单key不可重复'
    ],
    //角色
    'validate_role' => [
        'role_name_require' => '角色名称必须填写',
    ],
    'validate_page' => [
        'page_error' => 'page必须是正整数',
        'limit_number' => 'limit必须是正整数',
        'limit_between' => 'limit必须是正整数并且不能超过120',
    ],
    'validate_user' => [
        'username_require' => '账号必须填写',
        'username_unique' => '账号必须是唯一的',
        'username_max' => '账号最多不能超过15个字符',
        'real_name_require' => '实际姓名必须填写',
        'password_require' => '账号密码必须填写',
    ],
    //附件
    'validate_attachment' => [
        'name_require' => '附件组名称必须填写',
        'not_exit_type' => '请选择有效的附件分组类型',
    ],
    'validate_member' => [
        'username_require' => '账号必须填写',
        'username_is_exist' => '账号已存在',
        'password_require' => '密码必须填写',
        'nickname_require' => '会员昵称必须填写',
        'nickname_max' => '昵称不能超过30个字符',
        'username_max' => '用户名不能超过30个字符',
        'mobile_require' => '手机号必须填写',
        'mobile_mobile' => '手机号格式错误',
        'mobile_unique' => '手机号已存在',
        'sex_bot_exist' => '不存在的性别',
        'label_name_require' => '会员标签必须填写',
        'birthday_format' => '生日日期格式有误',
        'label_name_max' => '会员标签不能超过30个字符',
        'memo_max' => '备注不能超过200个字符',
        'sort_number' => '排序号必须是数字',
        'is_username_number' => '用户名密码登录参数必须是整数',
        'is_username_between' => '用户名密码登录参数必须是0或1',
        'is_mobile_number' => '手机验证码登录参数必须是整数',
        'is_mobile_between' => '手机验证码登录参数必须是0或1',
        'is_auth_register_number' => '第三方自动注册参数必须是整数',
        'is_auth_register_between' => '第三方自动注册参数必须是0或1',
        'is_force_access_user_info_number' => '强制获取用户信息参数必须是整数',
        'is_force_access_user_info_between' => '强制获取用户信息参数必须是0或1',
        'is_bind_mobile_number' => '强制绑定手机参数必须是整数',
        'is_bind_mobile_between' => '强制绑定手机参数必须是0或1',
        'cash_out_is_open_in' => '是否启用必须是0或者1',
        'cash_out_min_min' => '最小提现金额必须是正数',
        'cash_out_rate_between' => '提现手续费必须是0到100之间',
        'cash_out_is_auto_verify_in' => '是否启用审核必须是0或1',
        'cash_out_is_auto_transfer_in' => '是否启用转账必须是0或1',
        'status_require' => '会员状态必须填写',
        'not_exit_status' => '不存在的会员状态',
        'username_cannot_pure_number' => '账号不能是纯数字',
        'level_name_require' => '等级名称必须填写',
        'level_growth_require' => '等级成长值必须填写',
        'level_growth_integer' => '成长值只能为整数'
    ],
    'validate_member_config' => [
        'length_number' => '会员编码必须是整数',
        'length_min' => '会员编码长度不能小于10',
        'length_max' => '会员编码长度不能大于于20',
        'length_between' => '会员编码长度去除前缀后最少不能低于4位,最多不能超过30位',
    ],
    
    'validate_generate' => [
        'id_require' => '请传入正确的数据'
    ],
    //支付验证相关
    'validate_pay' => [
        //支付宝
        'app_id_requireif' => '请填写支付宝分配的app_id',
        'app_secret_cert_requireif' => '请填写应用私钥',
        'app_public_cert_path_requireif' => '请填写应用公钥证书',
        'alipay_public_cert_path_requireif' => '请填写支付宝公钥证书',
        'alipay_root_cert_path_requireif' => '请填写支付宝根证书',
        //微信
        'mch_id_requireif' => '请填写商户号',
        'mch_secret_key_requireif' => '请填写商户秘钥',
        'mch_secret_cert_requiremch_secret_cert_requireif' => '请填写商户私钥',
        'mch_public_cert_path_requireif' => '请填写商户公钥证书路径',

        'not_exit_pay_type' => '不存在的支付类型',
        'name_require' => '模板名称不能为空',
    ],
    'validate_agreement' => [
        'title_require' => '协议标题必须填写',
        'content_require' => '协议内容必须填写',
        'title_max' => '协议标题不能超过20个字符',
    ],
    'validate_generator' => [
        'table_name_require' => '表名称必须填写',
        'table_name_max' => '表名称不能超过64个字符',
        'table_content_require' => '描述必须填写',
        'table_content_max' => '描述不能超过64个字符'
    ],
    //微信公众号
    'validate_wechat' => [
        'appid_require' => 'appid必须填写',
        'appsecret_require' => 'appsecret必须填写',
    ],
    //微信小程序
    'validate_weapp' => [
        'appid_require' => 'appid必须填写',
        'appsecret_require' => 'appsecret必须填写',
    ],
    //会员提现配置
    'validate_member_cash_out_config' => [
        'transfer_type_require' => '至少需选择一种转账方式',
    ],
    // 自定义
    'validate_diy' => [
        'type_not_exist' => '不存在的页面模板',
        'theme_title_unique' => '色调名称必须是唯一的',
        'page_title_unique' => '表单名称必须是唯一的',
    ],
    // 会员提现账号
    'validate_member_cash_out_account' => [
        'not_support_transfer_type' => '不支持的提现方式',
        'bank_name_require' => '银行名称必须填写',
        'account_no_require' => '账号必须填写',
        'realname_require' => '真实姓名必须填写',
    ],
    // 会员提现
    'validate_member_cash_out' => [
        'apply_money_min' => '提现金额需大于0元',
        'not_support_account_type' => '该账户不支持提现',
        'not_support_transfer_type' => '不支持该提现方式',
        'account_id_require' => '请选择提现账户'
    ],
    //计划任务
    'validate_schedule' => [
        'schedule_require' => '计划任务必须选择',
        'schedule_unique' => '当前计划任务已存在',
        'not_exit_schedule_type' => '不是有效的任务类型',
    ],

];
