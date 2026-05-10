name: "niucloud-php-coding-standards"
description: "提供NiuCloud系统后台PHP编码规范，包括控制器、路由、Model、Service的完整开发标准。触发关键词：PHP、后台、后端、控制器、Controller、Service、Model、路由、验证器、验证、PHP编码、后端编码、控制器开发、服务层开发。在开发NiuCloud后台功能时调用此技能。"
-----------------------------------------------------------------------------------------------------------------------------------------------------------------------

# NiuCloud PHP 编码规范

> 本规范基于 NiuCloud 系统后台的实际代码分析总结，提供完整的 PHP 编码标准。

## 📋 快速导航

- [一、基础编码规范](#一基础编码规范)
- [二、控制器编码规范](#二控制器编码规范)
  - [2.1 AdminAPI控制器](#21-adminapi控制器)
  - [2.2 API控制器](#22-api控制器)
- [三、路由编码规范](#三路由编码规范)
- [四、Model编码规范](#四model编码规范)
- [五、Service编码规范](#五service编码规范)
- [六、验证器编码规范](#六验证器编码规范)
- [七、字典编码规范](#七字典编码规范)
- [八、完整示例](#八完整示例)

***

## 一、基础编码规范

### 1.1 文件头注释

```php
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
```

### 1.2 命名规范

#### 文件和目录命名

- **目录**：小写字母+下划线，如 `adminapi`、`service`
- **文件**：大驼峰命名法（PascalCase），如 `Role.php`、`MenuService.php`
- **adminapi控制器**：`app/adminapi/controller/{模块}/`
- **api控制器**：`app/api/controller/{模块}/`
- **admin服务**：`app/service/admin/{模块}/`
- **api服务**：`app/service/api/{模块}/`
- **模型**：`app/model/{模块}/`

#### 类命名

- **adminapi控制器**：大驼峰，如 `class Role`
- **api控制器**：大驼峰，如 `class Member`
- **admin服务**：大驼峰+Service，如 `class RoleService`
- **api服务**：大驼峰+Service，如 `class MemberService`
- **模型**：大驼峰，如 `class SysRole`
- **验证器**：大驼峰，如 `class Role`
- **字典**：大驼峰+Dict，如 `class RoleStatusDict`

#### Service类命名规范

- **类名**：{业务模块名}Service，如 `ProductService`
- **属性名**：{业务模块名}\_model，如 `$product_model`
- **构造函数**：在构造函数中初始化模型实例
  ```php
  public function __construct()
  {
      parent::__construct();
      $this->product_model = new Product();
  }
  ```

#### Service数据获取规范

- **列表查询**：使用 `$this->product_model->where($where)->order()->select()`
- **详情查询**：使用 `$this->product_model->where([['id', '=', $id]])->findOrEmpty()->toArray()`
- **数据转换**：获取单条数据时必须使用 `toArray()` 转换为数组格式，确保返回的是纯数组而非模型对象
- **空数据处理**：使用 `findOrEmpty()` 代替 `find()`，避免空指针异常
- **状态修改**：直接使用模型更新，无需转换为数组
- **排序修改**：直接使用模型更新，无需转换为数组

#### 方法和变量命名

- **方法**：小驼峰（camelCase），如 `getPage()`、`getInfo()`
- **变量**：小驼峰，如 `$role_id`、`$data`
- **常量**：全大写+下划线，如 `const ON = 1;`

#### Service方法命名规范

- **列表查询**：`getPage()`，返回分页数据
- **详情查询**：`getInfo()`，返回单条数据详情（数组格式，必须使用 `toArray()` 转换）
- **新增数据**：`add()`，返回新增数据ID
- **编辑数据**：`edit()`，返回操作结果
- **删除数据**：`del()`，返回操作结果
- **获取全部**：`getAll()`，返回所有数据（数组格式）
- **状态修改**：`modifyStatus()`，返回操作结果
- **排序修改**：`sort()`，返回操作结果

#### Service方法参数规范

- **列表查询**：接收 `array $where = []` 参数
- **详情查询**：接收 `int $id` 参数
- **新增数据**：接收 `array $data` 参数
- **编辑数据**：接收 `int $id` 和 `array $data` 参数
- **删除数据**：接收 `int $id` 参数
- **状态修改**：接收 `int $id` 和 `int $status` 参数
- **排序修改**：接收 `array $data` 参数

#### Service数据返回规范

- **列表查询**：返回分页数据（数组格式）
- **详情查询**：返回单条数据详情（数组格式，必须使用 `toArray()` 转换）
- **新增数据**：返回新增数据ID（整数）
- **编辑数据**：返回操作结果（布尔值）
- **删除数据**：返回操作结果（布尔值）
- **获取全部**：返回所有数据（数组格式）
- **状态修改**：返回操作结果（布尔值）
- **排序修改**：返回操作结果（布尔值）

#### 数据库命名

- **表名**：小写+下划线，如 `sys_role`、`sys_menu`
- **字段**：小写+下划线，如 `role_id`、`role_name`
- **主键**：`{表名}_id`，如 `role_id`、`menu_id`

### 1.3 命名空间规范

```php
// adminapi控制器
namespace app\adminapi\controller\sys;

// api控制器
namespace app\api\controller\member;

// admin服务
namespace app\service\admin\sys;

// api服务
namespace app\service\api\member;

// 模型
namespace app\model\sys;

// 验证器
namespace app\validate\sys;

// 字典
namespace app\dict\sys;
```

### 1.4 类注释规范

```php
/**
 * 用户组管理
 * Class Role
 * @description 用户组管理
 * @package app\adminapi\controller\sys
 */
class Role extends BaseAdminController
{
}
```

### 1.5 方法注释规范

```php
/**
 * 用户组列表
 * @description 用户组列表
 * @return Response
 */
public function lists()
{
}

/**
 * 新增用户组
 * @description 新增用户组
 * @return Response
 */
public function add()
{
}

/**
 * 更新用户组
 * @description 更新用户组
 * @param $role_id
 * @return Response
 */
public function edit($role_id)
{
}

/**
 * 删除单个用户组
 * @description 删除单个用户组
 * @param $role_id
 * @return Response
 * @throws DbException
 */
public function del($role_id)
{
}
```

***

## 二、控制器编码规范

### 2.1 AdminAPI控制器

#### 2.1.1 控制器基础结构

```php
namespace app\adminapi\controller\sys;

use app\service\admin\sys\RoleService;
use core\base\BaseAdminController;
use think\App;

/**
 * 用户组管理
 * Class Role
 * @description 用户组管理
 * @package app\adminapi\controller\sys
 */
class Role extends BaseAdminController
{
    protected $role_service;

    public function __construct(App $app)
    {
        parent::__construct($app);
        $this->role_service = new RoleService();
    }
}
```

**构造函数规范说明：**

1. **引入 App 类**：使用 `use think\App;` 引入 App 类（注意：不是 `think\facade\App`）
2. **构造函数参数**：构造函数必须接收 `App $app` 参数
3. **调用父类构造函数**：必须调用 `parent::__construct($app);` 并传入 $app 参数
4. **初始化 Service**：在构造函数中初始化对应的 Service 实例
5. **Service 属性命名**：Service 属性使用小写+下划线命名，如 `$role_service`

#### 2.1.2 列表接口

```php
/**
 * 用户组列表
 * @description 用户组列表
 * @return Response
 */
public function lists()
{
    $data = $this->request->params();
    return success($this->role_service->getPage($data));
}
```

#### 2.1.3 详情接口

```php
/**
 * 用户组详情
 * @description 用户组详情
 * @param int $id 用户组ID
 * @return Response
 */
public function info(int $id)
{
    return success($this->role_service->getInfo($id));
}
```

#### 2.1.4 添加接口

```php
/**
 * 新增商品
 * @return Response
 */
public function add()
{
    $data = $this->request->params([
        ["product_name", ""],
        ["category_id", ""],
        ["price", ""],
        ["stock", ""]
    ]);
    $this->validate($data, 'app\validate\product\Product.add');
    $id = $this->product_service->add($data);
    return success('ADD_SUCCESS', ["id" => $id]);
}
```

#### 2.1.5 编辑接口

```php
/**
 * 编辑商品
 * @param int $id 商品ID
 * @return Response
 */
public function edit(int $id)
{
    $data = $this->request->params([
        ["product_name", ""],
        ["category_id", ""],
        ["price", ""],
        ["stock", ""]
    ]);
    $this->validate($data, 'app\validate\product\Product.edit');
    $this->product_service->edit($id, $data);
    return success('EDIT_SUCCESS');
}
```

#### 2.1.6 删除接口

```php
/**
 * 删除商品
 * @param int $id 商品ID
 * @return Response
 */
public function del(int $id)
{
    $this->product_service->del($id);
    return success('DELETE_SUCCESS');
}
```

#### 2.1.7 状态修改接口

```php
/**
 * 修改状态
 * @description 修改状态
 * @return \think\Response
 */
public function modifyStatus()
{
    $data = $this->request->params([
        ['goods_id', 0],
        ['status', 1],
    ]);
    $goods_id = $data['goods_id'] ?? 0;
    $status = $data['status'] ?? 1;
    $res = $this->goods_service->modifyStatus($goods_id, $status);
    return success('MODIFY_SUCCESS', $res);
}
```

**接口方法规范说明：**

1. **使用构造函数中的 Service 实例**：所有方法都应使用 `$this->role_service` 而不是每次都 `new RoleService()`
2. **参数获取**：
   - 请求参数：使用 `$this->request->params()` 或 `$this->request->params('参数名', 默认值)`
3. **路由参数**：路由中的参数（如 `:id`）通过方法参数接收，或通过 `$this->request->params()` 获取
4. **返回格式**：统一使用 `success()` 方法返回，成功消息使用常量如 `'ADD_SUCCESS'`

#### 2.1.8 批量操作接口

```php
/**
 * 批量删除
 * @description 批量删除
 * @return Response
 */
public function batchDel()
{
    $data = $this->request->params([
        ['att_ids', []],
    ]);
    (new AttachmentService())->delAll($data['att_ids']);
    return success('DELETE_SUCCESS');
}
```

#### 2.1.9 获取全部数据接口

```php
/**
 * 获取全部权限
 * @description 获取全部权限
 * @return Response
 */
public function all()
{
    return success((new RoleService())->getAll());
}
```

#### 2.1.10 获取字典数据接口

```php
/**
 * 获取菜单类型静态资源
 * @description 获取菜单类型静态资源
 * @return Response
 */
public function getMenuType()
{
    return success(MenuTypeDict::getMenuType());
}
```

#### 2.1.11 导出数据接口

```php
/**
 * 导出会员列表
 * @description 导出会员列表
 * @return Response
 */
public function export()
{
    $data = $this->request->params([
        ['keyword', ''],
        ['register_type', ''],
        ['create_time', []],
    ]);
    (new MemberService())->exportMember($data);
    return success('SUCCESS');
}
```

#### 2.1.12 修改单个字段接口

```php
/**
 * 修改会员
 * @description 修改会员
 * @param $member_id
 * @param $field
 * @return Response
 */
public function modify($member_id, $field)
{
    $data = $this->request->params([
        ['value', ''],
        ['field', $field],
    ]);
    $data[$field] = $data['value'];
    $data['member_id'] = $member_id;
    $this->validate($data, 'app\validate\member\Member.modify');
    (new MemberService())->modify($member_id, $field, $data['value']);
    return success('MODIFY_SUCCESS');
}
```

#### 2.1.13 批量修改接口

```php
/**
 * 批量操作
 * @description 批量操作
 * @return Response
 */
public function batchModify()
{
    $data = $this->request->params([
        ['is_all', 0],
        ['where', []],
        ['member_ids', []],
        ['value', ''],
        ['field', ''],
    ]);
    (new MemberService())->batchModify($data);
    return success('MODIFY_SUCCESS');
}
```

#### 2.1.14 设置状态接口

```php
/**
 * 设置会员的状态
 * @description 设置会员的状态
 * @param $status
 * @return Response
 */
public function setStatus($status)
{
    $data = $this->request->params([
        ['member_ids', []],
    ]);
    $this->validate(['status' => $status], 'app\validate\member\Member.set_status');
    (new MemberService())->setStatus($data['member_ids'], $status);
    return success('EDIT_SUCCESS');
}
```

***

### 2.2 API控制器

#### 2.2.1 控制器基础结构

```php
namespace app\api\controller\member;

use app\service\api\member\MemberService;
use core\base\BaseApiController;
use think\Response;

class Member extends BaseApiController
{
}
```

#### 2.2.2 获取会员信息接口

```php
/**
 * 会员信息
 * @return Response
 */
public function info()
{
    return success((new MemberService())->getInfo());
}
```

#### 2.2.3 会员中心接口

```php
/**
 * 会员中心
 * @return Response
 */
public function center()
{
    return success((new MemberService())->center());
}
```

#### 2.2.4 修改会员字段接口

```php
/**
 * 修改会员
 * @param $field
 * @return Response
 */
public function modify($field)
{
    $data = $this->request->params([
        ['value', ''],
        ['field', $field],
    ]);
    $data[$field] = $data['value'];
    $data['member_id'] = $this->request->memberId();
    $this->validate($data, 'app\validate\member\Member.modify');
    (new MemberService())->modify($field, $data['value']);
    return success('MODIFY_SUCCESS');
}
```

#### 2.2.5 编辑会员接口

```php
/**
 * 编辑会员
 * @return Response
 */
public function edit()
{
    $data = $this->request->params([
        ['data', []],
    ]);
    (new MemberService())->edit($data['data']);
    return success('MODIFY_SUCCESS');
}
```

#### 2.2.6 绑定手机号接口

```php
/**
 * 绑定手机号
 * @return Response
 */
public function mobile()
{
    $data = $this->request->params([
        ['mobile', ''],
        ['mobile_code', ''],
    ]);
    return success((new AuthService())->bindMobile($data['mobile'], $data['mobile_code']));
}
```

#### 2.2.7 获取会员二维码接口

```php
/**
 * 获取会员码
 * @return Response
 */
public function qrcode()
{
    return success((new MemberService())->getQrcode());
}
```

***

### 2.3 控制器规范对比

| 特性              | AdminAPI控制器                            | API控制器                               |
| --------------- | -------------------------------------- | ------------------------------------ |
| **基类**          | `BaseAdminController`                  | `BaseApiController`                  |
| **命名空间**        | `app\adminapi\controller\{模块}`         | `app\api\controller\{模块}`            |
| **Service命名空间** | `app\service\admin\{模块}`               | `app\service\api\{模块}`               |
| **参数获取**        | `$this->request->params()`             | `$this->request->params()`           |
| **会员ID获取**      | 不适用                                    | `$this->request->memberId()`         |
| **验证器路径**       | `app\validate\{模块}\{类名}`               | `app\validate\{模块}\{类名}`             |
| **返回成功**        | `success()` 或 `success('ADD_SUCCESS')` | `success()` 或 `success(data: $data)` |
| **路径参数**        | 常用（如 `$role_id`）                       | 较少使用                                 |
| **批量操作**        | 常用                                     | 较少使用                                 |
| **导出功能**        | 常用                                     | 不适用                                  |
| **PHP特性**       | 基础语法                                   | 使用 `match` 等新特性                      |

***

## 三、路由编码规范

### 3.1 路由文件位置

- **adminapi路由**：`app/adminapi/route/{模块}.php`
- **api路由**：`app/api/route/{模块}.php`
- **重要**：路由文件必须在各自应用目录下（adminapi或api），不能放在`backend/route/`目录下

### 3.2 路由基础结构

```php
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

Route::group('sys', function() {
    // 路由定义
})->middleware([
    AdminCheckToken::class,
    AdminCheckRole::class,
    AdminLog::class
]);
```

### 3.3 HTTP方法规范

- **GET**：查询数据（列表、详情）
- **POST**：新增数据
- **PUT**：更新数据
- **DELETE**：删除数据

### 3.4 标准路由定义

```php
// 列表
Route::get('role', 'sys.Role/lists');

// 详情
Route::get('role/:role_id', 'sys.Role/info');

// 新增
Route::post('role', 'sys.Role/add');

// 编辑
Route::put('role/:role_id', 'sys.Role/edit');

// 删除
Route::delete('role/:role_id', 'sys.Role/del');

// 状态修改
Route::put('role/status', 'sys.Role/modifyStatus');
```

### 3.5 路由命名规范

- **路径**：小写+下划线，如 `role`、`role/:role_id`
- **控制器引用**：`{模块}.{控制器}@{方法}` 或 `{模块}.{控制器}/{方法}`
- **参数占位符**：`:参数名`，如 `:role_id`、`:id`

### 3.6 中间件配置

#### AdminAPI中间件

```php
->middleware([
    AdminCheckToken::class,    // 验证登录状态
    AdminCheckRole::class,     // 验证权限
    AdminLog::class            // 记录操作日志
])
```

#### API中间件

```php
->middleware([
    ApiCheckToken::class,     // 验证登录状态
    ApiLog::class,            // 记录操作日志
    ApiChannel::class         // 验证渠道
])
```

### 3.7 完整路由示例

```php
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

Route::group('inventory', function() {
    /***************************************************** 商品管理 ****************************************************/
    Route::get('goods', 'inventory.Goods/lists');
    Route::get('goods/:id', 'inventory.Goods/info');
    Route::post('goods', 'inventory.Goods/add');
    Route::put('goods/:id', 'inventory.Goods/edit');
    Route::delete('goods/:id', 'inventory.Goods/delete');
    Route::put('goods/modifyStatus/:id', 'inventory.Goods/modifyStatus');

    /***************************************************** 仓库管理 ****************************************************/
    Route::get('warehouse', 'inventory.Warehouse/lists');
    Route::get('warehouse/:id', 'inventory.Warehouse/info');
    Route::post('warehouse', 'inventory.Warehouse/add');
    Route::put('warehouse/:id', 'inventory.Warehouse/edit');
    Route::delete('warehouse/:id', 'inventory.Warehouse/delete');
    Route::put('warehouse/modifyStatus/:id', 'inventory.Warehouse/modifyStatus');

    /***************************************************** 入库管理 ****************************************************/
    Route::get('inbound_order', 'inventory.InboundOrder/lists');
    Route::get('inbound_order/:id', 'inventory.InboundOrder/info');
    Route::post('inbound_order', 'inventory.InboundOrder/add');
    Route::put('inbound_order/:id', 'inventory.InboundOrder/edit');
    Route::delete('inbound_order/:id', 'inventory.InboundOrder/delete');
    Route::put('inbound_order/audit/:id', 'inventory.InboundOrder/audit');
})->middleware([
    AdminCheckToken::class,
    AdminCheckRole::class,
    AdminLog::class
]);
```

### 3.8 路由规范对比

| 特性        | 推荐写法                    | 不推荐写法                   |
| --------- | ----------------------- | ----------------------- |
| **路由分组**  | 单层分组                    | 嵌套分组                    |
| **路径格式**  | `goods/:id`             | `goods/info/:id`        |
| **控制器引用** | `inventory.Goods/lists` | `inventory.Goods@lists` |
| **参数占位符** | `:id`                   | `:goods_id`             |
| **注释分隔**  | 使用中文注释分隔模块              | 无注释或使用英文注释              |
| **中间件引用** | 使用use语句引入类              | 使用完整类路径                 |

### 3.9 路由注意事项

1. **文件位置**：路由文件必须放在`app/adminapi/route/`或`app/api/route/`目录下，不能放在`backend/route/`目录
2. **中间件配置**：adminapi路由必须配置`AdminCheckToken`、`AdminCheckRole`、`AdminLog`三个中间件
3. **路由分组**：使用单层`Route::group()`进行路由分组，便于统一配置中间件，避免嵌套分组
4. **控制器引用**：控制器引用格式为`{模块}.{控制器}/{方法}`，如`inventory.Goods/lists`
5. **参数占位符**：使用通用参数名`:id`，如`:id`、`:role_id`，保持一致性
6. **HTTP方法**：严格按照RESTful规范使用GET、POST、PUT、DELETE方法
7. **注释分隔**：使用中文注释分隔不同功能模块，提高代码可读性
8. **路径设计**：采用扁平化路径设计，避免过深的路径嵌套

***

## 四、菜单编码规范

### 4.1 菜单文件位置

- **admin菜单**：`app/dict/menu/admin.php`
- **所有菜单统一配置在admin.php中，不创建单独的菜单文件**

### 4.2 菜单基础结构

```php
[
    'menu_name' => '进销存管理',
    'menu_key' => 'inventory',
    'menu_short_name' => '进销存',
    'parent_key' => '',
    'menu_type' => '0',
    'icon' => 'iconfont iconcangku',
    'api_url' => '',
    'router_path' => '',
    'view_path' => '',
    'methods' => '',
    'sort' => '88',
    'status' => '1',
    'is_show' => '1',
    'children' => [
        [
            'menu_name' => '商品管理',
            'menu_key' => 'inventory_goods',
            'menu_short_name' => '商品',
            'menu_type' => '0',
            'icon' => 'iconfont iconshangpin',
            'api_url' => '',
            'router_path' => '',
            'view_path' => '',
            'methods' => '',
            'sort' => '1',
            'status' => '1',
            'is_show' => '1',
            'children' => [
                [
                    'menu_name' => '商品列表',
                    'menu_key' => 'inventory_goods_lists',
                    'menu_short_name' => '列表',
                    'menu_type' => '1',
                    'icon' => '',
                    'api_url' => 'inventory/goods/lists',
                    'router_path' => '/inventory/goods/list',
                    'view_path' => 'inventory/goods/list.vue',
                    'methods' => 'GET',
                    'sort' => '1',
                    'status' => '1',
                    'is_show' => '1',
                    'children' => []
                ],
                [
                    'menu_name' => '商品新增',
                    'menu_key' => 'inventory_goods_add',
                    'menu_short_name' => '新增',
                    'menu_type' => '1',
                    'icon' => '',
                    'api_url' => 'inventory/goods/add',
                    'router_path' => '/inventory/goods/add',
                    'view_path' => 'inventory/goods/add.vue',
                    'methods' => 'POST',
                    'sort' => '2',
                    'status' => '1',
                    'is_show' => '1',
                    'children' => []
                ]
            ]
        ]
    ]
]
```

### 4.3 菜单层级结构

```
一级菜单（目录）
├── 二级菜单（页面）
│   ├── 三级菜单（按钮-列表）
│   ├── 三级菜单（按钮-详情）
│   ├── 三级菜单（按钮-新增）
│   ├── 三级菜单（按钮-编辑）
│   ├── 三级菜单（按钮-删除）
│   └── 三级菜单（按钮-修改状态）
└── 二级菜单（页面）
    └── 三级菜单（按钮-...）
```

### 4.6 菜单命名规范

- **一级菜单key**：`模块`，如`inventory`、`member`
- **二级菜单key**：`模块_功能`，如`inventory_goods`、`member_list`
- **三级菜单key**：`模块_功能_操作`，如`inventory_goods_lists`、`inventory_goods_add`
- **API地址**：`模块/控制器/方法`，如`inventory/goods/lists`
- **路由路径**：`模块/页面`，如`inventory/goods/list`

### 4.7 菜单示例

```php
[
    'menu_name' => '进销存管理',
    'menu_key' => 'inventory',
    'menu_short_name' => '进销存',
    'parent_key' => '',
    'menu_type' => '0',
    'icon' => 'iconfont iconcangku',
    'api_url' => '',
    'router_path' => '',
    'view_path' => '',
    'methods' => '',
    'sort' => '88',
    'status' => '1',
    'is_show' => '1',
    'children' => [
        [
            'menu_name' => '商品管理',
            'menu_key' => 'inventory_goods',
            'menu_short_name' => '商品',
            'menu_type' => '0',
            'icon' => 'iconfont iconshangpin',
            'api_url' => '',
            'router_path' => '',
            'view_path' => '',
            'methods' => '',
            'sort' => '1',
            'status' => '1',
            'is_show' => '1',
            'children' => [
                [
                    'menu_name' => '商品列表',
                    'menu_key' => 'inventory_goods_lists',
                    'menu_short_name' => '列表',
                    'menu_type' => '1',
                    'icon' => '',
                    'api_url' => 'inventory/goods/lists',
                    'router_path' => '/inventory/goods/list',
                    'view_path' => 'inventory/goods/list.vue',
                    'methods' => 'GET',
                    'sort' => '1',
                    'status' => '1',
                    'is_show' => '1',
                    'children' => []
                ],
                [
                    'menu_name' => '商品新增',
                    'menu_key' => 'inventory_goods_add',
                    'menu_short_name' => '新增',
                    'menu_type' => '1',
                    'icon' => '',
                    'api_url' => 'inventory/goods/add',
                    'router_path' => '/inventory/goods/add',
                    'view_path' => 'inventory/goods/add.vue',
                    'methods' => 'POST',
                    'sort' => '2',
                    'status' => '1',
                    'is_show' => '1',
                    'children' => []
                ]
            ]
        ]
    ]
]
```

### 4.8 菜单注意事项

1. **统一配置**：所有模块的菜单配置都放在`app/dict/menu/admin.php`中，不创建单独的菜单文件
2. **唯一标识**：`menu_key`必须全局唯一，建议使用模块前缀避免冲突
3. **层级关系**：通过`children`数组维护父子关系，不要使用`parent_key`字段
4. **权限控制**：三级菜单（按钮类型）用于API权限控制，必须配置`api_url`和`methods`
5. **排序规则**：同级菜单通过`sort`字段排序，数字越小越靠前
6. **状态管理**：通过`status`和`is_show`控制菜单的启用和显示状态

***

## 五、Model编码规范

### 5.1 模型基础结构

```php
namespace app\model\sys;

use core\base\BaseModel;
use think\model\concern\SoftDelete;

/**
 * 系统角色模型
 * Class SysRole
 * @package app\model\sys
 */
class SysRole extends BaseModel
{
    use SoftDelete;

    protected $pk = 'role_id';
    protected $name = 'sys_role';
    protected $deleteTime = 'delete_time';
    protected $defaultSoftDelete = 0;
}
```

### 5.2 模型属性规范

#### 主键定义

```php
protected $pk = 'role_id';
```

#### 表名定义

```php
protected $name = 'sys_role';
```

#### 追加字段定义

```php
protected $append = ['status_name', 'menu_type_name'];
```

### 5.3 获取器规范

```php
/**
 * 菜单类型
 * @param $value
 * @param $data
 * @return string
 */
public function getMenuTypeNameAttr($value, $data)
{
    if (empty($data['menu_type']))
        return '';
    return MenuTypeDict::getMenuType()[$data['menu_type']] ?? '';
}

/**
 * 菜单状态
 * @param $value
 * @param $data
 * @return string
 */
public function getStatusNameAttr($value, $data)
{
    if (empty($data['status']))
        return '';
    return MenuDict::getStatus()[$data['status']] ?? '';
}
```

### 5.4 搜索器规范

```php
use think\db\Query;

/**
 * 任务类型搜索器
 * @param Query $query
 * @param $value
 * @param $data
 */
public function searchKeyAttr(Query $query, $value, $data)
{
    $query->where('key', '=', $value);
}
```

### 5.5 模型使用规范

```php
// 初始化模型
$this->model = new SysRole();

// 查询单条数据
$role = $this->model->where([['role_id', '=', $role_id]])->findOrEmpty()->toArray();

// 查询多条数据
$list = $this->model->where($where)->select()->toArray();

// 更新数据
$this->model->update($data, $where);

// 删除数据
$role->delete();

// 插入数据
$this->model->save($data);
```

***

## 六、Service编码规范

### 6.1 服务基础结构

```php
namespace app\service\admin\sys;

use core\base\BaseAdminService;
use app\model\sys\SysRole;

/**
 * 用户组管理服务
 * Class RoleService
 * @package app\service\admin\sys
 */
class RoleService extends BaseAdminService
{
    protected $role_model;

    public function __construct()
    {
        parent::__construct();
        $this->role_model = new SysRole();
    }
}
```

**Service层规范说明：**

1. **模型属性命名**：使用 `{模块名}_model` 命名，如 `$role_model`
2. **构造函数**：在构造函数中初始化模型实例
3. **方法命名**：遵循Service方法命名规范
4. **返回值**：统一返回数组或布尔值

### 6.2 Service层编码规范

1. **参数处理**：使用`isset()`判断参数是否存在，使用`!== ''`判断参数是否为空
   ```php
   if (isset($data['field_name']) && $data['field_name'] !== '') {
       $where[] = ['field_name', 'like', "%" . $this->model->handelSpecialCharacter($data['field_name']) . "%"];
   }
   ```
2. **特殊字符处理**：字符串模糊查询必须使用`$this->model->handelSpecialCharacter()`处理特殊字符
   ```php
   $where[] = ['field_name', 'like', "%" . $this->model->handelSpecialCharacter($data['field_name']) . "%"];
   ```
3. **使用模型属性**：所有模型操作必须使用`$this->{模块名}_model`，不能直接使用类名
   ```php
   $search_model = $this->role_model->where($where);  // 正确
   ```
4. **分页查询**：使用`$this->pageQuery()`方法进行分页，不能直接使用`paginate()`
   ```php
   return $this->pageQuery($search_model);  // 正确
   ```
5. **追加字段**：使用`append()`方法追加获取器字段
   ```php
   ->append(['status_name', 'type_name'])
   ```
6. **关联查询**：使用`with()`方法进行关联查询
   ```php
   ->with(['category', 'unit', 'warehouse'])
   ```
7. **排序**：使用`order()`方法指定排序字段和方向
   ```php
   ->order('create_time desc')
   ->order('sort asc, id desc')
   ```

### 6.3 Service层getInfo方法规范

```php
/**
 * 获取商品详情
 * @param int $id 商品ID
 * @return array
 */
public function getInfo(int $id)
{
    return $this->product_model->where([['id', '=', $id]])->findOrEmpty()->toArray();
}
```

***

## 七、验证器编码规范

### 7.1 验证器基础结构

```php
namespace app\validate\sys;

use think\Validate;

/**
 * 用户组验证
 * Class Role
 * @package app\validate\sys
 */
class Role extends Validate
{
    protected $rule = [
        'role_name' => 'require',
    ];

    protected $message = [
        'role_name.require' => 'validate_role.role_name_require',
    ];

    protected $scene = [
        'add' => ['role_name'],
        'edit' => ['role_name']
    ];
}
```

### 7.2 验证规则规范

```php
protected $rule = [
    'role_name' => 'require',
    'menu_name' => 'require',
    'menu_type' => 'require|checkMenuType',
    'methods' => 'requireWith:api_url|checkMethodType',
    'router_path' => 'requireIf:menu_type,1',
    'view_path' => 'requireIf:menu_type,1'
];
```

#### 常用验证规则

- `require`：必填
- `requireWith:field`：当字段存在时必填
- `requireIf:field,value`：当字段等于某值时必填
- `unique:table`：唯一性验证

### 7.3 错误消息规范

```php
protected $message = [
    'role_name.require' => 'validate_role.role_name_require',
    'menu_name.require' => 'validate_menu.menu_name_require',
    'router_path.requireIf' => 'validate_menu.router_path_requireif',
    'methods.requireWith' => 'validate_menu.methods_requirewith',
];
```

### 7.4 验证场景规范

```php
protected $scene = [
    'add' => ['menu_name', 'menu_type', 'menu_key', 'router_path', 'view_path', 'methods'],
    'edit' => ['menu_name', 'menu_type', 'router_path', 'view_path', 'methods'],
];
```

***

## 八、字典编码规范

### 8.1 字典基础结构

```php
namespace app\dict\sys;

use app\dict\BaseDict;

/**
 * 用户组状态字典
 * Class RoleStatusDict
 * @package app\dict\sys
 */
class RoleStatusDict extends BaseDict
{
    public const ON = 1;
    public const OFF = 0;

    /**
     * 获取用户组状态
     * @return array
     */
    public static function getStatus()
    {
        return [
            self::ON => get_lang('dict_role.status_on'),
            self::OFF => get_lang('dict_role.status_off'),
        ];
    }
}
```

### 8.2 常量定义规范

```php
public const ON = 1;
public const OFF = 0;
public const LIST = '0';
public const MENU = '1';
public const BUTTON = '2';
```

### 8.3 字典方法规范

```php
/**
 * 菜单类型
 * @return array
 */
public static function getMenuType()
{
    return [
        self::LIST => get_lang('dict_menu.type_list'),
        self::MENU => get_lang('dict_menu.type_menu'),
        self::BUTTON => get_lang('dict_menu.type_button'),
    ];
}

/**
 * 菜单状态
 * @return array
 */
public static function getStatus()
{
    return [
        self::ON => get_lang('dict_menu.status_on'),
        self::OFF => get_lang('dict_menu.status_off'),
    ];
}
```

***

## 九、通用编码规范

### 9.1 返回值规范

```php
// 成功返回
return success($data);
return success('ADD_SUCCESS');
return success(data: $data);

// 失败返回
return fail('FAIL');
return fail('ERROR_MESSAGE');
```

### 9.2 异常处理规范

```php
use core\exception\AdminException;

// 抛出异常
throw new AdminException('USER_ROLE_NOT_EXIST');
throw new AdminException('ADD_FAIL');
throw new AdminException('MENU_NOT_ALLOW_DELETE');
```

### 9.3 条件判断规范

```php
// 判断是否为空
if (empty($data['role_name'])) {
}

// 判断是否相等
if ($value != 'all') {
}

// 判断是否存在
if (isset($data['role_name'])) {
}

// 多条件判断
if ($start_time > 0 && $end_time > 0) {
} else if ($start_time > 0 && $end_time == 0) {
} else if ($start_time == 0 && $end_time > 0) {
}
```

### 9.4 PHP 8+ 新特性使用（API控制器）

```php
// match表达式
$openid_field = match ($this->request->getChannel()) {
    'wechat' => 'wx_openid',
    'weapp' => 'weapp_openid',
    default => ''
};

// 命名参数
return success(data: $data);
```

***

## 十、开发流程总结

### 10.1 开发新功能的步骤

1. **创建数据库表** - 设计表结构和字段
2. **创建模型** - `app/model/{模块}/`
3. **创建字典** - `app/dict/{模块}/`
4. **创建验证器** - `app/validate/{模块}/`
5. **创建服务** - `app/service/{应用}/{模块}/`
6. **创建控制器** - `app/{应用}api/controller/{模块}/`
7. **配置路由** - `app/{应用}api/route/{模块}.php`

### 10.2 AdminAPI vs API 开发要点

| 开发要点            | AdminAPI                               | API                                  |
| --------------- | -------------------------------------- | ------------------------------------ |
| **基类**          | `BaseAdminController`                  | `BaseApiController`                  |
| **命名空间**        | `app\adminapi\controller\{模块}`         | `app\api\controller\{模块}`            |
| **Service命名空间** | `app\service\admin\{模块}`               | `app\service\api\{模块}`               |
| **参数获取**        | `$this->request->params()`             | `$this->request->params()`           |
| **会员ID获取**      | 不适用                                    | `$this->request->memberId()`         |
| **验证器路径**       | `app\validate\{模块}\{类名}`               | `app\validate\{模块}\{类名}`             |
| **返回成功**        | `success()` 或 `success('ADD_SUCCESS')` | `success()` 或 `success(data: $data)` |
| **路径参数**        | 常用（如 `$role_id`）                       | 较少使用                                 |
| **批量操作**        | 常用                                     | 较少使用                                 |
| **导出功能**        | 常用                                     | 不适用                                  |
| **PHP特性**       | 基础语法                                   | 使用 `match` 等新特性                      |

### 10.3 UID 获取方式总结

| 方式                              | 说明                     | 推荐度          | 适用场景 |
| ------------------------------- | ---------------------- | ------------ | ---- |
| `$this->request->uid()`         | 从 Request 对象获取当前登录用户ID | AdminAPI 控制器 | ⭐⭐⭐⭐ |
| `$this->request->memberId()`    | 获取会员ID                 | API 控制器      | ⭐⭐   |
| `$this->request->params('uid')` | 从请求参数获取                | 所有控制器        | ⭐⭐   |
| `static::$auth_info['uid']`     | 访问静态属性                 | 不推荐          | ❌    |

***

**End of Document**
