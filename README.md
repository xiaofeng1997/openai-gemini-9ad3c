# NIUCLOUD Lite AI - 快速开发框架

基于 ThinkPHP + Vue3 的企业级快速开发框架，模块化设计，开箱即用

## 产品概述

NIUCLOUD Lite AI 是 NIUCLOUD 官方推出的新一代企业级快速开发框架，在继承 NIUCLOUD 成熟技术架构的基础上，深度融合 Skills 模块化开发规范与 AI 智能扩展能力，打造面向未来的智能开发平台。

## 核心特性

### 🏗️ 继承 NIUCLOUD 成熟架构

- 基于 ThinkPHP 8.0 + Vue3 的企业级技术栈
- 前后端分离架构，支持多端部署
- 内置用户权限、支付中心、微信生态等核心模块
- 经过多年生产环境验证的稳定框架

### 🧩 Skills 模块化开发

- 标准化模块开发规范 (niucloud-module)
- 后端：Controller → Service → Model 分层架构
- 前端：Admin + UniApp + Web 多端覆盖
- 一键生成数据库、接口、页面全套代码

### 🤖 AI 开发扩展能力

- 支持接入 AI 智能体 (Agent) 扩展开发
- 可构建知识库驱动的智能应用
- 开放 AI 插件接口，支持自定义智能功能
- 为框架注入智能化能力，提升开发效率

## 技术架构

### 分层架构设计

```
📱 前端表现层
  ├─ Admin 管理后台 (Vue3 + TypeScript + Vite)
  └─ UniApp 移动端 (Vue3 + TypeScript + Vite)
      ↓
🔐 API网关层
  └─ 统一认证
      ↓
⚙️ 业务服务层
  ├─ 用户权限管理
  ├─ 自定义表单/页面
  ├─ 微信生态
  ├─ 支付中心
  └─ 页面装修
      ↓
💾 数据访问层
  ├─ MySQL
  ├─ Redis
  └─ 对象存储
```

### 核心技术栈

| 层级 | 技术选型 | 特点 |
|------|---------|------|
| 后端框架 | ThinkPHP 8.0 + PHP 8.0+ | 高性能、现代化、企业级 |
| 前端后台 | Vue 3 + TypeScript + Vite + Element Plus | 极速开发、类型安全 |
| 前端移动 | UniApp + Vue 3 + TypeScript | 一套代码，多端运行 |
| 状态管理 | Pinia | 轻量、类型友好 |
| 数据缓存 | Redis | 高性能缓存 |
| 认证机制 | JWT | 无状态、跨域友好 |

## 核心功能模块

### 1. 用户权限管理

- 用户管理：管理员账号的创建、编辑、删除
- 角色管理：角色的创建、权限分配
- 权限管理：菜单权限、操作权限的精细化控制
- 部门管理：企业组织架构管理
- 岗位管理：岗位设置和权限分配

### 2. 自定义表单

- 表单设计：可视化表单设计器
- 表单管理：表单的创建、编辑、删除
- 字段管理：支持多种字段类型 (文本、数字、日期、文件等)
- 数据管理：表单数据的查看、导出、统计

### 3. 自定义页面

- 页面设计：可视化页面设计器，支持拖拽式组件布局
- 组件库：丰富的页面组件 (轮播图、商品列表、图文导航、富文本等)
- 页面管理：页面的创建、编辑、预览、发布
- 多端适配：支持 H5、小程序、App 等多端页面适配

### 4. 系统配置

- 网站设置：网站基本信息、SEO 配置
- 支付配置：微信支付、支付宝支付配置
- 短信配置：短信服务提供商配置
- 存储配置：云存储服务配置

### 5. 会员管理

- 会员管理：会员账号的管理
- 会员等级：会员等级设置和管理
- 会员积分：积分规则和管理

### 6. 微信生态

- 微信公众号：公众号配置和消息管理
- 微信小程序：小程序配置和管理
- 微信支付：微信支付集成

### 7. 数据统计

- 访问统计：网站访问数据统计
- 操作日志：系统操作日志记录
- 数据报表：业务数据报表生成

### 8. 后台样式组件库

