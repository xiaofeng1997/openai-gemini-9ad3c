-- =============================================
-- 积分商城模块数据库脚本
-- NIUCLOUD Lite AI
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
  `sort` int(11) NOT NULL DEFAULT 0 COMMENT '排序',
  `status` tinyint(1) NOT NULL DEFAULT 1 COMMENT '状态:0-下架,1-上架',
  `create_time` int(11) NOT NULL DEFAULT 0 COMMENT '创建时间',
  `update_time` int(11) NOT NULL DEFAULT 0 COMMENT '更新时间',
  `delete_time` int(11) NOT NULL DEFAULT 0 COMMENT '删除时间',
  PRIMARY KEY (`goods_id`),
  KEY `idx_category_id` (`category_id`),
  KEY `idx_status` (`status`),
  KEY `idx_point_price` (`point_price`)
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
  `address` json DEFAULT NULL COMMENT '收货地址信息',
  `express_company` varchar(50) NOT NULL DEFAULT '' COMMENT '快递公司',
  `express_no` varchar(50) NOT NULL DEFAULT '' COMMENT '快递单号',
  `status` tinyint(1) NOT NULL DEFAULT 1 COMMENT '状态:-1已取消,1待发货,2已发货,3已完成',
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
  KEY `idx_create_time` (`create_time`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='积分订单表';

-- ----------------------------- 初始分类数据 -----------------------------
INSERT INTO `nc_point_category` (`category_id`, `category_name`, `parent_id`, `image`, `sort`, `is_show`, `create_time`, `update_time`) VALUES
(1, '数码电子', 0, '', 100, 1, UNIX_TIMESTAMP(), UNIX_TIMESTAMP()),
(2, '生活用品', 0, '', 90, 1, UNIX_TIMESTAMP(), UNIX_TIMESTAMP()),
(3, '服饰配件', 0, '', 80, 1, UNIX_TIMESTAMP(), UNIX_TIMESTAMP()),
(4, '美食饮品', 0, '', 70, 1, UNIX_TIMESTAMP(), UNIX_TIMESTAMP()),
(5, '图书音像', 0, '', 60, 1, UNIX_TIMESTAMP(), UNIX_TIMESTAMP());

-- ----------------------------- 初始商品数据 -----------------------------
INSERT INTO `nc_point_goods` (`category_id`, `goods_name`, `goods_image`, `goods_images`, `point_price`, `price`, `stock`, `sales_num`, `limit_num`, `exchange_desc`, `sort`, `status`, `create_time`, `update_time`) VALUES
(1, '无线蓝牙耳机', '/static/images/pointshop/headphones.jpg', '[]', 500, 199.00, 100, 0, 1, '全新正品，支持7天无理由退货', 100, 1, UNIX_TIMESTAMP(), UNIX_TIMESTAMP()),
(2, '智能手环', '/static/images/pointshop/bracelet.jpg', '[]', 300, 129.00, 200, 0, 2, '支持心率监测、计步功能', 90, 1, UNIX_TIMESTAMP(), UNIX_TIMESTAMP()),
(2, '便携充电宝', '/static/images/pointshop/powerbank.jpg', '[]', 200, 89.00, 500, 0, 0, '10000mAh大容量，便携小巧', 80, 1, UNIX_TIMESTAMP(), UNIX_TIMESTAMP()),
(3, '时尚背包', '/static/images/pointshop/backpack.jpg', '[]', 800, 299.00, 50, 0, 1, '优质面料，大容量设计', 70, 1, UNIX_TIMESTAMP(), UNIX_TIMESTAMP()),
(4, '精选零食大礼包', '/static/images/pointshop/snacks.jpg', '[]', 150, 69.00, 300, 0, 0, '多种口味组合，满足不同需求', 60, 1, UNIX_TIMESTAMP(), UNIX_TIMESTAMP());
