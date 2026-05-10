# 积分商城增强 & 志愿者服务模块设计文档

## v2.0.0

---

## 一、项目概述

### 1.1 背景
基于 NIUCLOUD Lite AI 框架，对现有积分商城模块进行功能增强，并新增社区志愿者服务模块，构建完整的社区积分生态体系。

### 1.2 目标
- **积分商城增强**：支持代下单功能、线下自取模式
- **志愿者服务模块**：用户可用积分兑换技能志愿服务

---

## 二、功能模块

### 2.1 积分商城增强

#### 2.1.1 代下单功能
| 功能 | 说明 |
|------|------|
| 适用场景 | 客服/管理员帮不会操作的用户下单 |
| 操作流程 | 选择用户 → 选择商品 → 填写收货信息 → 创建订单 |
| 权限控制 | 仅管理员/客服角色可用 |
| 订单标记 | `order_type` 字段区分：1=自主下单，2=代下单 |

#### 2.1.2 自取功能
| 功能 | 说明 |
|------|------|
| 适用场景 | 线下门店自提、社区自提点 |
| 商品设置 | 支持开启/关闭自取，填写自取地址 |
| 订单状态 | 新增：4=待自取、5=已自取 |
| 核销方式 | 订单核销码（用户展示，管理员扫码核销） |

#### 2.1.3 修改的表结构

```sql
-- nc_point_goods 表新增字段
ALTER TABLE nc_point_goods ADD COLUMN support_pickup tinyint(1) DEFAULT 0 COMMENT '是否支持自取:0-否,1-是';
ALTER TABLE nc_point_goods ADD COLUMN pickup_address varchar(255) DEFAULT '' COMMENT '自取地址';

-- nc_point_order 表新增字段
ALTER TABLE nc_point_order ADD COLUMN order_type tinyint(1) DEFAULT 1 COMMENT '订单类型:1-自主下单,2-代下单';
ALTER TABLE nc_point_order ADD COLUMN buy_member_id int DEFAULT 0 COMMENT '代下单购买人ID';
ALTER TABLE nc_point_order ADD COLUMN buy_member_name varchar(50) DEFAULT '' COMMENT '代下单购买人名称';
ALTER TABLE nc_point_order ADD COLUMN pickup_code varchar(32) DEFAULT '' COMMENT '自取核销码';
ALTER TABLE nc_point_order ADD COLUMN pickup_time int DEFAULT 0 COMMENT '自取时间';
ALTER TABLE nc_point_order ADD COLUMN operate_id int DEFAULT 0 COMMENT '操作人ID(代下单/核销)';
ALTER TABLE nc_point_order ADD COLUMN operate_name varchar(50) DEFAULT '' COMMENT '操作人名称';
```

### 2.2 志愿者服务模块

#### 2.2.1 功能架构

```
志愿者服务模块
├── 服务分类管理（管理员）
├── 服务项目管理
│   ├── 模板服务（管理员预设）
│   └── 自定义服务（志愿者发布）
├── 志愿者认证
│   ├── 积分门槛（≥500积分）
│   └── 管理员审核
├── 服务预约
│   ├── 用户预约
│   ├── 志愿者确认
│   └── 服务完成
└── 服务评价
```

#### 2.2.2 服务分类
| 字段 | 类型 | 说明 |
|------|------|------|
| category_id | int | 分类ID |
| category_name | varchar(50) | 分类名称 |
| icon | varchar(255) | 分类图标 |
| sort | int | 排序 |
| is_show | tinyint | 是否显示 |

#### 2.2.3 服务项目
| 字段 | 类型 | 说明 |
|------|------|------|
| service_id | int | 服务ID |
| category_id | int | 分类ID |
| volunteer_id | int | 志愿者ID（0=平台模板） |
| service_name | varchar(200) | 服务名称 |
| service_cover | varchar(255) | 服务封面图 |
| service_images | json | 服务图片组 |
| service_desc | text | 服务描述 |
| point_price | int | 积分价格 |
| service_unit | varchar(20) | 服务单位（次/小时/天） |
| service_duration | int | 预计时长（分钟） |
| service_area | varchar(200) | 服务范围 |
| status | tinyint | 状态：0-待审核,1-已上架,2-已下架 |
| is_template | tinyint | 是否平台模板：0-否,1-是 |