- 开箱即用的后台UI组件
- 标准后台布局结构：提供标准的后台布局模板，包含侧边栏、顶部导航等
- 经典布局风格：简洁美观的布局风格，提升用户体验
- 三栏式布局：支持三栏式布局，适合复杂的管理后台场景

### 9. 功能模块组件库

- 覆盖全业务场景，复制粘贴即可快速实现功能
- 用户登录注册：提供完整的用户登录注册功能模块
- 权限管理模块：完善的权限管理系统，支持角色权限控制
- 文件上传管理模块：支持文件上传、管理等功能
- 插件/模块管理：支持插件和模块的安装、卸载、管理
- 订单模块：完整的订单管理功能
- 微信支付模块：集成微信支付功能

## Skills 模块开发规范

NIUCLOUD Lite AI 提供标准化的模块开发技能 (Skills)，帮助开发者快速构建功能模块。

### Skill 结构说明

```
niucloud-module/
├── backend/        # 后端代码
│   ├── controller/ # 控制器
│   ├── model/      # 数据模型
│   ├── service/    # 服务层
│   ├── validate/   # 验证器
│   ├── route/      # 路由
│   └── dict/       # 字典配置
├── frontend/       # 前端代码
│   ├── admin       # 后台管理
│   ├── uni-app     # 移动端
│   └── web         # 前端网站
├── sql/            # 数据库脚本
└── files/          # 配置文件
```

### 快速开发一个功能模块

#### Step 1: 创建后端代码

**1.1 数据模型**

```php
// app/model/demo/Demo.php
namespace app\model\demo;
use app\model\BaseModel;

class Demo extends BaseModel
{
    protected $name = 'demo';
    // 模型逻辑
}
```

**1.2 服务层**

```php
// app/service/admin/demo/DemoService.php
namespace app\service\admin\demo;
use app\service\BaseService;
use app\model\demo\Demo;

class DemoService extends BaseService
{
    protected $model;

    public function __construct()
    {
        $this->model = new Demo();
        
    }
    // 业务逻辑
}
```

**1.3 控制器**

```php
// app/adminapi/controller/demo/Demo.php
namespace app\adminapi\controller\demo;
use app\adminapi\controller\BaseAdminController;
use app\service\admin\demo\DemoService;

class Demo extends BaseAdminController
{
    protected $service;

    public function __construct(DemoService $service)
    {
        $this->service = $service;
        
    }
    // 接口方法
}
```

**1.4 路由配置**

```php
// app/adminapi/route/demo.php
use think\facade\Route;

Route::group('demo', function () {
    Route::get('list', 'demo.Demo/lists');
    Route::post('add', 'demo.Demo/add');
    Route::put('edit/:id', 'demo.Demo/edit');
    Route::delete('del/:id', 'demo.Demo/del');
});
```

#### Step 2: 创建前端代码

**2.1 API 接口**

```typescript
// admin/src/api/demo.ts
import request from '@/utils/request';

export function getDemoList(params: any) {
    return request.get('/adminapi/demo/list', { params });
}

export function addDemo(data: any) {
    return request.post('/adminapi/demo/add', data);
}

export function editDemo(id: number, data: any) {
    return request.put(`/adminapi/demo/edit/${id}`, data);
}

export function deleteDemo(id: number) {
    return request.delete(`/adminapi/demo/del/${id}`);
}
```

**2.2 页面组件**

```vue
<!-- admin/src/views/demo/list.vue -->
<template>
  <div class="demo-list">
    <el-table :data="list" v-loading="loading">
      <!-- 表格列 -->
    </el-table>
  </div>
</template>

<script setup lang="ts">
import { ref, onMounted } from 'vue';
import { getDemoList } from '@/api/demo';

const list = ref([]);
const loading = ref(false);

const fetchList = async () => {
  loading.value = true;
  const res = awAIt getDemoList();
  list.value = res.data;
  loading.value = false;
};

onMounted(fetchList);
</script>
```

#### Step 3: 数据库和菜单

**3.1 数据库表**

```sql
-- sql/demo.sql
CREATE TABLE `nc_demo` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL DEFAULT '',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `create_time` int(11) NOT NULL DEFAULT '0',
  `update_time` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
```

**3.2 菜单配置**

```sql
-- 添加后台菜单
INSERT INTO `nc_sys_menu` (`menu_name`, `menu_key`, `parent_key`, `menu_type`, `icon`, `api_url`, `sort`)
VALUES ('示例管理', 'demo', '', '0', 'icon-demo', '', 100);
```

