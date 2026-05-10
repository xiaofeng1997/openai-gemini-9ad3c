-- =============================================
-- 积分商城模块菜单配置
-- NIUCLOUD Lite AI
-- =============================================

-- ----------------------------- 积分商城菜单 -----------------------------
INSERT INTO `nc_sys_menu` (`menu_name`, `menu_key`, `parent_key`, `menu_type`, `icon`, `api_url`, `component`, `view_path`, `sort`, `is_show`, `status`, `create_time`, `update_time`) VALUES
('积分商城', 'pointshop', '', 0, 'iconfont iconjifen-xianxing', '', '', '', 80, 1, 1, UNIX_TIMESTAMP(), UNIX_TIMESTAMP());

-- 获取刚插入的菜单ID
SET @parent_id = LAST_INSERT_ID();

-- 商品管理菜单
INSERT INTO `nc_sys_menu` (`menu_name`, `menu_key`, `parent_key`, `menu_type`, `icon`, `api_url`, `component`, `view_path`, `sort`, `is_show`, `status`, `create_time`, `update_time`) VALUES
('商品管理', 'pointshop_goods', 'pointshop', 0, 'iconfont icongoods', '', '', '', 100, 1, 1, UNIX_TIMESTAMP(), UNIX_TIMESTAMP());

SET @goods_id = LAST_INSERT_ID();

INSERT INTO `nc_sys_menu` (`menu_name`, `menu_key`, `parent_key`, `menu_type`, `icon`, `api_url`, `view_path`, `component`, `request_method`, `sort`, `is_show`, `status`, `create_time`, `update_time`) VALUES
('商品列表', 'pointshop_goods_list', 'pointshop_goods', 1, '', 'pointshop/goods/lists', 'pointshop/goods/list', '', 'GET', 100, 1, 1, UNIX_TIMESTAMP(), UNIX_TIMESTAMP()),
('添加商品', 'pointshop_goods_add', 'pointshop_goods', 2, '', 'pointshop/goods/add', '', '', 'POST', 90, 1, 1, UNIX_TIMESTAMP(), UNIX_TIMESTAMP()),
('编辑商品', 'pointshop_goods_edit', 'pointshop_goods', 2, '', 'pointshop/goods/edit/:goods_id', '', '', 'PUT', 80, 1, 1, UNIX_TIMESTAMP(), UNIX_TIMESTAMP()),
('删除商品', 'pointshop_goods_del', 'pointshop_goods', 2, '', 'pointshop/goods/del/:goods_id', '', '', 'DELETE', 70, 1, 1, UNIX_TIMESTAMP(), UNIX_TIMESTAMP()),
('设置状态', 'pointshop_goods_status', 'pointshop_goods', 2, '', 'pointshop/goods/setStatus', '', '', 'PUT', 60, 1, 1, UNIX_TIMESTAMP(), UNIX_TIMESTAMP());

-- 分类管理菜单
INSERT INTO `nc_sys_menu` (`menu_name`, `menu_key`, `parent_key`, `menu_type`, `icon`, `api_url`, `component`, `view_path`, `sort`, `is_show`, `status`, `create_time`, `update_time`) VALUES
('分类管理', 'pointshop_category', 'pointshop', 0, 'iconfont iconfenlei', '', '', '', 90, 1, 1, UNIX_TIMESTAMP(), UNIX_TIMESTAMP());

SET @category_id = LAST_INSERT_ID();

INSERT INTO `nc_sys_menu` (`menu_name`, `menu_key`, `parent_key`, `menu_type`, `icon`, `api_url`, `view_path`, `component`, `request_method`, `sort`, `is_show`, `status`, `create_time`, `update_time`) VALUES
('分类列表', 'pointshop_category_list', 'pointshop_category', 1, '', 'pointshop/category/lists', '', '', 'GET', 100, 1, 1, UNIX_TIMESTAMP(), UNIX_TIMESTAMP()),
('添加分类', 'pointshop_category_add', 'pointshop_category', 2, '', 'pointshop/category/add', '', '', 'POST', 90, 1, 1, UNIX_TIMESTAMP(), UNIX_TIMESTAMP()),
('编辑分类', 'pointshop_category_edit', 'pointshop_category', 2, '', 'pointshop/category/edit/:category_id', '', '', 'PUT', 80, 1, 1, UNIX_TIMESTAMP(), UNIX_TIMESTAMP()),
('删除分类', 'pointshop_category_del', 'pointshop_category', 2, '', 'pointshop/category/del/:category_id', '', '', 'DELETE', 70, 1, 1, UNIX_TIMESTAMP(), UNIX_TIMESTAMP());

-- 订单管理菜单
INSERT INTO `nc_sys_menu` (`menu_name`, `menu_key`, `parent_key`, `menu_type`, `icon`, `api_url`, `component`, `view_path`, `sort`, `is_show`, `status`, `create_time`, `update_time`) VALUES
('订单管理', 'pointshop_order', 'pointshop', 0, 'iconfont icondingdan', '', '', '', 80, 1, 1, UNIX_TIMESTAMP(), UNIX_TIMESTAMP());

SET @order_id = LAST_INSERT_ID();

INSERT INTO `nc_sys_menu` (`menu_name`, `menu_key`, `parent_key`, `menu_type`, `icon`, `api_url`, `view_path`, `component`, `request_method`, `sort`, `is_show`, `status`, `create_time`, `update_time`) VALUES
('订单列表', 'pointshop_order_list', 'pointshop_order', 1, '', 'pointshop/order/lists', 'pointshop/order/list', '', 'GET', 100, 1, 1, UNIX_TIMESTAMP(), UNIX_TIMESTAMP()),
('订单发货', 'pointshop_order_deliver', 'pointshop_order', 2, '', 'pointshop/order/deliver', '', '', 'POST', 90, 1, 1, UNIX_TIMESTAMP(), UNIX_TIMESTAMP());
