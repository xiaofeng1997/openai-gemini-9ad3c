<?php
// +----------------------------------------------------------------------
// | Niucloud-admin Enterprise Rapid Development Multi-Application Management Platform
// +----------------------------------------------------------------------
// | Official Website: https://www.niucloud.com
// +----------------------------------------------------------------------
// | niucloud team copyright, open source version can be used commercially
// +----------------------------------------------------------------------
// | Author: Niucloud Team
// +----------------------------------------------------------------------
return [
    // System Common
    'SUCCESS' => 'Operation successful',
    'EDIT_SUCCESS' => 'Edit successful',
    'DELETE_SUCCESS' => 'Delete successful',
    'MODIFY_SUCCESS' => 'Update successful',
    'VERIFY_SUCCESS' => 'Verification successful',
    'FAIL' => 'Operation failed',
    'SAVE_FAIL' => 'Save failed',
    'EDIT_FAIL' => 'Edit failed',
    'DELETE_FAIL' => 'Delete failed',
    'MODIFY_FAIL' => 'Update failed',
    'ADD_FAIL' => 'Add failed',
    'ADD_SUCCESS' => 'Add successful',
    'UPLOAD_FAIL' => 'Upload failed',
    'RELEASE_SUCCESS' => 'Release successful',
    'ATTACHMENT_DELETE_FAIL' => 'Attachment delete failed',
    'DATA_NOT_EXIST' => 'Data does not exist',
    'DOWNLOAD_FAIL' => 'Download failed',
    'SET_SUCCESS' => 'Setting successful',
    'AGREEMENT_TYPE_NOT_EXIST' => 'Agreement type does not exist',
    'FIELD_NOT_FOUND' => 'Field to modify not found',
    'REFRESH_SUCCESS' => 'Refresh successful',
    'CAPTCHA_ERROR' => 'Incorrect captcha',
    'ADDON_INSTALL_SUCCESS' => 'Plugin installed successfully',
    'ADDON_UNINSTALL_SUCCESS' => 'Plugin uninstalled successfully',
    'DATA_GET_FAIL' => 'Data retrieval failed',
    'SERVER_CROSS_REQUEST_FAIL' => 'Server cross-domain request exception',
    'ADDON_INSTALL_NOT_EXIST' => 'Plugin installation task not found',
    'ADDON_INSTALL_EXECUTED' => 'Plugin installation task already executed',
    'ADDON_INSTALLING' => 'Plugin installing',
    'INSTALL_CHECK_NOT_PASS' => 'Installation check failed',
    'ADMIN_INDEX_VIEW_PATH_NOT_EXIST' => 'Current homepage path does not exist',
    'ADDON_SQL_FAIL' => 'Plugin SQL execution failed',
    'ADDON_DIR_FAIL' => 'Plugin file operation failed',
    'LAYOUT_NOT_EXIST' => 'Layout does not exist',
    'ZIP_FILE_NOT_FOUND' => 'Available compressed file not found',
    'ZIP_ARCHIVE_NOT_INSTALL' => 'ZipArchive extension not installed',
    'DOWNLOAD_SUCCESS' => 'Download successful',
    'ADDON_INSTALL_FAIL' => 'Plugin installation failed',
    'ADMIN_DIR_NOT_EXIST' => 'Admin source code directory not found, <a style="text-decoration: underline;" href="https://www.kancloud.cn/niucloud/niucloud-admin-develop/3213544" target="blank">click to view related manual</a>',
    'WEB_DIR_NOT_EXIST' => 'Web source code directory not found, <a style="text-decoration: underline;" href="https://www.kancloud.cn/niucloud/niucloud-admin-develop/3213544" target="blank">click to view related manual</a>',
    'UNIAPP_DIR_NOT_EXIST' => 'Uni-app source code directory not found, <a style="text-decoration: underline;" href="https://www.kancloud.cn/niucloud/niucloud-admin-develop/3213544" target="blank">click to view related manual</a>',
    'OPEN_BASEDIR_ERROR' => 'Please disable cross-site attack protection, specific operation method <a style="text-decoration: underline;" href="https://www.kancloud.cn/niucloud/niucloud-admin-develop/3213542" target="blank">click to view related manual</a>',
    'ADDON_DOWNLOAD_VERSION_EMPTY' => 'This plugin has not released any versions',
    'ADDON_IS_NOT_EXIST' => 'Plugin does not exist',
    'ADDON_KEY_IS_EXIST' => 'Application with same plugin identifier already exists',
    'ADDON_IS_INSTALLED_NOT_ALLOW_DEL' => 'Installed plugins cannot be deleted',
    'ADDON_ZIP_ERROR' => 'Plugin compression failed',
    'PHP_SCRIPT_RUNNING_OUT_OF_MEMORY' => 'PHP script running out of memory, specific operation method <a style="text-decoration: underline;" href="https://www.kancloud.cn/niushop/niushop_v6/3248604" target="blank">click to view related manual</a>',
    'BEFORE_UPGRADING_NEED_UPGRADE_FRAMEWORK' => 'Framework must be upgraded before upgrading plugin',
    'UPGRADE_RECORD_NOT_EXIST' => 'Upgrade record does not exist',
    'UPGRADE_BACKUP_CODE_NOT_FOUND' => 'Backup source code file not found',
    'UPGRADE_BACKUP_SQL_NOT_FOUND' => 'Backup database file not found',
    'NOT_EXIST_UPGRADE_CONTENT' => 'No upgradeable content retrieved',
    'CLOUD_BUILD_AUTH_CODE_NOT_FOUND' => 'Please fill in authorization code first',
    'TASK_CYCLE_ERROR' => 'Task cycle error',
    'UPGRADE_TASK_EXIST' => 'There is an upgrade task in progress, you can expand the upgrading task, or clear the cache in Development > Update Cache to restart the upgrade',
    // Login, Register, Reset Account...

    'LOGIN_SUCCESS' => 'Login successful',
    'MUST_LOGIN' => 'Please login',
    'LOGIN_EXPIRE' => 'Login expired, please login again',
    'LOGIN_STATE_ERROR' => 'Login state error, please login again',
    'USER_LOCK' => 'Account locked',
    'USER_ERROR' => 'Incorrect username or password',
    'LOGOUT' => 'Logout',
    'OLD_PASSWORD_ERROR' => 'Incorrect original password',
    'MOBILE_LOGIN_UNOPENED' => 'Mobile login registration not enabled',
    'APP_TYPE_NOT_EXIST' => 'Invalid login port',
    "USER_NOT_ALLOW_DEL" => "This user is an administrator of some sites and cannot be deleted",
    "SUPER_ADMIN_NOT_ALLOW_DEL" => "Super administrator cannot be deleted",

    // User Group Permissions

    'NO_PERMISSION' => 'You do not have access permission',

    // Plugin Installation Related
    'REPEAT_INSTALL' => 'Current plugin already installed, cannot install repeatedly',
    'NOT_UNINSTALL' => 'Current plugin not installed, cannot uninstall',
    'ADDON_INFO_FILE_NOT_EXIST' => 'Plugin info.json file not found',

    // Menu Management
    'MENU_NOT_EXIST' => 'Menu does not exist',
    'MENU_NOT_ALLOW_DELETE' => 'Directory or menu with sub-menus cannot be deleted',

    // User Management
    'USER_NOT_EXIST' => 'User does not exist',
    'ADMIN_NOT_ALLOW_EDIT_ROLE' => 'Super administrator permissions cannot be modified',
    'USERNAME_REPEAT' => 'Username duplicate',
    'MOBILE_REPEAT' => 'Mobile number duplicate',

    // Role Management
    'USER_ROLE_NOT_EXIST' => 'Role does not exist',
    'USER_ROLE_NOT_ALLOW_DELETE' => 'Role is used by administrators, cannot be deleted',

    // Material Management
    'ATTACHMENT_GROUP_NOT_EXIST' => 'Attachment group does not exist',
    'ATTACHMENT_GROUP_NOT_ALLOW_DELETE' => 'Current group cannot be deleted',
    'ATTACHMENT_NOE_EXIST' => 'Attachment does not exist',
    'ATTACHMENT_GROUP_HAS_IMAGE' => 'Attachment group contains images and cannot be deleted',
    'OSS_TYPE_NOT_EXIST' => 'Cloud storage type does not exist',
    'URL_FILE_NOT_EXIST' => 'Cannot get file pointed by URL',
    'PLEACE_SELECT_IMAGE' => 'Please select images to delete',
    'UPLOAD_TYPE_ERROR' => 'Invalid upload type',
    'OSS_FILE_URL_NOT_EXIST' => 'Remote resource file address cannot be empty',
    'BASE_IMAGE_FILE_NOT_EXIST' => 'Base image resource cannot be empty',
    'UPLOAD_TYPE_NOT_SUPPORT' => 'Unsupported upload type',
    'FILE_ERROR' => 'Invalid resource',
    'UPLOAD_STORAGE_TYPE_ALL_CLOSE' => 'At least one storage method must be enabled',
    'STORAGE_NOT_HAS_HTTP_OR_HTTPS' => 'Please complete space domain with http:// or https://',


    // Message Management
    'NOTICE_TYPE_NOT_EXIST' => 'Message type does not exist',
    'SMS_TYPE_NOT_EXIST' => 'SMS type does not exist',
    'SMS_DRIVER_NOT_EXIST' => 'SMS driver does not exist',
    'NO_SMS_DRIVER_OPEN' => 'No SMS enabled',
    'SMS_DRIVER_NOT_OPEN' => 'SMS not enabled',
    'WECHAT_TEMPLATE_NOTICE_NOT_OPEN' => 'WeChat template message not enabled',
    'WEAPP_TEMPLATE_NOTICE_NOT_OPEN' => 'WeChat mini-program subscription not enabled',
    'SMS_TYPE_NOT_OPEN' => 'No SMS method enabled',
    'NOTICE_TEMPLATE_NOT_EXIST' => 'Message template does not exist',
    'WECHAT_TEMPLATE_NEED_NO' => 'WeChat message template missing template number',
    'NOTICE_NOT_OPEN_SMS' => 'Current message SMS sending not enabled',
    'NOTICE_SMS_EMPTY' => 'Mobile number is empty',
    'NOTICE_SMS_NOT_OPEN' => 'SMS not enabled',
    'NOTICE_TEMPLATE_IS_NOT_EXIST' => 'Message does not exist',

    // Member Related
    'MOBILE_IS_EXIST' => 'Current mobile number already bound to account',
    'ACCOUNT_INSUFFICIENT' => 'Insufficient account balance',
    'ACCOUNT_OR_PASSWORD_ERROR' => 'Incorrect username or password',
    'MEMBER_LOCK' => 'Account locked',
    'MEMBER_NOT_EXIST' => 'Account does not exist',
    'MEMBER_OPENID_EXIST' => 'OpenID already exists',
    'MEMBER_LOGOUT' => 'Account logout',
    'MEMBER_TYPE_NOT_EXIST' => 'Account type does not exist',
    'MEMBER_IS_EXIST' => 'Account already exists',
    'MEMBER_NO_IS_EXIST' => 'Member number already exists',
    'MEMBER_NO_CREATE_ERROR' => 'Member number creation failed',
    'REG_CHANNEL_NOT_EXIST' => 'Invalid registration channel',
    'MEMBER_USERNAME_LOGIN_NOT_OPEN' => 'Username login registration not enabled',
    'AUTH_LOGIN_NOT_OPEN' => 'Third-party login registration not enabled',
    'MOBILE_NEEDED' => 'Mobile number must be filled',
    'MOBILE_CAPTCHA_ERROR' => 'Incorrect mobile verification code',
    'MEMBER_IS_BIND_AUTH' => 'Current account already bound to authorization',
    'MEMBER_MOBILE_CAPTCHA_ERROR' => 'Invalid SMS verification code',
    'AUTH_LOGIN_TAG_NOT_EXIST' => 'Third-party authorization tag cannot be empty',
    'PASSWORD_RESET_SUCCESS' => 'Password reset successful',
    'MOBILE_NOT_BIND_MEMBER' => 'Current filled mobile number not bound to this account',
    'MOBILE_NOT_EXIST_MEMBER' => 'Current filled mobile number does not have account',
    'MOBILE_IS_BIND_MEMBER' => 'Current account already bound to mobile number',
    'MOBILE_NOT_CHANGE' => 'Bound mobile number same as original',
    'QRCODE_EXPIRE' => 'Login QR code expired',
    'PASSWORD_REQUIRE' => 'Password cannot be empty',
    'LEVEL_NOT_ALLOWED_DELETE' => 'Members exist under this level, cannot delete',
    'MEMBER_LEVEL_MAX' => 'Maximum of ten levels allowed',

    // Address Related
    'ADDRESS_ANALYSIS_ERROR' => 'Address parsing exception',

    // Member Withdrawal
    'CASHOUT_NOT_OPEN' => 'Member withdrawal business not enabled',
    'CASHOUT_TYPE_NOT_OPEN' => 'Current member withdrawal method not enabled',
    'CASHOUT_LOG_NOT_EXIST' => 'Withdrawal record does not exist',
    'CASHOUT_AUDITED' => 'Current withdrawal record already audited',
    'TRANSFER_TYPE_NOT_EXIST' => 'Undefined transfer method exists',
    'CASHOUT_IS_REFUSE' => 'Withdrawal rejected, balance returned',
    'MEMBER_APPLY_CASHOUT' => 'Member applies for withdrawal, balance deducted',
    'CASHOUT_MONEY_TOO_LITTLE' => 'Member withdrawal amount cannot be less than minimum withdrawal amount',
    'CASHOUT_STATUS_NOT_IN_WAIT_TRANSFER' => 'Current withdrawal application not in pending transfer status',
    'CASHOUT_STATUS_NOT_IN_CANCEL' => 'Only in-progress withdrawals can be cancelled',
    'CASHOUT_STATUS_NOT_IN_WAIT_AUDIT' => 'Current withdrawal application not in pending audit status',
    'MEMBER_CASHOUT_TRANSFER' => 'Member withdrawal transfer',
    'CASH_OUT_ACCOUNT_NOT_EXIST' => 'Withdrawal account does not exist',
    'CASH_OUT_WECHAT_ACCOUNT_NOT_ALLOW_ADMIN' => 'In withdrawal scenario of transferring to WeChat balance, withdrawal operation should be initiated by user on client',

    'CASH_OUT_ACCOUNT_NOT_FOUND_VALUE' => 'Transfer to WeChat balance missing parameters',

    // DIY
    'PAGE_NOT_EXIST' => 'Page does not exist',
    'DIY_THEME_COLOR_NOT_EXIST' => 'Theme color scheme does not exist',
    'DIY_THEME_DEFAULT_COLOR_CAN_NOT_DELETE' => 'System default color scheme cannot be deleted',
    'DIY_THEME_SELECTED_CAN_NOT_DELETE' => 'Theme color scheme already selected cannot be deleted',

    // Poster
    'POSTER_NOT_EXIST' => 'Poster does not exist',
    'POSTER_IN_USE_NOT_ALLOW_MODIFY' => 'Poster in use, status modification prohibited',
    'POSTER_CREATE_ERROR' => 'Poster components not configured properly, please contact administrator',

    // Universal Form
    'DIY_FORM_NOT_EXIST' => 'Form does not exist',
    'DIY_FORM_NOT_OPEN' => 'This form closed',
    'DIY_FORM_EXCEEDING_LIMIT' => 'Submission limit reached',
    'ON_STATUS_PROHIBIT_DELETE' => 'Deletion prohibited when enabled',
    'DIY_FORM_TYPE_NOT_EXIST' => 'Form type does not exist',

    // Channel Related  Occupy 4******
    // WeChat
    'WECHAT_NOT_EXIST' => 'WeChat official account not configured properly',
    'KEYWORDS_NOT_EXIST' => 'Keyword reply does not exist',
    'WECHAT_EMPOWER_NOT_EXIST' => 'WeChat authorization information does not exist',
    'SCAN_SUCCESS' => 'Scan successful',
    'WECHAT_SNAPSHOUTUSER' => 'Returned virtual account',
    // Mini Program
    'WEAPP_NOT_EXIST' => 'WeChat mini-program not configured properly',
    'WEAPP_EMPOWER_NOT_EXIST' => 'WeChat mini-program authorization information does not exist',
    'WEAPP_EMPOWER_TEL_NOT_EXIST' => 'WeChat mini-program authorization mobile number does not exist',
    'WECHAT_MINI_PROGRAM_CODE_GENERATION_FAILED' => 'WeChat mini-program code generation failed',


    // Payment Related (todo  Note: 7 segment not shared)
    'ALIPAY_TRANSACTION_NO_NOT_EXIST' => 'Invalid payment transaction number',
    'PAYMENT_METHOD_NOT_SUPPORT' => 'Selected payment method not supported by business',
    'WECHAT_TRANSFER_CONFIG_NOT_EXIST' => 'WeChat balance transfer configuration not set properly',
    'PAYMENT_LOCK' => 'Payment in progress, please try again later',
    'PAY_SUCCESS' => 'Current payment completed',
    'PAY_IS_REMOVE' => 'Current payment cancelled',
    'PAYMENT_METHOD_NOT_EXIST' => 'Selected payment method not enabled',
    'PAYMENT_METHOD_NOT_SCENE' => 'Selected payment method not applicable to current scenario',
    'TREAT_PAYMENT_IS_OPEN' => 'Can only close when pending payment',
    'TRANFER_STATUS_NOT_IN_WAIT_TANSFER' => 'Current transfer not in pending transfer status',
    'TRANSFER_ORDER_INVALID' => 'Invalid transfer document',
    'TRANSFER_IS_FAILING' => 'Document being cancelled, please wait a moment or try again later',
    'TRANFER_CONFIG_ERROR' => 'Parameter error or transfer business not enabled',
    'IS_PAY_REMOVE_NOT_RESETTING' => 'Paid and cancelled documents cannot be reset',
    'DOCUMENT_IS_PAY_REMOVE' => 'Current document paid or cancelled',
    'PATMENT_METHOD_INVALID' => 'Invalid payment method',
    'CHANNEL_MARK_INVALID' => 'Invalid channel identifier',
    'TEMPLATE_NOT_EXIST' => 'Template does not exist',
    'IS_EXIST_TEMPLATE_NOT_MODIFY' => 'Existing payment template does not support modifying payment type',
    'ONLY_PAYING_CAN_PAY' => 'Only pending payment orders can be paid',
    'VOUCHER_NOT_EMPTY' => 'Payment document cannot be empty',
    'ONLY_PAYING_CAN_AUDIT' => 'Only pending payment orders can be operated',
    'ONLY_OFFLINEPAY_CAN_AUDIT' => 'Only offline payment documents can be audited',
    'TRADE_NOT_EXIST' => 'Payment document does not exist',
    'PAY_NOT_FOUND_TRADE' => 'No payable trade found',

    'MERCHANT_TRANSFER_SCENARIOS_THAT_DO_NOT_EXIST' => 'Non-existent merchant transfer scenario',
    // Refund Related
    'REFUND_NOT_EXIST' => 'Refund document does not exist',
    // Order Related  8***
    'ORDER_NOT_EXIST' => 'Order does not exist',
    'ORDER_CLOSED' => 'Order closed',
    'DOCUMENT_IS_PAID' => 'Document paid',
    'REFUND_IS_CHANGE' => 'Refund status changed',
    'TRANFER_IS_CHANGE' => 'Transfer status changed',

    // Refund Related
    'NOT_ALLOW_APPLY_REFUND' => 'This order does not allow refund',
    'ITEM_REFUND_NOT_EXIST' => 'Refund document does not exist',
    'REFUND_STATUS_ABNORMAL' => 'Refund document status abnormal',
    'NO_REFUNDABLE_AMOUNT' => 'Member account amount is 0, refund not allowed',
    'REFUND_HAD_APPLIED' => 'Order already applied for refund',
    'ORDER_UNPAID_NOT_ALLOW_APPLY_REFUND' => 'Order not yet paid, cannot apply for refund',

    // Member Package
    'RECHARGE_NOT_EXIST' => 'Recharge package does not exist',

    // Cache Related
    'CLEAR_MYSQL_CACHE_SUCCESS' => 'Database table cache cleared successfully',
    'CACHE_CLEAR_SUCCESS' => 'Cache cleared successfully',

    // Task Queue Related
    'JOB_NOT_EXISTS' => 'Task class does not exist',
    'JOB_CREATE_FAIL' => 'Task creation failed',
    'SCHEDULE_NOT_EXISTS' => 'Schedule does not exist',
    // Mini Program Version
    'APPLET_VERSION_NOT_EXISTS' => 'Mini program version does not exist',
    'APPLET_VERSION_PACKAGE_NOT_EXIST' => 'Mini program version package does not exist',
    // Captcha
    'CAPTCHA_INVALID' => 'Invalid captcha',

    // Authorization Related
    'AUTH_NOT_EXISTS' => 'Authorization information not obtained',

    // Sign-in Related
    'SIGN_NOT_USE' => 'Sign-in not enabled',
    'SIGN_NOT_SET' => 'Sign-in parameters not configured',
    'SIGNED_TODAY' => 'Already signed in today',
    'CONTINUE_SIGN' => 'Consecutive sign-in',
    'DAYS' => 'days!',
    'SIGN_SUCCESS' => 'Sign-in successful',
    'SIGN_AWARD' => 'Sign-in reward',
    'GET_AWARD' => 'Congratulations, you have received the following rewards',
    'WILL_GET_AWARD' => 'You will receive the following rewards',
    'SIGN_PERIOD_CANNOT_EMPTY' => 'Sign-in period cannot be empty',
    'SIGN_PERIOD_BETWEEN_2_365_DAYS' => 'Sign-in period is 2-365 days',
    'CONTINUE_SIGN_BETWEEN_2_365_DAYS' => 'Consecutive sign-in days is 2-365 days',
    'CONTINUE_SIGN_CANNOT_GREATER_THAN_SIGN_PERIOD' => 'Consecutive sign-in days cannot be greater than sign-in period',

    // Export Related
    'EXPORT_SUCCESS' => 'Export successful',
    'EXPORT_FAIL' => 'Export failed',
    'EXPORT_NO_DATA' => 'No data to export',
    'DIRECTORY' => 'Directory',
    'WAS_NOT_CREATED' => 'Creation failed',
    /******************************************* NiuCloud SMS Start ********************************************************/
    'NIU_SMS_ENABLE_FAILED' => 'Must login and configure signature before enabling NiuCloud SMS',
    'ACCOUNT_ERROR_RELOGIN' => 'NiuCloud SMS account error, please login again',
    'ACCOUNT_BIND_MOBILE_ERROR' => 'Mobile number error',
    'TEMPLATE_NOT_SMS_CONTENT' => 'Current template not configured with SMS content',
    'TEMPLATE_IS_PASS' => 'Approved template cannot be modified',
    'TEMPLATE_NOT_REPORT' => 'SMS template not yet reported',
    'URL_NOT_FOUND' => 'Remote service address not configured, please configure {NIU_SHOP_PREFIX} in ENV',
    'SYSTEM_IS_ERROR' => 'Remote server exception, please contact after-sales personnel',

    'TEMPLATE_ERROR' => 'SMS template ID error or not approved',
    'TEMPLATE_USE_ERROR' => 'SMS template parameters inconsistent, need to modify/re-report',
    /******************************************* NiuCloud SMS End ********************************************************/

      // Port Management
    'dict_app' => [
        'type_admin' => 'Platform Management End',
        'type_api' => 'Client End',
    ],
    'dict_menu' => [
        // Menu Type
        'type_list' => 'Directory',
        'type_menu' => 'Menu',
        'type_button' => 'Button',
        // Menu Status
        'status_on' => 'Normal',
        'status_off' => 'Disabled',
        'source_system' => 'System File',
        'source_create' => 'New Menu',
        'source_generator' => 'Code Generator'
    ],
    'dict_user' => [
        // User Status
        'status_on' => 'Normal',
        'status_off' => 'Locked'
    ],
    'dict_role' => [
        // Role Status
        'status_on' => 'Enabled',
        'status_off' => 'Disabled'
    ],
    // Site
    'dict_site' => [
        // Site Type
        'type_cms' => 'cms',
        'status_on' => 'Normal',
        'status_experience' => 'Trial Period',
        'status_expire' => 'Expired',
        'status_close' => 'Stopped',
        'pay' => 'Payment',
        'refund' => 'Refund',
        'transfer' => 'Transfer',
    ],
    // Site
    'dict_site_index' => [
        // Site Type
        'system' => 'Framework Homepage',
    ],
    // Platform Homepage
    'dict_admin_index' => [
        // Site Type
        'system' => 'Framework Homepage',
    ],
    // Mobile Homepage
    'dict_wap_index' => [
        // Site Type
        'system' => 'Framework Homepage',
        'system_desc' => 'System Default Homepage',
    ],
    'dict_notice' => [
        'type_sms' => 'SMS',
        'type_wechat' => 'WeChat Official Account',
        'type_weapp' => 'WeChat Mini Program',
        'var_username' => 'Username',
        'var_nickname' => 'Nickname',
        'var_code' => 'Verification Code',
        'var_mobile' => 'Mobile Number',
        'var_balance' => 'Member Balance',
        'var_point' => 'Member Points',
    ],
    'dict_sms_api' => [
        'sign_audit_status_wait' => 'Pending Approval',
        'sign_audit_status_pass' => 'Approved',
        'sign_audit_status_refuse' => 'Approval Rejected',

        'balance_add' => 'Recharge',
        'balance_reduce' => 'Deduct'
    ],

    // Upload Attachment Related
    'dict_file' => [
        // Upload Attachment Type
        'type_image' => 'Image',
        'type_video' => 'Video',
        'type_audio' => 'Audio',
        // Storage Method
        'storage_type_local' => 'Local Storage',
        'storage_type_qiniu' => 'Qiniu Cloud',
        'storage_type_image' => 'Aliyun',
        'storage_type_qcloud' => 'Tencent Cloud',

    ],
    'dict_member' => [
        // Member Port
        'register_wechat' => 'Official Account',
        'register_weapp' => 'WeChat Mini Program',
        'register_h5' => 'H5',
    ]
];
