# 积分商城模块 (niucloud-pointshop)

## 概述

积分商城模块是 NIUCLOUD Lite AI 的核心功能模块之一，提供完整的积分商品兑换功能。用户可以通过积分兑换商品，管理员可以管理商品、分类和订单。

## 功能特性

- 商品管理：商品的增删改查、上下架、排序
- 分类管理：支持多级商品分类
- 订单管理：订单列表、发货、取消、确认收货
- 积分兑换：用户使用积分兑换商品
- 库存管理：自动扣减库存
- 订单状态：待发货→已发货→已完成

## 技能结构

```
niucloud-pointshop/
├── backend/                    # 后端代码
│   ├── controller/            # 控制器
│   │   ├── adminapi/          # 管理端控制器
│   │   │   ├── PointGoods.php
│   │   │   ├── PointCategory.php
│   │   │   └── PointOrder.php
│   │   └── api/              # API端控制器
│   │       └── Pointshop.php
│   ├── service/               # 服务层
│   │   ├── admin/             # 管理端服务
│   │   │   ├── PointGoodsService.php
│   │   │   ├── PointCategoryService.php
│   │   │   └── PointOrderService.php
│   │   └── api/               # API端服务
│   │       ├── PointGoodsService.php
│   │       └── PointOrderService.php
│   ├── model/                 # 数据模型
│   │   ├── pointshop/
│   │   │   ├── PointGoods.php
│   │   │   ├── PointCategory.php
│   │   │   └── PointOrder.php
│   │   └── api/pointshop/
│   ├── validate/              # 验证器
│   │   ├── pointshop/
│   │   │   ├── PointGoods.php
│   │   │   ├── PointCategory.php
│   │   │   └── PointOrder.php
│   │   └── api/
│   │       └── Pointshop.php
│   └── route/                 # 路由
│       ├── adminapi/pointshop.php
│       └── api/pointshop.php
├── frontend/                  # 前端代码
│   ├── admin/                 # 后台管理
│   │   ├── src/
│   │   │   ├── api/
│   │   │   │   └── pointshop.ts
│   │   │   ├── lang/          # 语言包
│   │   │   │   └── zh-cn/
│   │   │   │       └── pointshop.json
│   │   │   └── views/
│   │   │       └── pointshop/
│   │   │           ├── goods/  # 商品管理
│   │   │           └── order/  # 订单管理
│   ├── uni-app/               # 移动端
│   │   └── src/
│   │       ├── api/
│   │       │   └── pointshop.ts
│   │       └── pages/
│   │           └── pointshop/
│   │               ├── index.vue
│   │               ├── detail.vue
│   │               ├── order-list.vue
│   │               └── order-detail.vue
│   └── web/                   # 前端网站
│       └── src/
│           ├── api/
│           │   └── pointshop.ts
│           └── pages/
│               └── pointshop/
├── doc/                       # 文档
│   └── sql/
│       ├── pointshop.sql      # 数据库表结构
│       └── pointshop_menu.sql # 菜单配置
└── SKILL.md                   # 本文件
```

## 数据库表结构

### nc_point_category (积分商品分类表)

| 字段 | 类型 | 说明 |
|------|------|------|
| category_id | int | 分类ID |
| category_name | varchar(50) | 分类名称 |
| parent_id | int | 上级分类ID |
| image | varchar(255) | 分类图片 |
| sort | int | 排序 |
| is_show | tinyint | 是否显示 |
| create_time | int | 创建时间 |
| update_time | int | 更新时间 |

### nc_point_goods (积分商品表)

| 字段 | 类型 | 说明 |
|------|------|------|
| goods_id | int | 商品ID |
| category_id | int | 分类ID |
| goods_name | varchar(200) | 商品名称 |
| goods_image | varchar(255) | 商品主图 |
| goods_images | json | 商品图片组 |
| point_price | int | 积分价格 |
| price | decimal | 市场价格 |
| stock | int | 库存 |
| sales_num | int | 销量 |
| limit_num | int | 限购数量 |
| exchange_desc | varchar(500) | 兑换说明 |
| goods_content | text | 商品详情 |
| sort | int | 排序 |
| status | tinyint | 状态 |
| create_time | int | 创建时间 |
| update_time | int | 更新时间 |

### nc_point_order (积分订单表)

