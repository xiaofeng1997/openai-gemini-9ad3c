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
 * 路由
 */
Route::group('sys', function() {
    /***************************************************** 系统整体信息 *************************************************/
    //系统信息
    Route::get('info', 'sys.System/info');
    Route::get('url', 'sys.System/url');
    Route::get('qrcode', 'sys.System/getSpreadQrcode');
    /***************************************************** 用户组 ****************************************************/
    //用户组列表
    Route::get('role', 'sys.Role/lists');
    //用户组列表
    Route::get('role/all', 'sys.Role/all');
    //用户组详情
    Route::get('role/:role_id', 'sys.Role/info');
    //用户组新增
    Route::post('role', 'sys.Role/add');
    //修改角色状态
    Route::put('role/status', 'sys.Role/modifyStatus');
    //编辑用户组
    Route::put('role/:role_id', 'sys.Role/edit');
    //删除用户组
    Route::delete('role/:role_id', 'sys.Role/del');
    /***************************************************** 部门管理 ****************************************************/
    //部门列表
    Route::get('dept', 'sys.Dept/lists');
    //部门全部列表
    Route::get('dept/all', 'sys.Dept/getAll');
    //部门树形列表
    Route::get('dept/tree', 'sys.Dept/getTree');
    //部门详情
    Route::get('dept/:id', 'sys.Dept/info');
    //部门新增
    Route::post('dept', 'sys.Dept/add');
    //编辑部门
    Route::put('dept/:id', 'sys.Dept/edit');
    //删除部门
    Route::delete('dept/:id', 'sys.Dept/del');
    /***************************************************** 岗位管理 ****************************************************/
    //岗位列表
    Route::get('position', 'sys.Position/lists');
    //岗位全部列表
    Route::get('position/all', 'sys.Position/getAll');
    //根据部门获取岗位列表
    Route::get('position/dept/:dept_id', 'sys.Position/getByDept');
    //岗位详情
    Route::get('position/:id', 'sys.Position/info');
    //岗位新增
    Route::post('position', 'sys.Position/add');
    //编辑岗位
    Route::put('position/:id', 'sys.Position/edit');
    //删除岗位
    Route::delete('position/:id', 'sys.Position/del');
    /***************************************************** 菜单 ****************************************************/
    //菜单新增
    Route::post('menu', 'sys.Menu/add');
    //菜单更新
    Route::put('menu/:menu_key', 'sys.Menu/edit');
    //菜单列表
    Route::get('menu', 'sys.Menu/lists');
    //删除单个菜单
    Route::delete('menu/:menu_key', 'sys.Menu/del');
    // 获取菜单信息
    Route::get('menu/info/:menu_key', 'sys.Menu/info');
    // 初始化菜单
    Route::post('menu/refresh', 'sys.Menu/refreshMenu');
    //菜单类型
    Route::get('menutype', 'sys.Menu/getMenuType');
    //授权用户菜单
    Route::get('authmenu', 'sys.Auth/authMenuList');
    // 获取菜单信息
    Route::get('menu/info/:menu_key', 'sys.Menu/info');
    // 初始化菜单
    Route::post('menu/refresh', 'sys.Menu/refreshMenu');

    Route::get('menu/mothod', 'sys.Menu/getMethodType');

    Route::get('menu/system_menu', 'sys.Menu/getSystem');

    Route::get('menu/addon_menu/:app_key', 'sys.Menu/getAddonMenu');

    Route::get('menu/dir/:addon', 'sys.Menu/getMenuByTypeDir');
    /***************************************************** 设置 ****************************************************/
    //网站设置
    Route::get('config/website', 'sys.Config/getWebsite');
    //网站设置
    Route::put('config/website', 'sys.Config/setWebsite');
    //服务信息设置
    Route::get('config/service', 'sys.Config/getServiceInfo');
    //版权设置
    Route::get('config/copyright', 'sys.Config/getCopyright');
    //版权设置
    Route::put('config/copyright', 'sys.Config/setCopyright');

    //地图设置
    Route::put('config/map', 'sys.Config/setMap');
    //地图设置
    Route::get('config/map', 'sys.Config/getMap');

    //登录注册设置
    Route::get('config/login', 'login.Config/getConfig');
    //登录注册设置
    Route::put('config/login', 'login.Config/setConfig');

    // 开发者key
    Route::put('config/developer_token', 'sys.Config/setDeveloperToken');
    // 开发者key
    Route::get('config/developer_token', 'sys.Config/getDeveloperToken');

    // 布局设置
    Route::get('config/layout', 'sys.Config/getLayout');
    // 布局设置
    Route::put('config/layout', 'sys.Config/setLayout');

    // 色调设置
    Route::get('config/themecolor', 'sys.Config/getThemeColor');
    // 色调设置
    Route::put('config/themecolor', 'sys.Config/setThemeColor');

    /***************************************************** 图片上传 ****************************************************/
    //附件图片上传
    Route::post('image', 'upload.Upload/image');
    //附件视频上传
    Route::post('video', 'upload.Upload/video');
    //附件音频上传
    Route::post('audio', 'upload.Upload/audio');
    //附件上传
    Route::post('document/:type', 'upload.Upload/document');
    //附件列表
    Route::get('attachment', 'sys.Attachment/lists');
    //附件列表
    Route::delete('attachment/:att_id', 'sys.Attachment/del');

    //附件删除
    Route::delete('attachment/del', 'sys.Attachment/batchDel');
    //移动图片分组
//    Route::put('attachment/move/:att_id', 'sys.Attachment/moveCategory');
    //批量移动图片分组
    Route::put('attachment/batchmove', 'sys.Attachment/batchMoveCategory');
    //附件组新增
    Route::post('attachment/category', 'sys.Attachment/addCategory');
    //附件组更新
    Route::put('attachment/category/:id', 'sys.Attachment/editCategory');
    //附件组列表
    Route::get('attachment/category', 'sys.Attachment/categoryLists');
    //删除单个附件组
    Route::delete('attachment/category/:id', 'sys.Attachment/deleteCategory');
    //获取存储列表
    Route::get('storage', 'upload.Storage/storageList');
    //存储详情
    Route::get('storage/:storage_type', 'upload.Storage/storageConfig');
    //存储修改
    Route::put('storage/:storage_type', 'upload.Storage/editStorage');
    //上传设置
    Route::put('upload/config', 'upload.Upload/setUploadConfig');
    //获取上传设置
    Route::get('upload/config', 'upload.Upload/getUploadConfig');
    /***************************************************** 协议管理 ****************************************************/
    //消息列表
    Route::get('agreement', 'sys.Agreement/lists');
    //消息详情
    Route::get('agreement/:key', 'sys.Agreement/info');
    //短信配置修改
    Route::put('agreement/:key', 'sys.Agreement/edit');
    /***************************************************** 地区管理 ****************************************************/
    //通过pid获取列表
    Route::get('area/list_by_pid/:pid', 'sys.Area/listByPid');
    //通过层级获取列表
    Route::get('area/tree/:level', 'sys.Area/tree');
    //获取地址位置信息
    Route::get('area/get_info', 'sys.Area/addressInfo');
    Route::get('area/contrary', 'sys.Area/contraryAddress');
    // 获取省市县数据根据地址id
    Route::get('area/code/:code', 'sys.Area/areaByAreaCode');

    /***************************************************** 渠道管理 ****************************************************/
    Route::get('channel', 'sys.Channel/getChannelType');
    //场景域名
    Route::get('scene_domain', 'sys.Config/getSceneDomain');
    /***************************************************** 系统环境 ****************************************************/
    Route::get('system', 'sys.System/getSystemInfo');
    //校验消息队列
    Route::get('job', 'sys.System/checkJob');
    //校验计划任务
    Route::get('schedule', 'sys.System/checkSchedule');
    //环境变量
    Route::get('env', 'sys.System/getEnvInfo');

    /***************************************************** 计划任务 ****************************************************/
    //计划任务列表
    Route::get('schedule/list', 'sys.Schedule/lists');
    //任务详情
    Route::get('schedule/:id', 'sys.Schedule/info');
    //设置任务状态
    Route::put('schedule/modify/status/:id', 'sys.Schedule/modifyStatus');
    //任务新增
    Route::post('schedule', 'sys.Schedule/add');
    //编辑任务
    Route::put('schedule/:id', 'sys.Schedule/edit');
    //删除任务
    Route::delete('schedule/:id', 'sys.Schedule/del');
    //任务模式
    Route::get('schedule/type', 'sys.Schedule/getType');
    //任务模板
    Route::get('schedule/template', 'sys.Schedule/template');
    //任务时间间隔
    Route::get('schedule/datetype', 'sys.Schedule/getDateType');
    //执行一次任务
    Route::put('schedule/do/:id', 'sys.Schedule/doSchedule');
    //重置定时任务
    Route::post('schedule/reset', 'sys.Schedule/resetSchedule');

    //任务执行记录列表
    Route::get('schedule/log/list', 'sys.ScheduleLog/lists');
    //删除执行记录
    Route::put('schedule/log/delete', 'sys.ScheduleLog/del');
    //清空执行记录
    Route::put('schedule/log/clear', 'sys.ScheduleLog/clear');

    /***************************************************** 应用管理 ****************************************************/
    Route::get('applist', 'sys.App/getAppList');

    /***************************************************** 清理缓存-刷新菜单 ****************************************************/
    Route::post('schema/clear', 'sys.System/schemaCache');
    Route::post('cache/clear', 'sys.System/clearCache');

    /***************************************************** 公共字典数据 ****************************************************/
    Route::get('date/month', 'sys.Common/getMonth');
    Route::get('date/week', 'sys.Common/getWeek');
    /***************************************************** 百度编辑器 ****************************************************/
    // 获取百度编辑器配置
    Route::get('ueditor', 'sys.Ueditor/getConfig');
    // 百度编辑器文件上传
    Route::post('ueditor', 'sys.Ueditor/upload');



    // 检验是否开启imagick
    Route::get('check_imagick', 'sys.System/getImagickIsOpen');

})->middleware([
    AdminCheckToken::class,
    AdminCheckRole::class,
    AdminLog::class
]);

//系统环境（不效验登录状态）
Route::group('sys', function() {
    Route::get('web/website', 'sys.Config/getWebsite');
    // 获取版权信息
    Route::get('web/copyright', 'sys.Config/getCopyright');
    // 查询布局设置
    Route::get('web/layout', 'sys.Config/getLayout');
    // 获取install.php配置
    Route::get('install/config', 'sys.Config/getInstallConfig');
});
