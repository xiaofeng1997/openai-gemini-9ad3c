-- =============================================
-- 积分商城模块数据库脚本 v2.0
-- NIUCLOUD Lite AI
-- 包含: 积分商城增强 + 志愿者服务模块
-- =============================================

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- =============================================
-- 积分商城增强
-- =============================================

-- ----------------------------- 积分商品分类表 -----------------------------
DROP TABLE IF EXISTS `nc_point_category`;
CREATE TABLE `nc_point_category` (
  `category_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '分类ID',
  `category_name` varchar(50) NOT NULL DEFAULT '' COMMENT '分类名称',
  `parent_id` int(11) NOT NULL DEFAULT 0 COMMENT '上级分类ID',
  `image` varchar(255) NOT NULL DEFAULT '' COMMENT '分类图片',
  `sort` int(11) NOT NULL DEFAULT 0 COMMENT '排序',
  `is_show` tinyint(1) NOT NULL DEFAULT 1 COMMENT '是否显示:0-否,1-是',
  `create_time` int(11) NOT NULL DEFAULT 0 COMMENT '创建时间',
  `update_time` int(11) NOT NULL DEFAULT 0 COMMENT '更新时间',
  `delete_time` int(11) NOT NULL DEFAULT 0 COMMENT '删除时间',
  PRIMARY KEY (`category_id`),
  KEY `idx_parent_id` (`parent_id`),
  KEY `idx_is_show` (`is_show`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='积分商品分类表';

-- ----------------------------- 积分商品表 -----------------------------
DROP TABLE IF EXISTS `nc_point_goods`;
CREATE TABLE `nc_point_goods` (
  `goods_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '商品ID',
  `category_id` int(11) NOT NULL DEFAULT 0 COMMENT '商品分类ID',
  `goods_name` varchar(200) NOT NULL DEFAULT '' COMMENT '商品名称',
  `goods_image` varchar(255) NOT NULL DEFAULT '' COMMENT '商品主图',
  `goods_images` json DEFAULT NULL COMMENT '商品图片组',
  `point_price` int(11) NOT NULL DEFAULT 0 COMMENT '积分价格',
  `price` decimal(10,2) NOT NULL DEFAULT 0.00 COMMENT '市场价格',
  `stock` int(11) NOT NULL DEFAULT 0 COMMENT '库存',
  `sales_num` int(11) NOT NULL DEFAULT 0 COMMENT '销量',
  `limit_num` int(11) NOT NULL DEFAULT 0 COMMENT '限购数量 0不限购',
  `exchange_desc` varchar(500) NOT NULL DEFAULT '' COMMENT '兑换说明',
  `goods_content` text COMMENT '商品详情',
  `support_pickup` tinyint(1) NOT NULL DEFAULT 0 COMMENT '是否支持自取:0-否,1-是',
  `pickup_address` varchar(255) NOT NULL DEFAULT '' COMMENT '自取地址',
  `sort` int(11) NOT NULL DEFAULT 0 COMMENT '排序',
  `status` tinyint(1) NOT NULL DEFAULT 1 COMMENT '状态:0-下架,1-上架',
  `create_time` int(11) NOT NULL DEFAULT 0 COMMENT '创建时间',
  `update_time` int(11) NOT NULL DEFAULT 0 COMMENT '更新时间',
  `delete_time` int(11) NOT NULL DEFAULT 0 COMMENT '删除时间',
  PRIMARY KEY (`goods_id`),
  KEY `idx_category_id` (`category_id`),
  KEY `idx_status` (`status`),
  KEY `idx_point_price` (`point_price`),
  KEY `idx_stock` (`stock`),
  KEY `idx_support_pickup` (`support_pickup`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='积分商品表';

-- ----------------------------- 积分订单表 -----------------------------
DROP TABLE IF EXISTS `nc_point_order`;
CREATE TABLE `nc_point_order` (
  `order_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '订单ID',
  `order_no` varchar(32) NOT NULL DEFAULT '' COMMENT '订单编号',
  `member_id` int(11) NOT NULL DEFAULT 0 COMMENT '会员ID',
  `goods_id` int(11) NOT NULL DEFAULT 0 COMMENT '商品ID',
  `num` int(11) NOT NULL DEFAULT 1 COMMENT '兑换数量',
  `point_num` int(11) NOT NULL DEFAULT 0 COMMENT '消耗积分',
  `delivery_type` tinyint(1) NOT NULL DEFAULT 1 COMMENT '配送方式:1-快递,2-自取',
  `address` json DEFAULT NULL COMMENT '收货地址信息',
  `pickup_code` varchar(32) NOT NULL DEFAULT '' COMMENT '自取核销码',
  `pickup_time` int(11) NOT NULL DEFAULT 0 COMMENT '自取时间',
  `express_company` varchar(50) NOT NULL DEFAULT '' COMMENT '快递公司',
  `express_no` varchar(50) NOT NULL DEFAULT '' COMMENT '快递单号',
  `order_type` tinyint(1) NOT NULL DEFAULT 1 COMMENT '订单类型:1-自主下单,2-代下单',
  `buy_member_id` int(11) NOT NULL DEFAULT 0 COMMENT '代下单购买人ID',
  `buy_member_name` varchar(50) NOT NULL DEFAULT '' COMMENT '代下单购买人名称',
  `operate_id` int(11) NOT NULL DEFAULT 0 COMMENT '操作人ID',
  `operate_name` varchar(50) NOT NULL DEFAULT '' COMMENT '操作人名称',
  `status` tinyint(1) NOT NULL DEFAULT 1 COMMENT '状态:-1已取消,1待发货,2已发货,3已完成,4待自取,5已自取',
  `create_time` int(11) NOT NULL DEFAULT 0 COMMENT '创建时间',
  `update_time` int(11) NOT NULL DEFAULT 0 COMMENT '更新时间',
  `delivery_time` int(11) NOT NULL DEFAULT 0 COMMENT '发货时间',
  `finish_time` int(11) NOT NULL DEFAULT 0 COMMENT '完成时间',
  `delete_time` int(11) NOT NULL DEFAULT 0 COMMENT '删除时间',
  PRIMARY KEY (`order_id`),
  KEY `idx_order_no` (`order_no`),
  KEY `idx_member_id` (`member_id`),
  KEY `idx_goods_id` (`goods_id`),
  KEY `idx_status` (`status`),
  KEY `idx_create_time` (`create_time`),
  KEY `idx_order_type` (`order_type`),
  KEY `idx_pickup_code` (`pickup_code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='积分订单表';

-- =============================================
-- 志愿者服务模块
-- =============================================

-- ----------------------------- 志愿者服务分类表 -----------------------------
DROP TABLE IF EXISTS `nc_volunteer_category`;
CREATE TABLE `nc_volunteer_category` (
  `category_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '分类ID',
  `category_name` varchar(50) NOT NULL DEFAULT '' COMMENT '分类名称',
  `icon` varchar(255) NOT NULL DEFAULT '' COMMENT '分类图标',
  `sort` int(11) NOT NULL DEFAULT 0 COMMENT '排序',
  `is_show` tinyint(1) NOT NULL DEFAULT 1 COMMENT '是否显示:0-否,1-是',
  `create_time` int(11) NOT NULL DEFAULT 0 COMMENT '创建时间',
  `update_time` int(11) NOT NULL DEFAULT 0 COMMENT '更新时间',
  `delete_time` int(11) NOT NULL DEFAULT 0 COMMENT '删除时间',
  PRIMARY KEY (`category_id`),
  KEY `idx_is_show` (`is_show`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='志愿者服务分类表';

-- ----------------------------- 志愿者服务项目表 -----------------------------
DROP TABLE IF EXISTS `nc_volunteer_service`;
CREATE TABLE `nc_volunteer_service` (
  `service_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '服务ID',
  `category_id` int(11) NOT NULL DEFAULT 0 COMMENT '分类ID',
  `volunteer_id` int(11) NOT NULL DEFAULT 0 COMMENT '志愿者ID:0=平台模板',
  `service_name` varchar(200) NOT NULL DEFAULT '' COMMENT '服务名称',
  `service_cover` varchar(255) NOT NULL DEFAULT '' COMMENT '服务封面',
  `service_images` json DEFAULT NULL COMMENT '服务图片组',
  `service_desc` text COMMENT '服务描述',
  `point_price` int(11) NOT NULL DEFAULT 0 COMMENT '积分价格',
  `service_unit` varchar(20) NOT NULL DEFAULT '次' COMMENT '服务单位',
  `service_duration` int(11) NOT NULL DEFAULT 60 COMMENT '预计时长(分钟)',
  `service_area` varchar(200) NOT NULL DEFAULT '' COMMENT '服务范围',
  `status` tinyint(1) NOT NULL DEFAULT 0 COMMENT '状态:0-待审核,1-已上架,2-已下架',
  `is_template` tinyint(1) NOT NULL DEFAULT 0 COMMENT '是否平台模板:0-否,1-是',
  `create_time` int(11) NOT NULL DEFAULT 0 COMMENT '创建时间',
  `update_time` int(11) NOT NULL DEFAULT 0 COMMENT '更新时间',
  `delete_time` int(11) NOT NULL DEFAULT 0 COMMENT '删除时间',
  PRIMARY KEY (`service_id`),
  KEY `idx_category_id` (`category_id`),
  KEY `idx_volunteer_id` (`volunteer_id`),
  KEY `idx_status` (`status`),
  KEY `idx_is_template` (`is_template`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='志愿者服务项目表';

-- ----------------------------- 志愿者表 -----------------------------
DROP TABLE IF EXISTS `nc_volunteer`;
CREATE TABLE `nc_volunteer` (
  `volunteer_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '志愿者ID',
  `member_id` int(11) NOT NULL DEFAULT 0 COMMENT '会员ID',
  `nickname` varchar(50) NOT NULL DEFAULT '' COMMENT '志愿者昵称',
  `avatar` varchar(255) NOT NULL DEFAULT '' COMMENT '头像',
  `phone` varchar(20) NOT NULL DEFAULT '' COMMENT '联系电话',
  `skills` json DEFAULT NULL COMMENT '擅长技能',
  `intro` text COMMENT '个人简介',
  `point_threshold` int(11) NOT NULL DEFAULT 500 COMMENT '积分门槛',
  `status` tinyint(1) NOT NULL DEFAULT 0 COMMENT '状态:0-申请中,1-已认证,2-已拒绝',
  `apply_time` int(11) NOT NULL DEFAULT 0 COMMENT '申请时间',
  `audit_time` int(11) NOT NULL DEFAULT 0 COMMENT '审核时间',
  `audit_remark` varchar(255) NOT NULL DEFAULT '' COMMENT '审核备注',
  `create_time` int(11) NOT NULL DEFAULT 0 COMMENT '创建时间',
  `update_time` int(11) NOT NULL DEFAULT 0 COMMENT '更新时间',
  PRIMARY KEY (`volunteer_id`),
  KEY `idx_member_id` (`member_id`),
  KEY `idx_status` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='志愿者表';

-- ----------------------------- 志愿者服务订单表 -----------------------------
DROP TABLE IF EXISTS `nc_volunteer_order`;
CREATE TABLE `nc_volunteer_order` (
  `order_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '订单ID',
  `order_no` varchar(32) NOT NULL DEFAULT '' COMMENT '订单编号',
  `member_id` int(11) NOT NULL DEFAULT 0 COMMENT '预约用户ID',
  `member_name` varchar(50) NOT NULL DEFAULT '' COMMENT '预约用户名称',
  `member_phone` varchar(20) NOT NULL DEFAULT '' COMMENT '预约用户电话',
  `service_id` int(11) NOT NULL DEFAULT 0 COMMENT '服务ID',
  `volunteer_id` int(11) NOT NULL DEFAULT 0 COMMENT '志愿者ID',
  `volunteer_name` varchar(50) NOT NULL DEFAULT '' COMMENT '志愿者名称',
  `point_num` int(11) NOT NULL DEFAULT 0 COMMENT '消耗积分',
  `service_time` int(11) NOT NULL DEFAULT 0 COMMENT '预约服务时间',
  `service_address` varchar(255) NOT NULL DEFAULT '' COMMENT '服务地址',
  `service_remark` varchar(500) NOT NULL DEFAULT '' COMMENT '服务备注',
  `status` tinyint(1) NOT NULL DEFAULT 1 COMMENT '状态:1-待确认,2-已确认,3-服务中,4-已完成,5-已取消,-1-已拒绝',
  `create_time` int(11) NOT NULL DEFAULT 0 COMMENT '创建时间',
  `update_time` int(11) NOT NULL DEFAULT 0 COMMENT '更新时间',
  `finish_time` int(11) NOT NULL DEFAULT 0 COMMENT '完成时间',
  `delete_time` int(11) NOT NULL DEFAULT 0 COMMENT '删除时间',
  PRIMARY KEY (`order_id`),
  KEY `idx_order_no` (`order_no`),
  KEY `idx_member_id` (`member_id`),
  KEY `idx_volunteer_id` (`volunteer_id`),
  KEY `idx_status` (`status`),
  KEY `idx_service_time` (`service_time`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='志愿者服务订单表';

-- ----------------------------- 志愿者服务评价表 -----------------------------
DROP TABLE IF EXISTS `nc_volunteer_evaluation`;
CREATE TABLE `nc_volunteer_evaluation` (
  `evaluation_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '评价ID',
  `order_id` int(11) NOT NULL DEFAULT 0 COMMENT '订单ID',
  `member_id` int(11) NOT NULL DEFAULT 0 COMMENT '评价用户ID',
  `volunteer_id` int(11) NOT NULL DEFAULT 0 COMMENT '被评价志愿者ID',
  `score` tinyint(1) NOT NULL DEFAULT 5 COMMENT '评分(1-5)',
  `content` text COMMENT '评价内容',
  `images` json DEFAULT NULL COMMENT '评价图片',
  `reply` text COMMENT '志愿者回复',
  `reply_time` int(11) NOT NULL DEFAULT 0 COMMENT '回复时间',
  `create_time` int(11) NOT NULL DEFAULT 0 COMMENT '创建时间',
  PRIMARY KEY (`evaluation_id`),
  KEY `idx_order_id` (`order_id`),
  KEY `idx_volunteer_id` (`volunteer_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='志愿者服务评价表';

-- =============================================
-- 初始数据
-- =============================================

-- 积分商品分类
INSERT INTO `nc_point_category` (`category_name`, `parent_id`, `image`, `sort`, `is_show`, `create_time`, `update_time`) VALUES
('数码电子', 0, '', 100, 1, UNIX_TIMESTAMP(), UNIX_TIMESTAMP()),
('生活用品', 0, '', 90, 1, UNIX_TIMESTAMP(), UNIX_TIMESTAMP()),
('服饰配件', 0, '', 80, 1, UNIX_TIMESTAMP(), UNIX_TIMESTAMP()),
('美食饮品', 0, '', 70, 1, UNIX_TIMESTAMP(), UNIX_TIMESTAMP()),
('图书音像', 0, '', 60, 1, UNIX_TIMESTAMP(), UNIX_TIMESTAMP());

-- 积分商品
INSERT INTO `nc_point_goods` (`category_id`, `goods_name`, `goods_image`, `goods_images`, `point_price`, `price`, `stock`, `sales_num`, `limit_num`, `exchange_desc`, `support_pickup`, `pickup_address`, `sort`, `status`, `create_time`, `update_time`) VALUES
(1, '无线蓝牙耳机', '/static/images/pointshop/headphones.jpg', '[]', 500, 199.00, 100, 0, 1, '全新正品，支持7天无理由退货', 1, '社区服务中心', 100, 1, UNIX_TIMESTAMP(), UNIX_TIMESTAMP()),
(2, '智能手环', '/static/images/pointshop/bracelet.jpg', '[]', 300, 129.00, 200, 0, 2, '支持心率监测、计步功能', 1, '社区服务中心', 90, 1, UNIX_TIMESTAMP(), UNIX_TIMESTAMP()),
(2, '便携充电宝', '/static/images/pointshop/powerbank.jpg', '[]', 200, 89.00, 500, 0, 0, '10000mAh大容量，便携小巧', 0, '', 80, 1, UNIX_TIMESTAMP(), UNIX_TIMESTAMP()),
(3, '时尚背包', '/static/images/pointshop/backpack.jpg', '[]', 800, 299.00, 50, 0, 1, '优质面料，大容量设计', 1, '社区服务中心', 70, 1, UNIX_TIMESTAMP(), UNIX_TIMESTAMP()),
(4, '精选零食大礼包', '/static/images/pointshop/snacks.jpg', '[]', 150, 69.00, 300, 0, 0, '多种口味组合，满足不同需求', 1, '社区便利店', 60, 1, UNIX_TIMESTAMP(), UNIX_TIMESTAMP());

-- 志愿者服务分类
INSERT INTO `nc_volunteer_category` (`category_name`, `icon`, `sort`, `is_show`, `create_time`, `update_time`) VALUES
('家政服务', 'icon-jiashi', 100, 1, UNIX_TIMESTAMP(), UNIX_TIMESTAMP()),
('维修服务', 'icon-weixiu', 90, 1, UNIX_TIMESTAMP(), UNIX_TIMESTAMP()),
('陪诊陪护', 'icon-peizhen', 80, 1, UNIX_TIMESTAMP(), UNIX_TIMESTAMP()),
('代跑代办', 'icon-paodong', 70, 1, UNIX_TIMESTAMP(), UNIX_TIMESTAMP()),
('教育培训', 'icon-jiaoyu', 60, 1, UNIX_TIMESTAMP(), UNIX_TIMESTAMP()),
('其他服务', 'icon-qita', 50, 1, UNIX_TIMESTAMP(), UNIX_TIMESTAMP());

-- 模板服务
INSERT INTO `nc_volunteer_service` (`category_id`, `volunteer_id`, `service_name`, `service_cover`, `service_desc`, `point_price`, `service_unit`, `service_duration`, `service_area`, `status`, `is_template`, `create_time`, `update_time`) VALUES
(1, 0, '日常保洁2小时', '/static/images/volunteer/clean.jpg', '家庭日常保洁服务，包含客厅、卧室、厨房、卫生间清洁', 200, '次', 120, '市区内', 1, 1, UNIX_TIMESTAMP(), UNIX_TIMESTAMP()),
(1, 0, '深度清洁', '/static/images/volunteer/deep.jpg', '全屋深度清洁，包含窗帘、沙发、地毯清洁', 500, '次', 240, '市区内', 1, 1, UNIX_TIMESTAMP(), UNIX_TIMESTAMP()),
(2, 0, '水电维修', '/static/images/volunteer/repair.jpg', '家庭水电维修、更换灯泡、水龙头等服务', 100, '次', 60, '市区内', 1, 1, UNIX_TIMESTAMP(), UNIX_TIMESTAMP()),
(3, 0, '陪诊服务', '/static/images/volunteer/escort.jpg', '陪同就医、挂号、取药、排队等服务', 150, '次', 180, '市区医院', 1, 1, UNIX_TIMESTAMP(), UNIX_TIMESTAMP()),
(4, 0, '代取快递', '/static/images/volunteer/express.jpg', '帮忙代取快递、外卖等服务', 30, '次', 30, '社区内', 1, 1, UNIX_TIMESTAMP(), UNIX_TIMESTAMP()),
(4, 0, '代买菜', '/static/images/volunteer/shopping.jpg', '帮忙代买蔬菜水果、日用品', 50, '次', 60, '社区周边2公里', 1, 1, UNIX_TIMESTAMP(), UNIX_TIMESTAMP()),
(5, 0, '功课辅导', '/static/images/volunteer/study.jpg', '中小学生功课辅导', 100, '小时', 60, '可上门', 1, 1, UNIX_TIMESTAMP(), UNIX_TIMESTAMP());

SET FOREIGN_KEY_CHECKS = 1;
