name: "niucloud-code-generator"
description: "提供NiuCloud系统一键生成增删改查代码功能，包括控制器、模型、服务、验证器等完整CRUD代码。触发关键词：代码生成、CRUD、增删改查、生成器、自动生成、快速开发、代码模板、生成代码。在需要快速生成业务代码时调用此技能。"
---

# NiuCloud 一键生成增删改查代码指南

> 本指南介绍如何使用NiuCloud代码生成器一键生成完整的增删改查（CRUD）代码，提高开发效率。

## 📋 快速导航

- [一、功能概述](#一功能概述)
- [二、生成步骤](#二生成步骤)
- [三、生成的文件结构](#三生成的文件结构)
- [四、生成的代码示例](#四生成的代码示例)
- [五、自定义生成规则](#五自定义生成规则)
- [六、常见问题](#六常见问题)

---

## 一、功能概述

### 1.1 核心功能

代码生成器可以一键生成以下完整的CRUD代码：

#### 后端代码
1. **后台API控制器**：包含列表、详情、新增、编辑、删除等接口
2. **数据模型**：数据库表对应的Model类
3. **业务服务**：处理业务逻辑的Service类
4. **数据验证器**：表单验证规则
5. **后台API路由**：自动注册接口路由
6. **菜单SQL脚本**：生成后台管理菜单

#### 前端代码
7. **前端API接口**：前端调用的API封装
8. **前端列表页面**：自动生成数据展示页面（Vue3 + Element Plus）
9. **前端编辑页面**：自动生成表单编辑页面（Vue3 + Element Plus）
10. **前端语言包**：多语言支持
11. **前端字典数据**：自动处理字典数据关联

### 1.2 技术特点

- **零配置**：只需选择数据表即可生成完整代码
- **高度定制**：支持自定义字段属性、验证规则
- **规范统一**：生成的代码遵循NiuCloud编码规范
- **无缝集成**：生成的代码可直接运行

---

## 二、生成步骤

### 2.1 基本流程

```
1. 登录NiuCloud后台管理系统
2. 进入"系统工具" → "代码生成器"
3. 选择要生成代码的数据表
4. 配置生成参数：
   - 模块名：代码所属模块
   - 类名：生成的类名（默认表名）
   - 编辑类型：选择生成的页面类型
   - 字段配置：设置字段的显示、搜索、验证等属性
5. 点击"生成代码"按钮
6. 下载生成的代码包或直接生成到项目中
```

### 2.2 详细配置说明

#### 字段配置

| 配置项 | 说明 |
|-------|------|
| 字段名称 | 数据库字段名 |
| 字段注释 | 字段显示名称 |
| 字段类型 | 数据库字段类型 |
| 是否主键 | 是否为主键字段 |
| 是否显示 | 是否在列表页面显示 |
| 是否搜索 | 是否作为搜索条件 |
| 是否插入 | 是否允许新增时填写 |
| 是否更新 | 是否允许编辑时修改 |
| 验证规则 | 表单验证规则（必填、长度、格式等） |
| 视图类型 | 前端表单控件类型（输入框、下拉框、日期选择器等） |

---

## 三、生成的文件结构

### 3.1 后端文件结构

```
backend/app/
├── adminapi/controller/{模块}/
│   └── {类名}.php          # 后台API控制器
├── model/{模块}/
│   └── {类名}.php          # 数据模型
├── service/admin/{模块}/
│   └── {类名}Service.php   # 业务服务
├── validate/{模块}/
│   └── {类名}.php          # 数据验证器
└── route/adminapi/
    └── {模块}.php          # 后台API路由
```

### 3.2 前端文件结构

```
frontend/src/
├── api/{模块}/
│   └── {类名}.js           # 前端API接口
├── views/{模块}/
│   ├── {类名}-index.vue    # 列表页面
│   └── {类名}-edit.vue     # 编辑页面
└── lang/modules/
    └── {模块}.js           # 语言包
```

---

## 四、生成的代码示例

### 4.1 后台API控制器示例

```php
<?php
// +----------------------------------------------------------------------
// | Niucloud-Lite-Ai 企业快速开发的管理平台
// +----------------------------------------------------------------------

namespace app\adminapi\controller\product;

use core\base\BaseAdminController;
use app\service\admin\product\ProductService;

/**
 * 商品管理控制器
 * Class Product
 * @package app\adminapi\controller\product
 */
class Product extends BaseAdminController
{
    protected $product_service;

    public function __construct(App $app)
    {
        parent::__construct($app);
        $this->product_service = new ProductService();
    }

    /**
     * 商品列表
     * @return Response
     */
    public function lists()
    {
        $data = $this->request->params([
            ["product_name", ""],
            ["category_id", ""],
            ["create_time", ["", ""]]
        ]);
        return success($this->product_service->getPage($data));
    }

    /**
     * 商品详情
     * @param int $id
     * @return Response
     */
    public function info(int $id)
    {
        return success($this->product_service->getInfo($id));
    }

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

    /**
     * 编辑商品
     * @param int $id
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

    /**
     * 删除商品
     * @param int $id
     * @return Response
     */
    public function del(int $id)
    {
        $this->product_service->del($id);
        return success('DELETE_SUCCESS');
    }
}
```

### 4.2 业务服务示例

```php
<?php
// +----------------------------------------------------------------------
// | Niucloud-Lite-Ai 企业快速开发的管理平台
// +----------------------------------------------------------------------

namespace app\service\admin\product;

use app\model\product\Product;
use core\base\BaseAdminService;

/**
 * 商品管理服务
 * Class ProductService
 * @package app\service\admin\product
 */
class ProductService extends BaseAdminService
{
    protected $product_model;

    public function __construct()
    {
        parent::__construct();
        $this->product_model = new Product();
    }

    /**
     * 获取商品列表
     * @param array $where
     * @return array
     */
    public function getPage(array $where = [])
    {
        $field = 'id,product_name,category_id,price,stock,create_time';
        $order = 'create_time desc';
        $search_model = $this->product_model->withSearch(['product_name', 'category_id', 'create_time'], $where)->field($field)->order($order);
        return $this->pageQuery($search_model);
    }

    /**
     * 获取商品详情
     * @param int $id
     * @return array
     */
    public function getInfo(int $id)
    {
        return $this->product_model->where([['id', '=', $id]])->findOrEmpty()->toArray();
    }

    /**
     * 新增商品
     * @param array $data
     * @return int
     */
    public function add(array $data)
    {
        return $this->product_model->save($data);
    }

    /**
     * 编辑商品
     * @param int $id
     * @param array $data
     * @return bool
     */
    public function edit(int $id, array $data)
    {
        return $this->product_model->where([['id', '=', $id]])->save($data);
    }

    /**
     * 删除商品
     * @param int $id
     * @return bool
     */
    public function del(int $id)
    {
        return $this->product_model->where([['id', '=', $id]])->delete();
    }
}
```

### 4.3 前端列表页面示例

```vue
<template>
    <div class="main-container">
        <el-card class="box-card !border-none" shadow="never">
            <div class="flex justify-between items-center">
                <span class="text-lg">{{ pageName }}</span>
                <el-button type="primary" @click="addEvent">
                    {{ t('addProduct') }}
                </el-button>
            </div>

            <el-card class="box-card !border-none my-[10px] table-search-wrap" shadow="never">
                <el-form :inline="true" :model="productTable.searchParam" ref="searchFormRef">
                    <el-form-item label="商品名称">
                        <el-input v-model="productTable.searchParam.product_name" placeholder="请输入商品名称" />
                    </el-form-item>
                    <el-form-item label="分类">
                        <el-select v-model="productTable.searchParam.category_id" placeholder="请选择分类">
                            <el-option v-for="item in categoryDict" :key="item.value" :label="item.label" :value="item.value" />
                        </el-select>
                    </el-form-item>
                    <el-form-item label="创建时间">
                        <el-date-picker v-model="productTable.searchParam.create_time" type="daterange" range-separator="至" start-placeholder="开始日期" end-placeholder="结束日期" />
                    </el-form-item>
                    <el-form-item>
                        <el-button type="primary" @click="loadProductList()">{{ t('search') }}</el-button>
                        <el-button @click="resetForm(searchFormRef)">{{ t('reset') }}</el-button>
                    </el-form-item>
                </el-form>
            </el-card>

            <div class="mt-[10px]">
                <el-table :data="productTable.data" size="large" v-loading="productTable.loading">
                    <template #empty>
                        <span>{{ !productTable.loading ? t('emptyData') : '' }}</span>
                    </template>
                    <el-table-column prop="product_name" label="商品名称" min-width="150" />
                    <el-table-column prop="category_id" label="分类" min-width="100">
                        <template #default="{ row }">
                            {{ getDictLabel(categoryDict, row.category_id) }}
                        </template>
                    </el-table-column>
                    <el-table-column prop="price" label="价格" min-width="100" />
                    <el-table-column prop="stock" label="库存" min-width="100" />
                    <el-table-column prop="create_time" label="创建时间" min-width="150" />
                    <el-table-column :label="t('operation')" fixed="right" min-width="120">
                        <template #default="{ row }">
                            <el-button type="primary" link @click="editEvent(row)">{{ t('edit') }}</el-button>
                            <el-button type="primary" link @click="deleteEvent(row.id)">{{ t('delete') }}</el-button>
                        </template>
                    </el-table-column>
                </el-table>
                <div class="mt-[16px] flex justify-end">
                    <el-pagination v-model:current-page="productTable.page" v-model:page-size="productTable.limit"
                        layout="total, sizes, prev, pager, next, jumper" :total="productTable.total"
                        @size-change="loadProductList()" @current-change="loadProductList" />
                </div>
            </div>

            <Edit ref="editProductDialog" @complete="loadProductList" />
        </el-card>
    </div>
</template>

<script lang="ts" setup>
import { reactive, ref, watch } from 'vue'
import { t } from '@/lang'
import { useDictionary } from '@/api/dict'
import { getProductList, deleteProduct } from '@/api/product'
import { img } from '@/utils/common'
import { ElMessageBox, FormInstance } from 'element-plus'
import Edit from '@/views/product/components/product-edit.vue'
import { useRoute } from 'vue-router'
const route = useRoute()
const pageName = route.meta.title

let productTable = reactive({
    page: 1,
    limit: 10,
    total: 0,
    loading: true,
    data: [],
    searchParam: {
        product_name: '',
        category_id: '',
        create_time: []
    }
})

const searchFormRef = ref<FormInstance>()

// 字典数据
const categoryDict = ref<any[]>([])
useDictionary('category', categoryDict)

/**
 * 获取商品列表
 */
const loadProductList = (page: number = 1) => {
    productTable.loading = true
    productTable.page = page

    getProductList({
        page: productTable.page,
        limit: productTable.limit,
        ...productTable.searchParam
    }).then(res => {
        productTable.loading = false
        productTable.data = res.data.data
        productTable.total = res.data.total
    }).catch(() => {
        productTable.loading = false
    })
}
loadProductList()

const editProductDialog: Record<string, any> | null = ref(null)

/**
 * 添加商品
 */
const addEvent = () => {
    editProductDialog.value.setFormData()
    editProductDialog.value.showDialog = true
}

/**
 * 编辑商品
 * @param data
 */
const editEvent = (data: any) => {
    editProductDialog.value.setFormData(data)
    editProductDialog.value.showDialog = true
}

/**
 * 删除商品
 */
const deleteEvent = (id: number) => {
    ElMessageBox.confirm(t('productDeleteTips'), t('warning'), {
        confirmButtonText: t('confirm'),
        cancelButtonText: t('cancel'),
        type: 'warning'
    }).then(() => {
        deleteProduct(id).then(() => {
            loadProductList()
        }).catch(() => {})
    })
}

const resetForm = (formEl: FormInstance | undefined) => {
    if (!formEl) return
    formEl.resetFields()
    loadProductList()
}
</script>
```

### 4.4 前端编辑页面示例

```vue
<template>
    <el-dialog v-model="showDialog" :title="formData.id ? t('editProduct') : t('addProduct')" width="600px" append-to-body>
        <el-form ref="formRef" :model="formData" :rules="rules" label-width="100px">
            <el-form-item label="商品名称" prop="product_name">
                <el-input v-model="formData.product_name" placeholder="请输入商品名称" />
            </el-form-item>
            <el-form-item label="分类" prop="category_id">
                <el-select v-model="formData.category_id" placeholder="请选择分类">
                    <el-option v-for="item in categoryDict" :key="item.value" :label="item.label" :value="item.value" />
                </el-select>
            </el-form-item>
            <el-form-item label="价格" prop="price">
                <el-input v-model="formData.price" placeholder="请输入价格" type="number" />
            </el-form-item>
            <el-form-item label="库存" prop="stock">
                <el-input v-model="formData.stock" placeholder="请输入库存" type="number" />
            </el-form-item>
        </el-form>
        <template #footer>
            <div class="dialog-footer">
                <el-button @click="showDialog = false">{{ t('cancel') }}</el-button>
                <el-button type="primary" @click="submitForm()">{{ t('confirm') }}</el-button>
            </div>
        </template>
    </el-dialog>
</template>

<script lang="ts" setup>
import { reactive, ref } from 'vue'
import { t } from '@/lang'
import { useDictionary } from '@/api/dict'
import { addProduct, editProduct, getProductInfo } from '@/api/product'
import { ElMessage } from 'element-plus'

const emit = defineEmits(['complete'])

const showDialog = ref(false)
const formRef = ref()

// 字典数据
const categoryDict = ref<any[]>([])
useDictionary('category', categoryDict)

const formData = reactive({
    id: 0,
    product_name: '',
    category_id: '',
    price: '',
    stock: ''
})

const rules = {
    product_name: [{ required: true, message: '请输入商品名称', trigger: 'blur' }],
    category_id: [{ required: true, message: '请选择分类', trigger: 'change' }],
    price: [{ required: true, message: '请输入价格', trigger: 'blur' }],
    stock: [{ required: true, message: '请输入库存', trigger: 'blur' }]
}

const setFormData = (data: any = {}) => {
    formData.id = data.id || 0
    formData.product_name = data.product_name || ''
    formData.category_id = data.category_id || ''
    formData.price = data.price || ''
    formData.stock = data.stock || ''
    showDialog.value = true
}

const submitForm = () => {
    formRef.value.validate((valid: boolean) => {
        if (valid) {
            const promise = formData.id ? editProduct(formData.id, formData) : addProduct(formData)
            promise.then(() => {
                ElMessage.success(t('operateSuccess'))
                showDialog.value = false
                emit('complete')
            }).catch(() => {})
        }
    })
}

defineExpose({
    setFormData,
    showDialog
})
</script>
```

---

## 五、自定义生成规则

### 5.1 修改模板文件

可以通过修改VM模板文件来自定义生成的代码风格：

```
backend/app/service/admin/generator/vm/
├── controller.vm         # 控制器模板
├── model.vm              # 模型模板
├── service.vm            # 服务模板
├── validate.vm           # 验证器模板
└── ...
```

### 5.2 自定义字段属性

在生成代码时，可以为每个字段配置：

- **显示名称**：前端展示的字段名
- **验证规则**：必填、长度、格式等验证
- **视图类型**：输入框、下拉框、日期选择器等
- **搜索类型**：精确搜索、模糊搜索、范围搜索

### 5.3 扩展生成器

可以通过继承BaseGenerator类来扩展生成器功能：

```php
namespace app\service\admin\generator\core;

use app\service\admin\generator\core\BaseGenerator;

class CustomGenerator extends BaseGenerator
{
    // 自定义生成逻辑
}
```

---

## 六、常见问题

### 6.1 如何修改生成的代码风格？

修改对应的VM模板文件即可，例如：
- 修改控制器模板：`vm/controller.vm`
- 修改模型模板：`vm/model.vm`
- 修改服务模板：`vm/service.vm`

### 6.2 如何新增生成的文件类型？

1. 创建新的生成器类继承BaseGenerator
2. 创建对应的VM模板文件
3. 在GenerateService中注册新的生成器

### 6.3 生成的代码如何与现有系统集成？

生成的代码遵循NiuCloud编码规范，可以直接集成到现有系统中：

1. 将生成的文件复制到对应目录
2. 运行菜单SQL脚本创建后台菜单
3. 配置路由（自动生成）
4. 重启系统即可使用

---

## 📚 参考资料

- [NiuCloud 官方文档](https://www.niucloud.com/docs)
- [ThinkPHP 6.0 文档](https://www.thinkphp.cn/doc/6.0)

---

> 本指南基于NiuCloud代码生成器模块的实际功能总结，如有变动请以实际系统为准。