| 字段 | 类型 | 说明 |
|------|------|------|
| order_id | int | 订单ID |
| order_no | varchar(32) | 订单编号 |
| member_id | int | 会员ID |
| goods_id | int | 商品ID |
| num | int | 兑换数量 |
| point_num | int | 消耗积分 |
| address | json | 收货地址信息 |
| express_company | varchar(50) | 快递公司 |
| express_no | varchar(50) | 快递单号 |
| status | tinyint | 状态 |
| create_time | int | 创建时间 |
| update_time | int | 更新时间 |
| delivery_time | int | 发货时间 |
| finish_time | int | 完成时间 |

## 订单状态

| 状态值 | 说明 |
|--------|------|
| -1 | 已取消 |
| 1 | 待发货 |
| 2 | 已发货 |
| 3 | 已完成 |

## API接口

### 管理端接口

#### 商品管理

- `GET /adminapi/pointshop/goods/lists` - 商品列表
- `GET /adminapi/pointshop/goods/info/:goods_id` - 商品详情
- `POST /adminapi/pointshop/goods/add` - 添加商品
- `PUT /adminapi/pointshop/goods/edit/:goods_id` - 编辑商品
- `DELETE /adminapi/pointshop/goods/del/:goods_id` - 删除商品
- `PUT /adminapi/pointshop/goods/setStatus` - 设置状态
- `GET /adminapi/pointshop/goods/getCategory` - 获取分类

#### 分类管理

- `GET /adminapi/pointshop/category/lists` - 分类列表
- `GET /adminapi/pointshop/category/info/:category_id` - 分类详情
- `POST /adminapi/pointshop/category/add` - 添加分类
- `PUT /adminapi/pointshop/category/edit/:category_id` - 编辑分类
- `DELETE /adminapi/pointshop/category/del/:category_id` - 删除分类

#### 订单管理

- `GET /adminapi/pointshop/order/lists` - 订单列表
- `GET /adminapi/pointshop/order/info/:order_id` - 订单详情
- `POST /adminapi/pointshop/order/deliver` - 订单发货
- `GET /adminapi/pointshop/order/getStatusList` - 订单状态列表

### API端接口

- `GET /api/pointshop/index` - 商城首页数据
- `GET /api/pointshop/goods/list` - 商品列表
- `GET /api/pointshop/goods/detail/:goods_id` - 商品详情
- `POST /api/pointshop/exchange` - 积分兑换
- `GET /api/pointshop/order/list` - 订单列表
- `GET /api/pointshop/order/detail/:order_id` - 订单详情
- `PUT /api/pointshop/order/cancel/:order_id` - 取消订单
- `PUT /api/pointshop/order/confirm/:order_id` - 确认收货

## 安装步骤

### 1. 执行数据库脚本

```sql
-- 创建数据表
source doc/sql/pointshop.sql

-- 创建菜单
source doc/sql/pointshop_menu.sql
```

### 2. 复制后端代码

将 `backend/` 目录下的所有文件复制到项目的 `backend/` 目录。

### 3. 复制前端代码

将 `frontend/` 目录下的所有文件复制到项目的对应前端目录。

### 4. 配置路由

确保后端路由文件已加载：
- 管理端：`backend/app/adminapi/route/pointshop.php`
- API端：`backend/app/api/route/pointshop.php`

## 使用说明

### 管理员操作

1. 登录后台管理系统
2. 进入「积分商城」菜单
3. 先添加商品分类
4. 再添加积分商品
5. 管理订单并发货

### 用户操作

1. 进入积分商城首页
2. 浏览商品列表
3. 点击商品查看详情
4. 使用积分兑换商品
5. 查看订单状态

## 注意事项

1. 兑换时会自动扣减用户积分
2. 兑换时会自动扣减商品库存
3. 取消订单会自动退回积分和库存
4. 订单发货后用户可确认收货

## 开发扩展

### 添加新的商品字段

1. 在 `nc_point_goods` 表添加字段
2. 修改 `PointGoods` 模型
3. 修改 `PointGoodsService` 服务
4. 修改前端表单组件

### 添加新的订单状态

1. 修改 `PointOrder` 模型常量
2. 修改前端页面显示逻辑

### 添加积分变动类型

1. 在会员积分账户服务中注册变动类型
2. 前端展示相应的变动说明