#### 2.2.4 志愿者认证
| 字段 | 类型 | 说明 |
|------|------|------|
| volunteer_id | int | 志愿者ID |
| member_id | int | 会员ID |
| nickname | varchar(50) | 志愿者昵称 |
| avatar | varchar(255) | 头像 |
| phone | varchar(20) | 联系电话 |
| skills | json | 擅长技能 |
| intro | text | 个人简介 |
| point_threshold | int | 积分门槛（默认500） |
| status | tinyint | 状态：0-申请中,1-已认证,2-已拒绝 |
| apply_time | int | 申请时间 |
| audit_time | int | 审核时间 |
| audit_remark | varchar(255) | 审核备注 |

#### 2.2.5 服务订单
| 字段 | 类型 | 说明 |
|------|------|------|
| order_id | int | 订单ID |
| order_no | varchar(32) | 订单编号 |
| member_id | int | 预约用户ID |
| member_name | varchar(50) | 预约用户名称 |
| member_phone | varchar(20) | 预约用户电话 |
| service_id | int | 服务ID |
| volunteer_id | int | 志愿者ID |
| volunteer_name | varchar(50) | 志愿者名称 |
| point_num | int | 消耗积分 |
| service_time | int | 预约服务时间 |
| service_address | varchar(255) | 服务地址 |
| service_remark | varchar(500) | 服务备注 |
| status | tinyint | 状态：1-待确认,2-已确认,3-服务中,4-已完成,5-已取消,-1-已拒绝 |
| create_time | int | 创建时间 |
| finish_time | int | 完成时间 |

#### 2.2.6 服务评价
| 字段 | 类型 | 说明 |
|------|------|------|
| evaluation_id | int | 评价ID |
| order_id | int | 订单ID |
| member_id | int | 评价用户ID |
| volunteer_id | int | 被评价志愿者ID |
| score | tinyint | 评分（1-5） |
| content | text | 评价内容 |
| images | json | 评价图片 |
| reply | text | 志愿者回复 |
| reply_time | int | 回复时间 |

---

## 三、数据库设计

### 3.1 志愿者服务模块表结构

