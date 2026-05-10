# 模块数据库表结构

## 概述

模块包含6个数据库表，用于存储模块配置、字段信息、提交记录等数据。

## 表结构

### 1. 模块主表（{prefix}module）

```sql
CREATE TABLE `{prefix}module` (
  `id` int NOT NULL AUTO_INCREMENT COMMENT '主键ID',
  `title` varchar(255) NOT NULL DEFAULT '' COMMENT '模块标题',
  `name` varchar(100) NOT NULL DEFAULT '' COMMENT '模块标识',
  `type` varchar(50) NOT NULL DEFAULT '' COMMENT '模块类型',
  `template` varchar(255) NULL COMMENT '模板路径',
  `value` text NULL COMMENT '模块配置',
  `is_default` tinyint NOT NULL DEFAULT 0 COMMENT '是否默认，0：否，1：是',
  `create_time` int NOT NULL DEFAULT 0 COMMENT '创建时间',
  `update_time` int NOT NULL DEFAULT 0 COMMENT '更新时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `uk_name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='模块表';
```

### 2. 模块字段表（{prefix}module_fields）

```sql
CREATE TABLE `{prefix}module_fields` (
  `id` int NOT NULL AUTO_INCREMENT COMMENT '主键ID',
  `module_id` int NOT NULL COMMENT '模块ID',
  `field_key` varchar(100) NOT NULL DEFAULT '' COMMENT '字段标识',
  `field_name` varchar(255) NOT NULL DEFAULT '' COMMENT '字段名称',
  `field_type` varchar(50) NOT NULL DEFAULT '' COMMENT '字段类型',
  `required` tinyint NOT NULL DEFAULT 0 COMMENT '是否必填，0：否，1：是',
  `placeholder` varchar(255) NULL COMMENT '占位符',
  `default_value` varchar(255) NULL COMMENT '默认值',
  `options` text NULL COMMENT '选项配置（JSON）',
  `sort` int NOT NULL DEFAULT 0 COMMENT '排序',
  `create_time` int NOT NULL DEFAULT 0 COMMENT '创建时间',
  `update_time` int NOT NULL DEFAULT 0 COMMENT '更新时间',
  PRIMARY KEY (`id`),
  KEY `idx_module_id` (`module_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='模块字段表';
```

### 3. 模块记录表（{prefix}module_records）

```sql
CREATE TABLE `{prefix}module_records` (
  `id` int NOT NULL AUTO_INCREMENT COMMENT '主键ID',
  `module_id` int NOT NULL COMMENT '模块ID',
  `member_id` int NOT NULL COMMENT '会员ID',
  `create_time` int NOT NULL DEFAULT 0 COMMENT '创建时间',
  PRIMARY KEY (`id`),
  KEY `idx_module_id` (`module_id`),
  KEY `idx_member_id` (`member_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='模块记录表';
```

### 4. 模块记录字段表（{prefix}module_records_fields）

```sql
CREATE TABLE `{prefix}module_records_fields` (
  `id` int NOT NULL AUTO_INCREMENT COMMENT '主键ID',
  `record_id` int NOT NULL COMMENT '记录ID',
  `field_key` varchar(100) NOT NULL DEFAULT '' COMMENT '字段标识',
  `field_value` text NULL COMMENT '字段值',
  `create_time` int NOT NULL DEFAULT 0 COMMENT '创建时间',
  PRIMARY KEY (`id`),
  KEY `idx_record_id` (`record_id`),
  KEY `idx_field_key` (`field_key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='模块记录字段表';
```

### 5. 模块填写配置表（{prefix}module_write_config）

```sql
CREATE TABLE `{prefix}module_write_config` (
  `id` int NOT NULL AUTO_INCREMENT COMMENT '主键ID',
  `module_id` int NOT NULL COMMENT '模块ID',
  `title` varchar(255) NOT NULL DEFAULT '' COMMENT '标题',
  `content` text NULL COMMENT '内容',
  `create_time` int NOT NULL DEFAULT 0 COMMENT '创建时间',
  `update_time` int NOT NULL DEFAULT 0 COMMENT '更新时间',
  PRIMARY KEY (`id`),
  KEY `idx_module_id` (`module_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='模块填写配置表';
```

### 6. 模块提交配置表（{prefix}module_submit_config）

```sql
CREATE TABLE `{prefix}module_submit_config` (
  `id` int NOT NULL AUTO_INCREMENT COMMENT '主键ID',
  `module_id` int NOT NULL COMMENT '模块ID',
  `title` varchar(255) NOT NULL DEFAULT '' COMMENT '标题',
  `content` text NULL COMMENT '内容',
  `create_time` int NOT NULL DEFAULT 0 COMMENT '创建时间',
  `update_time` int NOT NULL DEFAULT 0 COMMENT '更新时间',
  PRIMARY KEY (`id`),
  KEY `idx_module_id` (`module_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='模块提交配置表';
```

## 使用说明

1. 将 `{prefix}` 替换为实际的表前缀（默认为 `nc_`）
2. 按顺序执行SQL脚本创建数据库表
3. 确保数据库支持UTF8MB4字符集
4. 执行完成后可以通过后台管理系统查看和管理模块