# 通用模块技能

## 概述

通用模块是一个完整的模块开发框架，包含后台管理、API接口、数据库表、前端页面等完整功能。本技能用于快速开发和整合各种业务模块。

## 技能结构

```
niucloud-module/
├── SKILL.md                    # 技能说明文档
├── backend/                    # 后端代码块
│   ├── controller/             # 控制器
│   ├── route/                  # 路由
│   ├── service/                # 服务层
│   ├── model/                  # 数据模型
│   ├── dict/                   # 字典配置
│   └── validate/               # 验证器
├── frontend/                   # 前端代码块
│   ├── admin/                  # 后台管理
│   ├── uni-app/                # 移动端
│   └── web/                    # 前端网站
├── sql/                        # 数据库脚本
└── files/                      # 特殊处理文件
```

## 使用说明

### 1. 后端代码块

#### 1.1 控制器

```php
// 模块后台控制器
app/adminapi/controller/[module]/[Module].php

// 模块API控制器
app/api/controller/[module]/[Module].php
```

#### 1.2 路由

```php
// 模块后台路由
app/adminapi/route/[module].php

// 模块API路由
app/api/route/[module].php
```

#### 1.3 服务层

```php
// 模块后台服务
app/service/admin/[module]/[Module]Service.php

// 模块记录服务
app/service/admin/[module]/[Module]RecordsService.php

// 模块配置服务
app/service/admin/[module]/[Module]Config.php

// 模块API服务
app/service/api/[module]/[Module]Service.php

// 模块核心配置服务
app/service/core/[module]/Core[Module]ConfigService.php

// 模块核心记录服务
app/service/core/[module]/Core[Module]RecordsService.php
```

#### 1.4 数据模型

```php
// 模块模型
app/model/[module]/[Module].php

// 模块字段模型
app/model/[module]/[Module]Fields.php

// 模块记录模型
app/model/[module]/[Module]Records.php

// 模块记录字段模型
app/model/[module]/[Module]RecordsFields.php

// 模块提交配置模型
app/model/[module]/[Module]SubmitConfig.php

// 模块填写配置模型
app/model/[module]/[Module]WriteConfig.php
```

#### 1.5 字典配置

```php
// 模块组件字典
app/dict/[module]/ComponentDict.php

// 模块模板字典
app/dict/[module]/TemplateDict.php

// 模块类型字典
app/dict/[module]/TypeDict.php

// 模块配置字典
app/dict/[module]/ConfigDict.php
```

#### 1.6 验证器

```php
// 模块验证器
app/validate/[module]/[Module].php
```

### 2. 前端代码块

#### 2.1 后台管理

```ts
// 模块API接口
admin/src/api/[module].ts

// 语言包
admin/src/lang/zh-cn/[module].edit.json
admin/src/lang/zh-cn/[module].list.json
admin/src/lang/zh-cn/[module].json
admin/src/lang/en/[module].json

// 页面
admin/src/views/[module]/edit.vue
admin/src/views/[module]/list.vue

// 组件
admin/src/views/[module]/components/detail-[module]-render.vue
```

#### 2.2 移动端

```ts
// 模块API接口
uni-app/src/api/[module].ts

// 组件
uni-app/src/components/[module]/

// hooks
uni-app/src/hooks/use[Module].ts

// 页面
uni-app/src/pages/[module]/

// 状态管理
uni-app/src/stores/[module].ts

// 样式
uni-app/src/styles/[module].scss
```

#### 2.3 前端网站

```ts
// 模块API接口
web/src/api/[module].ts

// 页面
web/src/views/[module]/
```

### 3. 数据库脚本

```sql
// 数据库表结构
sql/tables.sql

// 菜单配置
sql/menu.sql
```

### 4. 特殊处理文件

```php
// 合并的路由文件
files/routes/[module]_merged.php
```

## 使用步骤

1. **复制代码块**：将对应目录下的代码块复制到系统中
2. **配置数据库**：执行SQL脚本创建数据库表
3. **配置菜单**：执行菜单SQL脚本添加后台菜单
4. **测试功能**：访问后台管理页面测试模块功能

## 注意事项

- 使用前请先备份现有代码
- 确保相关文件已存在
- 需要手动拆分路由文件
- 部署后务必进行功能测试