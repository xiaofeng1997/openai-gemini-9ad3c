# 积分商城模块 (niucloud-pointshop)

## 概述

积分商城模块是 NIUCLOUD Lite AI 的核心功能模块之一，基于框架的 Skills 模块化规范开发，提供完整的积分商品兑换功能。

## 特性

- 遵循框架 Skills 模块化开发规范
- 支持 Web 端和 H5 端
- 完善的权限控制和 API 认证
- Redis 缓存优化性能
- 防重复提交机制
- 完整的订单状态流转

## 目录结构

```
niucloud-pointshop/
├── backend/                          # 后端代码
│   ├── adminapi/
│   │   ├── controller/pointshop/   # 管理端控制器
│   │   └── route/pointshop.php     # 管理端路由
│   ├── api/
│   │   ├── controller/pointshop/    # API端控制器
│   │   └── route/pointshop.php     # API端路由
│   ├── model/pointshop/            # 数据模型
│   ├── service/
│   │   ├── admin/pointshop/        # 管理端服务
│   │   └── api/pointshop/          # API端服务
│   └── validate/pointshop/          # 验证器
├── frontend/
│   ├── admin/                      # 后台管理
│   │   └── src/
│   │       ├── api/pointshop.ts    # API接口
│   │       └── views/pointshop/    # 视图文件
│   └── web/                        # 前端网站 (Web + H5)
│       ├── api/pointshop.ts        # API接口
│       └── pages/pointshop/        # 页面文件
├── doc/
│   └── sql/pointshop.sql           # 数据库脚本
└── SKILL.md                        # 本文档
```

## 数据库

### 表结构

| 表名 | 说明 |
|------|------|
| nc_point_category | 积分商品分类表 |
| nc_point_goods | 积分商品表 |
| nc_point_order | 积分订单表 |

### 字段说明

#### nc_point_goods

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
| status | tinyint | 状态:0下架,1上架 |

#### nc_point_order

| 字段 | 类型 | 说明 |
|------|------|------|
| order_id | int | 订单ID |
| order_no | varchar(32) | 订单编号 |
| member_id | int | 会员ID |
| goods_id | int | 商品ID |
| num | int | 兑换数量 |
| point_num | int | 消耗积分 |
| address | json | 收货地址 |
| express_company | varchar(50) | 快递公司 |
| express_no | varchar(50) | 快递单号 |
| status | tinyint | 状态 |

### 订单状态

| 状态值 | 说明 |
|--------|------|
| -1 | 已取消 |
| 1 | 待发货 |
| 2 | 已发货 |
| 3 | 已完成 |

## API 接口

### 管理端 API

| 方法 | 路径 | 说明 |
|------|------|------|
| GET | /adminapi/pointshop/goods/lists | 商品列表 |
| GET | /adminapi/pointshop/goods/info/:id | 商品详情 |
| POST | /adminapi/pointshop/goods/add | 添加商品 |
| PUT | /adminapi/pointshop/goods/edit/:id | 编辑商品 |
| DELETE | /adminapi/pointshop/goods/del/:id | 删除商品 |
| PUT | /adminapi/pointshop/goods/setStatus | 设置状态 |
| GET | /adminapi/pointshop/goods/getCategory | 获取分类 |
| GET | /adminapi/pointshop/category/lists | 分类列表 |
| GET | /adminapi/pointshop/category/info/:id | 分类详情 |
| POST | /adminapi/pointshop/category/add | 添加分类 |
| PUT | /adminapi/pointshop/category/edit/:id | 编辑分类 |
| DELETE | /adminapi/pointshop/category/del/:id | 删除分类 |
| GET | /adminapi/pointshop/order/lists | 订单列表 |
| GET | /adminapi/pointshop/order/info/:id | 订单详情 |
| POST | /adminapi/pointshop/order/deliver | 订单发货 |
| GET | /adminapi/pointshop/order/getStatusList | 状态列表 |

### 用户端 API

| 方法 | 路径 | 说明 |
|------|------|------|
| GET | /api/pointshop/index | 商城首页 |
| GET | /api/pointshop/goodsList | 商品列表 |
| GET | /api/pointshop/goodsDetail/:id | 商品详情 |
| POST | /api/pointshop/exchange | 积分兑换 |
| GET | /api/pointshop/orderList | 订单列表 |
| GET | /api/pointshop/orderDetail/:id | 订单详情 |
| PUT | /api/pointshop/cancelOrder/:id | 取消订单 |
| PUT | /api/pointshop/confirmReceive/:id | 确认收货 |

## 安装步骤

1. 执行数据库脚本 `doc/sql/pointshop.sql`
2. 复制后端代码到对应目录
3. 复制前端代码到对应目录
4. 配置后端路由文件

## 性能优化

- Redis 缓存：首页数据缓存 60s，商品详情缓存 300s
- 图片预加载：列表页图片预加载优化
- 分页加载：无限滚动分页加载
- 防重复提交：Redis 锁机制

## 更新日志

### v1.1.0 (2024)
- 基于 Skills 模块化规范重构
- 优化前端页面性能和用户体验
- 添加骨架屏和图片懒加载
- 支持 Web 端和 H5 端

### v1.0.0
- 初始版本
- 基础积分兑换功能