## 开发示例

### 示例 1: 创建会员积分系统

**需求**：创建一个会员积分系统，包含积分规则配置、积分获取记录、积分消费记录

**生成内容**：

```
├─ 数据库表
│  ├─ nc_points_rule                # 积分规则表
│  ├─ nc_points_log                 # 积分记录表
│  └─ nc_points_exchange            # 积分兑换表
├─ 后端代码
│  ├─ PointsRuleController          # 积分规则控制器
│  ├─ PointsLogController           # 积分记录控制器
│  └─ PointsExchangeController      # 积分兑换控制器
├─ 前端页面
│  ├─ 积分规则配置页 
│  ├─ 积分记录查询页 
│  └─ 积分兑换管理页 
└─ API 接口
   ├─ GET /api/points/rule          # 获取积分规则
   ├─ POST /api/points/log          # 记录积分变动
   └─ POST /api/points/exchange     # 积分兑换
```

### 示例 2: 创建营销活动页面

**需求**：创建一个限时秒杀活动页面，包含活动商品展示、倒计时、立即抢购按钮

**生成内容**：

```
├─ 页面组件
│  ├─ SeckillBanner                  # 活动横幅
│  ├─ SeckillCountdown               # 倒计时组件
│  ├─ SeckillGoodsList               # 商品列表
│  └─ SeckillBuyButton               # 抢购按钮
├─ 样式设计
│  ├─ 红色主题配色  
│  ├─ 动态倒计时效果 
│  └─ 库存进度条  
└─ 交互逻辑
   ├─ 倒计时自动刷新
   ├─ 库存实时更新  
   └─ 抢购防重复提交  
```

## 为什么选择 NIUCLOUD Lite AI

### 开发效率对比

| 开发环节 | 传统开发方式 | NIUCLOUD Lite AI |
|---------|------------|-----------------|
| 项目搭建 | 2-3 天 | 30 分钟 (内置脚手架) |
| 用户权限 | 3-5 天 | 开箱即用 |
| 表单功能 | 2-3 天 | 可视化配置 |
| 页面开发 | 1-2 周 | 拖拽式生成 |
| 多端适配 | 1-2 周 | 一套代码多端运行 |
| 总计 | 1-2 月 | 1-2 周 |

### 核心优势

- ⏱️ **开发效率高**：内置丰富模块，减少重复开发
- 🧩 **模块化设计**：标准化 Skill 规范，易于扩展
- 📱 **多端支持**：PC 后台 + 移动端 + H5 全覆盖
- 🔐 **安全可靠**：完善的权限控制和数据安全机制
- 📚 **文档完善**：详细的开发手册和示例代码
- 🎓 **上手简单**：标准化开发流程，降低学习成本

### 核心能力

- **无封装，低成本学习**：代码清晰易懂，无过度封装，快速上手
- **前沿技术栈**：Vue3 + TypeScript + Vite + Pinia + Vue-Router + Axios，PHP8 + THINKPHP8 + MYSQL8
- **插件生态内置**：内置最精简微信公众号，微信小程序实现
- **一站式短信管理系统**：支持短信配置等
- **第三方登录**：快速打通多平台登录
- **全端统一架构设计**：一套逻辑覆盖H5，Web，小程序，公众号，APP
- **丰富实用的组件库**：提供丰富的UI组件和业务组件，复制粘贴即可集成
- **MIT开源协议**：完全开源，免费商用
- **公开Git仓库**：代码完全公开，版本实时更新，便于学习和贡献
- **智能代码生成器**：一键生成代码，提升开发效率
- **云存储管理**：支持云存储服务，方便管理文件资源
- **全渠道支付**：支持微信支付、支付宝等多种支付方式

## 适用场景

### 企业级应用开发

- 内容管理系统 (CMS)
- 客户关系管理 (CRM)
- 企业资源计划 (ERP)
- 办公自动化 (OA)

### 电商系统

- B2B/B2C 电商平台
- 社交电商小程序
- 直播带货系统
- 分销返利系统

### 行业解决方案

- 教育培训平台
- 医疗健康系统
- 智慧社区平台
- 餐饮外卖系统