```sql
-- 服务分类表
CREATE TABLE `nc_volunteer_category` (
  `category_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '分类ID',
  `category_name` varchar(50) NOT NULL DEFAULT '' COMMENT '分类名称',
  `icon` varchar(255) NOT NULL DEFAULT '' COMMENT '分类图标',
  `sort` int(11) NOT NULL DEFAULT 0 COMMENT '排序',
  `is_show` tinyint(1) NOT NULL DEFAULT 1 COMMENT '是否显示',
  `create_time` int(11) NOT NULL DEFAULT 0 COMMENT '创建时间',
  PRIMARY KEY (`category_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='志愿者服务分类表';

-- 服务项目表
CREATE TABLE `nc_volunteer_service` (
  `service_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '服务ID',
  `category_id` int(11) NOT NULL DEFAULT 0 COMMENT '分类ID',
  `volunteer_id` int(11) NOT NULL DEFAULT 0 COMMENT '志愿者ID:0=平台模板',
  `service_name` varchar(200) NOT NULL DEFAULT '' COMMENT '服务名称',
  `service_cover` varchar(255) NOT NULL DEFAULT '' COMMENT '服务封面',
  `service_images` json DEFAULT NULL COMMENT '服务图片组',
  `service_desc` text COMMENT '服务描述',
  `point_price` int NOT NULL DEFAULT 0 COMMENT '积分价格',
  `service_unit` varchar(20) NOT NULL DEFAULT '次' COMMENT '服务单位',
  `service_duration` int NOT NULL DEFAULT 60 COMMENT '预计时长(分钟)',
  `service_area` varchar(200) NOT NULL DEFAULT '' COMMENT '服务范围',
  `status` tinyint(1) NOT NULL DEFAULT 0 COMMENT '状态:0-待审核,1-已上架,2-已下架',
  `is_template` tinyint(1) NOT NULL DEFAULT 0 COMMENT '是否平台模板',
  `create_time` int(11) NOT NULL DEFAULT 0 COMMENT '创建时间',
  `update_time` int(11) NOT NULL DEFAULT 0 COMMENT '更新时间',
  PRIMARY KEY (`service_id`),
  KEY `idx_category_id` (`category_id`),
  KEY `idx_volunteer_id` (`volunteer_id`),
  KEY `idx_status` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='志愿者服务项目表';

-- 志愿者申请表
CREATE TABLE `nc_volunteer` (
  `volunteer_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '志愿者ID',
  `member_id` int(11) NOT NULL DEFAULT 0 COMMENT '会员ID',
  `nickname` varchar(50) NOT NULL DEFAULT '' COMMENT '志愿者昵称',
  `avatar` varchar(255) NOT NULL DEFAULT '' COMMENT '头像',
  `phone` varchar(20) NOT NULL DEFAULT '' COMMENT '联系电话',
  `skills` json DEFAULT NULL COMMENT '擅长技能',
  `intro` text COMMENT '个人简介',
  `point_threshold` int NOT NULL DEFAULT 500 COMMENT '积分门槛',
  `status` tinyint(1) NOT NULL DEFAULT 0 COMMENT '状态:0-申请中,1-已认证,2-已拒绝',
  `apply_time` int(11) NOT NULL DEFAULT 0 COMMENT '申请时间',
  `audit_time` int(11) NOT NULL DEFAULT 0 COMMENT '审核时间',
  `audit_remark` varchar(255) NOT NULL DEFAULT '' COMMENT '审核备注',
  PRIMARY KEY (`volunteer_id`),
  KEY `idx_member_id` (`member_id`),
  KEY `idx_status` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='志愿者表';

-- 服务订单表
CREATE TABLE `nc_volunteer_order` (
  `order_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '订单ID',
  `order_no` varchar(32) NOT NULL DEFAULT '' COMMENT '订单编号',
  `member_id` int(11) NOT NULL DEFAULT 0 COMMENT '预约用户ID',
  `member_name` varchar(50) NOT NULL DEFAULT '' COMMENT '预约用户名称',
  `member_phone` varchar(20) NOT NULL DEFAULT '' COMMENT '预约用户电话',
  `service_id` int(11) NOT NULL DEFAULT 0 COMMENT '服务ID',
  `volunteer_id` int(11) NOT NULL DEFAULT 0 COMMENT '志愿者ID',
  `volunteer_name` varchar(50) NOT NULL DEFAULT '' COMMENT '志愿者名称',
  `point_num` int NOT NULL DEFAULT 0 COMMENT '消耗积分',
  `service_time` int NOT NULL DEFAULT 0 COMMENT '预约服务时间',
  `service_address` varchar(255) NOT NULL DEFAULT '' COMMENT '服务地址',
  `service_remark` varchar(500) NOT NULL DEFAULT '' COMMENT '服务备注',
  `status` tinyint(1) NOT NULL DEFAULT 1 COMMENT '状态',
  `create_time` int(11) NOT NULL DEFAULT 0 COMMENT '创建时间',
  `update_time` int(11) NOT NULL DEFAULT 0 COMMENT '更新时间',
  `finish_time` int(11) NOT NULL DEFAULT 0 COMMENT '完成时间',
  PRIMARY KEY (`order_id`),
  KEY `idx_order_no` (`order_no`),
  KEY `idx_member_id` (`member_id`),
  KEY `idx_volunteer_id` (`volunteer_id`),
  KEY `idx_status` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='志愿者服务订单表';

-- 服务评价表
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
```

### 3.2 初始分类数据

```sql
INSERT INTO nc_volunteer_category (category_name, icon, sort, is_show) VALUES
('家政服务', 'icon-jiashi', 100, 1),
('维修服务', 'icon-weixiu', 90, 1),
('陪诊陪护', 'icon-peizhen', 80, 1),
('代跑代办', 'icon-paodong', 70, 1),
('教育培训', 'icon-jiaoyu', 60, 1),
('其他服务', 'icon-qita', 50, 1);
```

### 3.3 模板服务数据

```sql
INSERT INTO nc_volunteer_service (category_id, volunteer_id, service_name, service_cover, service_desc, point_price, service_unit, service_duration, service_area, status, is_template) VALUES
(1, 0, '日常保洁2小时', '/static/images/volunteer/clean.jpg', '家庭日常保洁服务，包含客厅、卧室、厨房、卫生间清洁', 200, '次', 120, '市区内', 1, 1),
(1, 0, '深度清洁', '/static/images/volunteer/deep.jpg', '全屋深度清洁，包含窗帘、沙发、地毯清洁', 500, '次', 240, '市区内', 1, 1),
(2, 0, '水电维修', '/static/images/volunteer/repair.jpg', '家庭水电维修、更换灯泡、水龙头等服务', 100, '次', 60, '市区内', 1, 1),
(3, 0, '陪诊服务', '/static/images/volunteer/escort.jpg', '陪同就医、挂号、取药、排队等服务', 150, '次', 180, '市区医院', 1, 1),
(4, 0, '代取快递', '/static/images/volunteer/express.jpg', '帮忙代取快递、外卖等服务', 30, '次', 30, '社区内', 1, 1);
```

---

## 四、API 接口设计

### 4.1 积分商城增强

#### 管理端
| 方法 | 路径 | 说明 |
|------|------|------|
| POST | /adminapi/pointshop/order/agentCreate | 代下单 |
| POST | /adminapi/pointshop/order/pickup | 核销自取 |
| GET | /adminapi/pointshop/order/memberList | 用户列表（代下单用） |

#### 用户端
| 方法 | 路径 | 说明 |
|------|------|------|
| GET | /api/pointshop/goodsList | 商品列表（增加自取筛选） |
| GET | /api/pointshop/goodsDetail/:id | 商品详情（增加自取信息） |
| GET | /api/pointshop/order/pickupCode/:id | 获取自取码 |
| GET | /api/pointshop/order/myPickupList | 我的自取订单 |

### 4.2 志愿者服务模块

#### 管理端
| 方法 | 路径 | 说明 |
|------|------|------|
| GET | /adminapi/volunteer/category/lists | 分类列表 |
| POST | /adminapi/volunteer/category/add | 添加分类 |
| PUT | /adminapi/volunteer/category/edit/:id | 编辑分类 |
| DELETE | /adminapi/volunteer/category/del/:id | 删除分类 |
| GET | /adminapi/volunteer/service/lists | 服务列表 |
| POST | /adminapi/volunteer/service/add | 添加服务(模板) |
| PUT | /adminapi/volunteer/service/edit/:id | 编辑服务 |
| DELETE | /adminapi/volunteer/service/del/:id | 删除服务 |
| PUT | /adminapi/volunteer/service/audit/:id | 审核服务 |
| GET | /adminapi/volunteer/apply/lists | 志愿者申请列表 |
| PUT | /adminapi/volunteer/apply/audit/:id | 审核志愿者 |
| GET | /adminapi/volunteer/order/lists | 订单列表 |
| PUT | /adminapi/volunteer/order/updateStatus/:id | 更新订单状态 |
| GET | /adminapi/volunteer/evaluation/lists | 评价列表 |

#### 用户端
| 方法 | 路径 | 说明 |
|------|------|------|
| GET | /api/volunteer/index | 首页数据 |
| GET | /api/volunteer/category | 分类列表 |
| GET | /api/volunteer/service/lists | 服务列表 |
| GET | /api/volunteer/service/detail/:id | 服务详情 |
| GET | /api/volunteer/volunteer/profile/:id | 志愿者主页 |
| POST | /api/volunteer/apply | 申请成为志愿者 |
| GET | /api/volunteer/myVolunteer | 我的志愿者状态 |
| GET | /api/volunteer/myService | 我的发布服务 |
| POST | /api/volunteer/service/publish | 发布服务 |
| PUT | /api/volunteer/service/edit/:id | 编辑服务 |
| POST | /api/volunteer/order/create | 创建预约订单 |
| GET | /api/volunteer/order/lists | 我的预约订单 |
| PUT | /api/volunteer/order/cancel/:id | 取消订单 |
| PUT | /api/volunteer/order/confirm/:id | 志愿者确认订单 |
| PUT | /api/volunteer/order/start/:id | 开始服务 |
| PUT | /api/volunteer/order/finish/:id | 完成服务 |
| GET | /api/volunteer/evaluation/create/:id | 评价服务 |
| POST | /api/volunteer/evaluation/submit | 提交评价 |

---

## 五、订单流程

### 5.1 积分商城订单流程

```
自主下单:
用户选择商品 → 确认订单(快递/自取) → 支付积分 → 等待发货/自取 → 确认收货/自取

代下单:
管理员选择用户 → 选择商品 → 确认订单 → 创建订单 → 通知用户 → 等待发货/自取 → 核销/确认

自取流程:
生成核销码 → 用户到店出示核销码 → 管理员扫码核销 → 订单完成
```

### 5.2 志愿者服务订单流程

```
用户预约:
浏览服务 → 选择服务 → 填写预约信息 → 确认预约(扣积分) → 等待确认

志愿者处理:
收到预约 → 确认/拒绝 → 按时服务 → 完成服务

服务完成:
用户评价 → 志愿者回复 → 订单完成
```

---

## 六、权限设计

### 6.1 角色权限

| 角色 | 权限 |
|------|------|
| 管理员 | 全部权限 |
| 客服 | 代下单、核销自取、查看订单 |
| 志愿者 | 发布服务、接单、评价回复 |
| 普通用户 | 预约服务、评价 |

### 6.2 志愿者认证条件

1. 积分余额 ≥ 门槛值（默认500，可配置）
2. 管理员审核通过

---

## 七、积分体系

### 7.1 积分变动

| 类型 | 场景 | 积分变化 |
|------|------|---------|
| 消耗 | 积分商城兑换 | -N |
| 消耗 | 预约志愿者服务 | -N |
| 获得 | 取消订单退回 | +N |
| 获得 | 管理员调整 | ±N |

### 7.2 积分门槛配置

```php
// 后台可配置
'volunteer_point_threshold' => 500,  // 成为志愿者所需最低积分
```

---

## 八、前端页面

### 8.1 Web/H5 端

| 页面 | 路由 | 功能 |
|------|------|------|
| 积分商城首页 | /web/pointshop/ | 商城首页 |
| 商品详情 | /web/pointshop/detail/:id | 商品详情（含自取选项） |
| 我的订单 | /web/member/pointorder | 积分订单列表 |
| 志愿者首页 | /web/volunteer/ | 志愿者服务首页 |
| 服务详情 | /web/volunteer/detail/:id | 服务详情 |
| 预约服务 | /web/volunteer/book/:id | 预约服务 |
| 我的志愿者 | /web/volunteer/my | 我的志愿者状态/服务 |
| 服务评价 | /web/volunteer/evaluate/:id | 评价服务 |

### 8.2 Admin 管理端

| 页面 | 路由 | 功能 |
|------|------|------|
| 商品管理 | /pointshop/goods | 积分商品管理 |
| 订单管理 | /pointshop/order | 订单列表（含代下单入口） |
| 代下单 | /pointshop/agentorder | 代下单页面 |
| 志愿者管理 | /volunteer/apply | 志愿者申请审核 |
| 服务管理 | /volunteer/service | 服务项目管理 |
| 服务分类 | /volunteer/category | 服务分类管理 |
| 服务订单 | /volunteer/order | 服务订单管理 |
| 评价管理 | /volunteer/evaluation | 服务评价管理 |

---

## 九、性能优化

- Redis 缓存：分类列表、服务列表
- 分页加载：无限滚动分页
- 图片优化：懒加载、压缩
- 防重复提交：订单创建锁

---

## 十、待后续扩展

- 消息通知（订单状态变更通知）
- 积分任务（每日签到、分享获得积分）
- 积分排行榜
- 志愿者等级系统

---

## 文档信息

| 项目 | 说明 |
|------|------|
| 版本 | v2.0.0 |
| 日期 | 2024 |
| 状态 | 待开发 |
