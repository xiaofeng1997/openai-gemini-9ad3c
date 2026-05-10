name: "niucloud-admin-vue-coding-standards"
description: "提供NiuCloud系统管理端Vue3编码规范，包括组件结构、API调用、样式编写、国际化等完整开发标准。触发关键词：Vue3、前端、管理端、Admin、Element Plus、组件开发、页面开发、前端编码、Vue编码、Admin编码。在开发Admin端Vue功能时调用此技能。"
-----------------------------------------------------------------------------------------

# NiuCloud Admin Vue 编码规范

> 本规范基于 NiuCloud 系统管理端的实际代码分析总结，提供完整的 Vue3 + TypeScript 编码标准。

## 📋 快速导航

- [一、技术栈](#一技术栈)
- [二、项目结构](#二项目结构)
- [三、页面基础结构](#三页面基础结构)
- [四、组件开发规范](#四组件开发规范)
- [五、API调用规范](#五api调用规范)
- [六、表单开发规范](#六表单开发规范)
- [七、表格开发规范](#七表格开发规范)
- [八、对话框开发规范](#八对话框开发规范)
- [九、样式编写规范](#九样式编写规范)
- [十、国际化规范](#十国际化规范)
- [十一、完整示例](#十一完整示例)

***

## 一、技术栈

### 1.1 核心技术

| 技术           | 版本     | 用途      |
| ------------ | ------ | ------- |
| Vue          | 3.2.45 | 前端框架    |
| TypeScript   | 4.9.5  | 类型系统    |
| Element Plus | 2.7.4  | UI组件库   |
| Vue Router   | 4.1.6  | 路由管理    |
| Pinia        | 2.0.30 | 状态管理    |
| Vite         | 4.1.0  | 构建工具    |
| Tailwind CSS | 3.2.4  | CSS框架   |
| Sass         | 1.58.0 | CSS预处理器 |
| Axios        | 1.4.0  | HTTP请求  |
| Vue I18n     | 9.2.2  | 国际化     |

### 1.2 依赖库

```json
{
  "dependencies": {
    "@element-plus/icons-vue": "2.0.10",
    "@vueuse/core": "9.12.0",
    "axios": "1.4.0",
    "echarts": "5.4.1",
    "element-plus": "^2.7.4",
    "lodash-es": "4.17.21",
    "pinia": "2.0.30",
    "vue": "3.2.45",
    "vue-i18n": "9.2.2",
    "vue-router": "4.1.6"
  }
}
```

***

## 二、项目结构

### 2.1 目录结构

```
src/
├── api/                    # API接口定义
│   ├── sys.ts             # 系统相关API
│   ├── auth.ts            # 认证相关API
│   └── member.ts         # 会员相关API
├── assets/                # 静态资源
│   └── images/            # 图片资源
├── components/            # 公共组件
│   ├── upload-image/      # 图片上传组件
│   ├── upload-file/       # 文件上传组件
│   └── select-area/       # 地区选择组件
├── lang/                  # 国际化文件
│   ├── zh-cn/            # 中文语言包
│   └── en/               # 英文语言包
├── stores/                # Pinia状态管理
│   ├── modules/
│   │   ├── user.ts       # 用户状态
│   │   └── system.ts     # 系统状态
├── utils/                 # 工具函数
│   ├── request.ts        # 请求封装
│   ├── common.ts         # 通用函数
│   └── storage.ts        # 本地存储
├── views/                 # 页面视图
│   ├── auth/             # 认证管理
│   ├── member/           # 会员管理
│   └── setting/          # 系统设置
└── App.vue               # 根组件
```

### 2.2 文件命名规范

- **页面文件**：小写+连字符，如 `role.vue`、`member.vue`
- **组件文件**：小写+连字符，如 `upload-image/index.vue`
- **API文件**：小写+下划线，如 `sys.ts`、`auth.ts`
- **语言文件**：小写+下划线，如 `common.json`
- **类型文件**：小写+连字符，如 `user.d.ts`

***

## 三、页面基础结构

### 3.1 标准页面模板

**推荐写法（代码生成器风格）：**

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
                    <!-- 搜索表单 -->
                </el-form>
            </el-card>

            <div class="mt-[10px]">
                <el-table :data="productTable.data" size="large" v-loading="productTable.loading">
                    <!-- 表格内容 -->
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
</script>
```

**基础模板：**

```vue
<template>
    <div class="main-container">
        <el-card class="box-card !border-none" shadow="never">
            <!-- 页面内容 -->
        </el-card>
    </div>
</template>

<script lang="ts" setup>
import { ref, reactive, onMounted } from 'vue'
import { t } from '@/lang'
import { useRoute } from 'vue-router'

const route = useRoute()
const pageName = route.meta.title

onMounted(() => {
    // 页面初始化逻辑
})
</script>

<style lang="scss" scoped>
</style>
```

### 3.2 页面头部结构

```vue
<div class="flex justify-between items-center">
    <span class="text-page-title">{{ pageName }}</span>
</div>
```

### 3.3 搜索表单结构

```vue
<div class="flex justify-between items-center mt-[20px]">
    <el-form :inline="true" :model="searchParam" ref="searchFormRef">
        <el-form-item :label="t('keyword')" prop="keyword">
            <el-input v-model.trim="searchParam.keyword" class="w-[240px]" :placeholder="t('keywordPlaceholder')" />
        </el-form-item>
        <el-form-item>
            <el-button type="primary" @click="loadList()">{{ t('search') }}</el-button>
            <el-button @click="resetForm(searchFormRef)">{{ t('reset') }}</el-button>
        </el-form-item>
    </el-form>
    <el-button type="primary" class="w-[100px] self-start" @click="addEvent">{{ t('add') }}</el-button>
</div>
```

***

## 四、组件开发规范

### 4.1 组件基础结构

```vue
<template>
    <div class="component-name">
        <!-- 组件内容 -->
    </div>
</template>

<script lang="ts" setup>
import { ref, reactive, computed, watch } from 'vue'
import { t } from '@/lang'

// Props定义
interface Props {
    modelValue: any
    disabled?: boolean
}

const props = withDefaults(defineProps<Props>(), {
    disabled: false
})

// Emits定义
const emit = defineEmits<{
    'update:modelValue': [value: any]
    'change': [value: any]
}>()

// 响应式数据
const data = ref<any>(null)

// 计算属性
const computedValue = computed(() => {
    return props.modelValue
})

// 监听
watch(() => props.modelValue, (newVal) => {
    data.value = newVal
})

// 方法
const handleChange = (value: any) => {
    emit('update:modelValue', value)
    emit('change', value)
}
</script>

<style lang="scss" scoped>
.component-name {
    // 组件样式
}
</style>
```

### 4.2 组件命名规范

- **组件名**：使用PascalCase，如 `UploadImage`、`SelectArea`
- **文件名**：使用kebab-case，如 `upload-image/index.vue`
- **组件引用**：使用PascalCase，如 `<UploadImage />`

### 4.3 组件Props规范

```typescript
interface Props {
    modelValue: any           // v-model绑定的值
    disabled?: boolean        // 是否禁用
    placeholder?: string      // 占位符
    maxlength?: number        // 最大长度
    showWordLimit?: boolean  // 显示字数统计
}

const props = withDefaults(defineProps<Props>(), {
    disabled: false,
    placeholder: '',
    maxlength: 0,
    showWordLimit: false
})
```

### 4.4 组件Emits规范

```typescript
const emit = defineEmits<{
    'update:modelValue': [value: any]    // v-model更新
    'change': [value: any]              // 值变化
    'confirm': [data: any]              // 确认事件
    'cancel': []                        // 取消事件
}>()
```

***

## 五、API调用规范

### 5.1 API文件结构

**推荐写法（代码生成器风格）：**

```typescript
import request from '@/utils/request'

/**
 * 获取商品列表
 * @param params 查询参数
 */
export function getProductList(params: Record<string, any>) {
    return request.get('product', { params })
}

/**
 * 获取商品详情
 * @param id ID
 */
export function getProductInfo(id: number) {
    return request.get(`product/${id}`)
}

/**
 * 新增商品
 * @param params 数据参数
 */
export function addProduct(params: Record<string, any>) {
    return request.post('product', params)
}

/**
 * 编辑商品
 * @param id ID
 * @param params 数据参数
 */
export function editProduct(id: number, params: Record<string, any>) {
    return request.put(`product/${id}`, params)
}

/**
 * 删除商品
 * @param id ID
 */
export function deleteProduct(id: number) {
    return request.delete(`product/${id}`)
}
```

**传统写法：**

```typescript
import request from '@/utils/request'

/**
 * 获取列表
 * @param params 查询参数
 */
export function getList(params: Record<string, any>) {
    return request.get('sys/role', { params })
}

/**
 * 获取详情
 * @param id ID
 */
export function getInfo(id: number) {
    return request.get(`sys/role/${id}`)
}

/**
 * 添加数据
 * @param params 数据参数
 */
export function add(params: Record<string, any>) {
    return request.post('sys/role', params, { showSuccessMessage: true })
}

/**
 * 编辑数据
 * @param id ID
 * @param params 数据参数
 */
export function edit(id: number, params: Record<string, any>) {
    return request.put(`sys/role/${id}`, params, { showSuccessMessage: true })
}

/**
 * 删除数据
 * @param id ID
 */
export function del(id: number) {
    return request.delete(`sys/role/${id}`, { showSuccessMessage: true })
}

/**
 * 修改状态
 * @param id ID
 * @param params 状态参数
 */
export function modifyStatus(id: number, params: Record<string, any>) {
    return request.put(`sys/role/modifyStatus/${id}`, params, { showSuccessMessage: true })
}
```

**API路径规范说明：**

1. **路径一致性原则**：前端 API 路径必须与后端路由路径完全一致
2. **路由路径对照**：
   - 后端路由：`Route::get('goods/:id', 'inventory.Goods/info')`
   - 前端 API：`request.get('inventory/goods/${id}')`
3. **HTTP方法对应**：
   - `GET`：查询操作（列表、详情）
   - `POST`：新增操作
   - `PUT`：更新操作（编辑、修改状态、排序等）
   - `DELETE`：删除操作
4. **路径参数规范**：
   - 路由使用 `:id` 参数时，前端使用模板字符串 `${id}`
   - 错误示例：`request.get('goods/info', { params: { goods_id: id } })` ❌
   - 正确示例：`request.get('inventory/goods/${id}')` ✅
5. **常见路径格式**：
   - 列表：`inventory/goods`（使用查询参数）
   - 详情：`inventory/goods/${id}`（使用路径参数）
   - 新增：`inventory/goods`（POST方法）
   - 编辑：`inventory/goods/${id}`（PUT方法）
   - 删除：`inventory/goods/${id}`（DELETE方法）
   - 修改状态：`inventory/goods/modifyStatus/${id}`（PUT方法）
   - 排序：`inventory/goods/sort/${id}`（PUT方法）
6. **参数传递方式**：
   - 查询参数：使用 `{ params }` 对象，如 `request.get('inventory/goods', { params })`
   - 路径参数：直接拼接在 URL 中，如 `request.get('inventory/goods/${id}')`
   - 请求体：直接传递对象，如 `request.post('inventory/goods', formData)`
7. **重要提示**：
   - 不要在 API 路径中添加 `/lists`、`/info`、`/add`、`/edit`、`/delete` 等后缀
   - 路由中定义的路径是什么，前端 API 就使用什么路径
   - 始终参考后端路由文件 `backend/app/adminapi/route/{模块}.php` 来编写前端 API

### 5.2 请求配置

```typescript
// 显示成功消息
return request.get('sys/role', { showSuccessMessage: true })

// 不显示错误消息
return request.get('sys/role', { showErrorMessage: false })

// 自定义配置
return request.get('sys/role', {
    showSuccessMessage: true,
    showErrorMessage: true
})
```

### 5.3 API调用示例

**推荐写法（代码生成器风格）：**

```typescript
import { getProductList, deleteProduct } from '@/api/product'

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
```

**传统写法：**

```typescript
import { getList, add, edit, del, modifyStatus } from '@/api/sys'

// 获取列表
const loadList = async () => {
    loading.value = true
    try {
        const res = await getList({
            page: page.value,
            limit: limit.value,
            keyword: searchParam.keyword
        })
        tableData.value = res.data.data
        total.value = res.data.total
    } catch (error) {
        console.error(error)
    } finally {
        loading.value = false
    }
}

// 添加数据
const handleAdd = async () => {
    try {
        await add(formData)
        loadList()
    } catch (error) {
        console.error(error)
    }
}
```

***

## 六、表单开发规范

### 6.1 表单基础结构

```vue
<el-form :model="formData" label-width="150px" ref="formRef" :rules="formRules" v-loading="loading">
    <el-form-item :label="t('fieldName')" prop="field_name">
        <el-input v-model.trim="formData.field_name" :placeholder="t('fieldNamePlaceholder')" class="input-width" clearable />
    </el-form-item>
</el-form>
```

### 6.2 表单数据定义

```typescript
const formData = reactive<Record<string, any>>({
    field_name: '',
    field_type: '',
    status: 1,
    create_time: ''
})
```

### 6.3 表单验证规则

```typescript
import type { FormInstance, FormRules } from 'element-plus'

const formRef = ref<FormInstance>()

const formRules = reactive<FormRules>({
    field_name: [
        { required: true, message: t('fieldNamePlaceholder'), trigger: 'blur' },
        { min: 2, max: 20, message: t('fieldNameLengthError'), trigger: 'blur' }
    ],
    field_type: [
        { required: true, message: t('fieldTypePlaceholder'), trigger: 'change' }
    ]
})
```

### 6.4 表单提交

```typescript
const save = async (formEl: FormInstance | undefined) => {
    if (loading.value || !formEl) return

    await formEl.validate(async (valid) => {
        if (valid) {
            loading.value = true
            try {
                await add(formData)
                loading.value = false
            } catch (error) {
                loading.value = false
            }
        }
    })
}
```

### 6.5 表单重置

```typescript
const resetForm = (formEl: FormInstance | undefined) => {
    if (!formEl) return
    formEl.resetFields()
    loadList()
}
```

### 6.6 常用表单组件

#### 输入框

```vue
<el-input v-model.trim="formData.field_name" :placeholder="t('fieldNamePlaceholder')" class="input-width" clearable maxlength="20" show-word-limit />
```

#### 文本域

```vue
<el-input v-model.trim="formData.desc" type="textarea" :rows="4" clearable :placeholder="t('descPlaceholder')" class="input-width" maxlength="100" show-word-limit />
```

#### 数字输入

```vue
<el-input-number v-model="formData.sort" :min="0" :max="999" controls-position="right" />
```

#### 选择器

```vue
<el-select v-model="formData.status" :placeholder="t('statusPlaceholder')" clearable>
    <el-option :label="t('statusNormal')" :value="1" />
    <el-option :label="t('statusDeactivate')" :value="0" />
</el-select>
```

#### 开关

```vue
<el-switch v-model="formData.is_show" :active-value="1" :inactive-value="0" />
```

#### 单选框

```vue
<el-radio-group v-model="formData.status">
    <el-radio :label="1">{{ t('startUsing') }}</el-radio>
    <el-radio :label="0">{{ t('statusDeactivate') }}</el-radio>
</el-radio-group>
```

#### 复选框

```vue
<el-checkbox-group v-model="formData.tags">
    <el-checkbox :label="1">{{ t('tag1') }}</el-checkbox>
    <el-checkbox :label="2">{{ t('tag2') }}</el-checkbox>
</el-checkbox-group>
```

#### 日期选择

```vue
<el-date-picker v-model="formData.create_time" type="daterange" range-separator="-" start-placeholder="开始日期" end-placeholder="结束日期" />
```

#### 图片上传

```vue
<upload-image v-model="formData.image" />
```

#### 文件上传

```vue
<upload-file v-model="formData.file" />
```

#### 地区选择

```vue
<select-area v-model="formData.area_id" />
```

***

## 七、表格开发规范

### 7.1 表格基础结构

```vue
<el-table :data="tableData" size="large" v-loading="loading">
    <template #empty>
        <span>{{ !loading ? t('emptyData') : '' }}</span>
    </template>
    <el-table-column prop="field_name" :label="t('fieldName')" />
    <el-table-column :label="t('status')">
        <template #default="{ row }">
            <el-tag type="success" v-if="row.status == 1">{{ t('statusNormal') }}</el-tag>
            <el-tag type="error" v-else>{{ t('statusDeactivate') }}</el-tag>
        </template>
    </el-table-column>
    <el-table-column prop="create_time" :label="t('createTime')"></el-table-column>
    <el-table-column :label="t('operation')" align="right" fixed="right" width="130">
        <template #default="{ row }">
            <el-button type="primary" link @click="editEvent(row)">{{ t('edit') }}</el-button>
            <el-button type="primary" link @click="deleteEvent(row.id)">{{ t('delete') }}</el-button>
        </template>
    </el-table-column>
</el-table>
```

### 7.2 表格数据定义

```typescript
const tableData = reactive({
    page: 1,
    limit: 10,
    total: 0,
    loading: true,
    data: []
})
```

### 7.3 表格分页

```vue
<div class="mt-[16px] flex justify-end">
    <el-pagination
        v-model:current-page="tableData.page"
        v-model:page-size="tableData.limit"
        layout="total, sizes, prev, pager, next, jumper"
        :total="tableData.total"
        @size-change="loadList()"
        @current-change="loadList"
    />
</div>
```

### 7.4 表格操作列

```vue
<el-table-column :label="t('operation')" align="right" fixed="right" width="130">
    <template #default="{ row }">
        <el-button type="primary" link @click="editEvent(row)">{{ t('edit') }}</el-button>
        <el-button type="primary" link @click="deleteEvent(row.id)">{{ t('delete') }}</el-button>
    </template>
</el-table-column>
```

### 7.5 表格状态列

```vue
<el-table-column :label="t('status')">
    <template #default="{ row }">
        <el-tag type="success" v-if="row.status == 1" @click="modifyStatusEvent(row.id, 0)" class="cursor-pointer">{{ row.status_name }}</el-tag>
        <el-tag type="error" v-else @click="modifyStatusEvent(row.id, 1)" class="cursor-pointer">{{ row.status_name }}</el-tag>
    </template>
</el-table-column>
```

***

## 八、对话框开发规范

### 8.1 对话框基础结构

```vue
<el-dialog v-model="showDialog" :title="popTitle" width="500px" :destroy-on-close="true">
    <el-form :model="formData" label-width="90px" ref="formRef" :rules="formRules" class="page-form" v-loading="loading">
        <el-form-item :label="t('fieldName')" prop="field_name">
            <el-input v-model.trim="formData.field_name" :placeholder="t('fieldNamePlaceholder')" clearable class="input-width" />
        </el-form-item>
    </el-form>

    <template #footer>
        <span class="dialog-footer">
            <el-button @click="showDialog = false">{{ t('cancel') }}</el-button>
            <el-button type="primary" :loading="loading" @click="confirm(formRef)">{{ t('confirm') }}</el-button>
        </span>
    </template>
</el-dialog>
```

### 8.2 对话框数据定义

```typescript
const showDialog = ref(false)
const loading = ref(false)
const popTitle = ref('')

const initialFormData = {
    id: 0,
    field_name: '',
    status: 1
}
const formData: Record<string, any> = reactive({ ...initialFormData })
```

### 8.3 对话框打开

```typescript
const openDialog = (row: any = null) => {
    loading.value = true
    Object.assign(formData, initialFormData)
    popTitle.value = t('add')
    if (row) {
        popTitle.value = t('edit')
        const data = await getInfo(row.id)
        Object.keys(formData).forEach((key: string) => {
            if (data[key] != undefined) {
                formData[key] = data[key]
            }
        })
    }
    loading.value = false
    showDialog.value = true
}
```

### 8.4 对话框确认

```typescript
const confirm = async (formEl: FormInstance | undefined) => {
    if (loading.value || !formEl) return

    await formEl.validate(async (valid) => {
        if (valid) {
            loading.value = true
            try {
                if (formData.id) {
                    await edit(formData.id, formData)
                } else {
                    await add(formData)
                }
                loading.value = false
                showDialog.value = false
                emit('complete')
            } catch (error) {
                loading.value = false
            }
        }
    })
}
```

> **注意**：不要使用 `const save = formData.id ? edit : add` 这种写法，因为：
>
> - add 函数只接收一个参数 `params`，如果写成 `add(formData.id, formData)` 会导致参数错位
> - edit 函数接收两个参数 `id` 和 `params`，正确的调用方式是 `edit(formData.id, formData)`
> - 正确做法是使用 if-else 分别调用 add 和 edit

***

## 九、样式编写规范

### 9.1 Tailwind CSS使用

```vue
<!-- 布局 -->
<div class="flex justify-between items-center">
<div class="flex justify-end">
<div class="mt-[20px]">
<div class="w-[240px]">
<div class="h-[35vh]">

<!-- 间距 -->
<div class="p-3">
<div class="mb-4">
<div class="mt-[15px]">
<div class="mx-2">

<!-- 文字 -->
<span class="text-[16px]">
<span class="text-[#1D1F3A]">
<span class="font-bold">
<span class="text-[12px]">
<span class="text-[#a9a9a9]">

<!-- 背景 -->
<div class="bg-[#F4F5F7]">
<div class="!border-none">

<!-- 边框 -->
<div class="border-[#E6E6E6] border-solid border-b-[1px]">

<!-- 其他 -->
<div class="cursor-pointer">
<div class="!border-none">
```

### 9.2 SCSS使用

```scss
<style lang="scss" scoped>
.main-container {
    // 主容器样式
}

.box-card {
    // 卡片样式
}

:deep(.loading-box .el-loading-spinner) {
    top: 33%;
}
</style>
```

### 9.3 常用样式类

```vue
<!-- 主容器 -->
<div class="main-container">

<!-- 卡片 -->
<el-card class="box-card !border-none" shadow="never">

<!-- 页面标题 -->
<span class="text-page-title">

<!-- 面板标题 -->
<h3 class="panel-title !text-[14px] bg-[#F4F5F7] p-3 border-[#E6E6E6] border-solid border-b-[1px]">

<!-- 输入框宽度 -->
<el-input class="input-width" />

<!-- 按钮宽度 -->
<el-button class="w-[100px]">

<!-- 表单提示 -->
<div class="form-tip">

<!-- 底部固定 -->
<div class="fixed-footer-wrap">
    <div class="fixed-footer">
```

***

## 十、国际化规范

### 10.1 语言文件结构

#### 10.1.1 语言文件命名规范

- **文件命名格式**：`{模块}.{子模块}.json`
- **文件位置**：`src/lang/zh-cn/` 或 `src/lang/en/`
- **按页面拆分**：每个功能模块对应一个独立的语言文件

**示例：**

```
# 命名规范：{模块}.{子模块}.json，避免跨模块命名冲突
src/lang/zh-cn/
├── auth.role.json           # 角色管理
├── auth.user.json           # 用户管理
├── member.member.json       # 会员管理
├── member.level.json        # 会员等级
├── setting.system.json      # 系统设置
├── inventory.goods.json            # 商品管理
├── inventory.goods_category.json    # 商品分类
├── inventory.goods_unit.json       # 商品单位
├── inventory.warehouse.json        # 仓库管理
├── inventory.inbound.json         # 入库单
├── inventory.outbound.json        # 出库单
├── inventory.check.json           # 盘点单
└── inventory.stock.json           # 库存查询
```

#### 10.1.2 语言文件内容结构

```json
{
    "add": "添加",
    "edit": "编辑",
    "delete": "删除",
    "deleteTips": "确定要删除吗？",
    "list": "列表",
    "fieldName": "字段名称",
    "fieldNamePlaceholder": "请输入字段名称",
    "status": "状态",
    "enable": "启用",
    "disable": "禁用",
    "detail": "详情",
    "search": "搜索",
    "reset": "重置",
    "confirm": "确定",
    "cancel": "取消",
    "operation": "操作",
    "noData": "暂无数据"
}
```

#### 10.1.3 语言文件命名要点

1. **按功能模块拆分**：不要将多个模块的语言放在一个文件中
2. **避免命名冲突**：不同模块使用不同的文件，避免key冲突
3. **统一前缀**：同一模块的key使用统一前缀，如`goodsName`、`goodsCode`
4. **包含通用字段**：每个文件都应包含通用的操作字段（搜索、重置、确认等）
5. **占位符规范**：占位符字段使用`Placeholder`后缀，如`fieldNamePlaceholder`

**错误示例：**

```json
// ❌ 错误：所有模块在一个文件中
{
  "goodsList": "商品列表",
  "warehouseList": "仓库列表",
  "inboundList": "入库单列表",
  "status": "状态",  // 多个模块共用，容易冲突
  "audit": "审核"    // 多个模块共用，容易冲突
}
```

**正确示例：**

```json
// ✅ 正确：按模块拆分
// inventory.goods.json
{
  "addGoods": "添加商品",
  "editGoods": "编辑商品",
  "deleteGoods": "删除商品",
  "goodsList": "商品列表",
  "goodsName": "商品名称",
  "status": "状态",
  "search": "搜索",
  "reset": "重置"
}

// inventory.warehouse.json
{
  "addWarehouse": "添加仓库",
  "editWarehouse": "编辑仓库",
  "deleteWarehouse": "删除仓库",
  "warehouseList": "仓库列表",
  "warehouseName": "仓库名称",
  "status": "状态",
  "search": "搜索",
  "reset": "重置"
}
```

### 10.2 使用国际化

```typescript
import { t } from '@/lang'

// 在模板中使用
{{ t('fieldName') }}
{{ t('fieldNamePlaceholder') }}

// 在脚本中使用
const message = t('fieldNamePlaceholder')
```

### 10.3 国际化命名规范

#### 10.3.1 通用字段命名

| 类型   | 命名格式                   | 示例                                                |
| ---- | ---------------------- | ------------------------------------------------- |
| 字段名  | `fieldName`            | `goodsName`、`warehouseCode`                       |
| 占位符  | `fieldNamePlaceholder` | `goodsNamePlaceholder`、`warehouseCodePlaceholder` |
| 错误提示 | `fieldNameError`       | `mobileError`、`passwordError`                     |
| 成功提示 | `fieldNameSuccess`     | `addSuccess`、`editSuccess`                        |
| 删除提示 | `deleteTips`           | `goodsDeleteTips`、`warehouseDeleteTips`           |

#### 10.3.2 操作按钮命名

| 操作 | 命名格式         | 示例                                              |
| -- | ------------ | ----------------------------------------------- |
| 添加 | `add{模块}`    | `addGoods`、`addWarehouse`、`addInbound`          |
| 编辑 | `edit{模块}`   | `editGoods`、`editWarehouse`、`editInbound`       |
| 删除 | `delete{模块}` | `deleteGoods`、`deleteWarehouse`、`deleteInbound` |
| 保存 | `save`       | `save`                                          |
| 搜索 | `search`     | `search`                                        |
| 重置 | `reset`      | `reset`                                         |
| 确定 | `confirm`    | `confirm`                                       |
| 取消 | `cancel`     | `cancel`                                        |

#### 10.3.3 状态字段命名

| 状态  | 命名格式       | 示例         |
| --- | ---------- | ---------- |
| 启用  | `enable`   | `enable`   |
| 禁用  | `disable`  | `disable`  |
| 正常  | `normal`   | `normal`   |
| 待审核 | `pending`  | `pending`  |
| 已审核 | `approved` | `approved` |
| 已拒绝 | `rejected` | `rejected` |

- <br />
- `adjustStock`：调整

***

## 十一、完整示例

### 11.1 列表页面完整示例

```vue
<template>
    <div class="main-container">
        <el-card class="box-card !border-none" shadow="never">
            <div class="flex justify-between items-center">
                <span class="text-page-title">{{ pageName }}</span>
            </div>

            <div class="flex justify-between items-center mt-[20px]">
                <el-form :inline="true" :model="searchParam" ref="searchFormRef">
                    <el-form-item :label="t('roleName')" prop="keyword">
                        <el-input v-model.trim="searchParam.keyword" class="w-[240px]" :placeholder="t('roleNamePlaceholder')" />
                    </el-form-item>
                    <el-form-item>
                        <el-button type="primary" @click="loadList()">{{ t('search') }}</el-button>
                        <el-button @click="resetForm(searchFormRef)">{{ t('reset') }}</el-button>
                    </el-form-item>
                </el-form>
                <el-button type="primary" class="w-[100px] self-start" @click="addEvent">{{ t('add') }}</el-button>
            </div>

            <div>
                <el-table :data="tableData.data" size="large" v-loading="tableData.loading">
                    <template #empty>
                        <span>{{ !tableData.loading ? t('emptyData') : '' }}</span>
                    </template>
                    <el-table-column prop="role_name" :label="t('roleName')" />
                    <el-table-column :label="t('status')">
                        <template #default="{ row }">
                            <el-tag type="success" v-if="row.status == 1" @click="modifyStatusEvent(row.role_id, 0)" class="cursor-pointer">{{ row.status_name }}</el-tag>
                            <el-tag type="error" v-else @click="modifyStatusEvent(row.role_id, 1)" class="cursor-pointer">{{ row.status_name }}</el-tag>
                        </template>
                    </el-table-column>
                    <el-table-column prop="create_time" :label="t('createTime')"></el-table-column>
                    <el-table-column :label="t('operation')" align="right" fixed="right" width="130">
                        <template #default="{ row }">
                            <el-button type="primary" link @click="editEvent(row)">{{ t('edit') }}</el-button>
                            <el-button type="primary" link @click="deleteEvent(row.role_id)">{{ t('delete') }}</el-button>
                        </template>
                    </el-table-column>
                </el-table>

                <div class="mt-[16px] flex justify-end">
                    <el-pagination
                        v-model:current-page="tableData.page"
                        v-model:page-size="tableData.limit"
                        layout="total, sizes, prev, pager, next, jumper"
                        :total="tableData.total"
                        @size-change="loadList()"
                        @current-change="loadList"
                    />
                </div>
            </div>

            <edit-dialog ref="editDialog" @complete="loadList()" />
        </el-card>
    </div>
</template>

<script lang="ts" setup>
import { ref, reactive } from 'vue'
import { t } from '@/lang'
import { getList, deleteData, modifyStatus } from '@/api/sys'
import { ElMessageBox, FormInstance } from 'element-plus'
import EditDialog from './components/edit-dialog.vue'
import { useRoute } from 'vue-router'

const route = useRoute()
const pageName = route.meta.title

const tableData = reactive({
    page: 1,
    limit: 10,
    total: 0,
    loading: true,
    data: []
})

const searchParam = reactive({
    keyword: ''
})

const searchFormRef = ref<FormInstance>()

const resetForm = (formEl: FormInstance | undefined) => {
    if (!formEl) return
    formEl.resetFields()
    loadList()
}

const loadList = (page: number = 1) => {
    tableData.loading = true
    tableData.page = page

    getList({
        page: tableData.page,
        limit: tableData.limit,
        keyword: searchParam.keyword
    }).then(res => {
        tableData.loading = false
        tableData.data = res.data.data
        tableData.total = res.data.total
    }).catch(() => {
        tableData.loading = false
    })
}
loadList()

const editDialog: Record<string, any> | null = ref(null)

const addEvent = () => {
    editDialog.value.setFormData()
    editDialog.value.showDialog = true
}

const editEvent = (data: any) => {
    editDialog.value.setFormData(data)
    editDialog.value.showDialog = true
}

const deleteEvent = (id: number) => {
    ElMessageBox.confirm(t('deleteTips'), t('warning'), {
        confirmButtonText: t('confirm'),
        cancelButtonText: t('cancel'),
        type: 'warning'
    }).then(() => {
        deleteData(id).then(() => {
            loadList()
        }).catch(() => {})
    })
}

const isRepeat = ref(false)

const modifyStatusEvent = (id: any, status: any) => {
    if (isRepeat.value) return
    isRepeat.value = true

    modifyStatus({ id, status }).then(() => {
        loadList()
        isRepeat.value = false
    }).catch(() => {
        isRepeat.value = false
    })
}
</script>

<style lang="scss" scoped>
</style>
```

### 11.2 编辑对话框完整示例

```vue
<template>
    <el-dialog v-model="showDialog" :title="popTitle" width="500px" :destroy-on-close="true">
        <el-form :model="formData" label-width="90px" ref="formRef" :rules="formRules" class="page-form" v-loading="loading">
            <el-form-item :label="t('roleName')" prop="role_name">
                <el-input v-model.trim="formData.role_name" :placeholder="t('roleNamePlaceholder')" clearable class="input-width" maxlength="10" show-word-limit />
            </el-form-item>

            <el-form-item :label="t('status')">
                <el-radio-group v-model="formData.status">
                    <el-radio :label="1">{{ t('startUsing') }}</el-radio>
                    <el-radio :label="0">{{ t('statusDeactivate') }}</el-radio>
                </el-radio-group>
            </el-form-item>
        </el-form>

        <template #footer>
            <span class="dialog-footer">
                <el-button @click="showDialog = false">{{ t('cancel') }}</el-button>
                <el-button type="primary" :loading="loading" @click="confirm(formRef)">{{ t('confirm') }}</el-button>
            </span>
        </template>
    </el-dialog>
</template>

<script lang="ts" setup>
import { ref, reactive, computed } from 'vue'
import { t } from '@/lang'
import type { FormInstance } from 'element-plus'
import { add, edit, getInfo } from '@/api/sys'

const showDialog = ref(false)
const loading = ref(false)
let popTitle: string = ''

const initialFormData = {
    role_id: 0,
    role_name: '',
    status: 1
}
const formData: Record<string, any> = reactive({ ...initialFormData })

const formRef = ref<FormInstance>()

const formRules = computed(() => {
    return {
        role_name: [
            { required: true, message: t('roleNamePlaceholder'), trigger: 'blur' }
        ]
    }
})

const emit = defineEmits(['complete'])

const confirm = async (formEl: FormInstance | undefined) => {
    if (loading.value || !formEl) return
    const save = formData.role_id ? edit : add

    await formEl.validate(async (valid) => {
        if (valid) {
            loading.value = true
            try {
                await save(formData)
                loading.value = false
                showDialog.value = false
                emit('complete')
            } catch (error) {
                loading.value = false
            }
        }
    })
}

const setFormData = async (row: any = null) => {
    loading.value = true
    Object.assign(formData, initialFormData)
    popTitle = t('add')
    if (row) {
        popTitle = t('edit')
        const data = await (await getInfo(row.role_id)).data
        Object.keys(formData).forEach((key: string) => {
            if (data[key] != undefined) {
                formData[key] = data[key]
            }
        })
    }
    loading.value = false
}

defineExpose({
    setFormData
})
</script>

<style lang="scss" scoped>
</style>
```

### 11.3 表单页面完整示例

```vue
<template>
    <div class="main-container">
        <el-form class="page-form loading-box" :model="formData" label-width="150px" ref="formRef" :rules="formRules" v-loading="loading">
            <el-card class="box-card !border-none" shadow="never">
                <h3 class="text-[16px] text-[#1D1F3A] font-bold mb-4">{{ pageName }}</h3>
                <h3 class="panel-title !text-[14px] bg-[#F4F5F7] p-3 border-[#E6E6E6] border-solid border-b-[1px]">{{ t('basicInfo') }}</h3>

                <el-form-item :label="t('siteName')" prop="site_name">
                    <el-input v-model.trim="formData.site_name" :placeholder="t('siteNamePlaceholder')" class="input-width" clearable maxlength="20" show-word-limit />
                </el-form-item>

                <el-form-item :label="t('logo')">
                    <div>
                        <upload-image v-model="formData.logo" />
                        <p class="text-[12px] text-[#a9a9a9]">{{ t('logoPlaceholder') }}</p>
                    </div>
                </el-form-item>

                <el-form-item :label="t('keywords')">
                    <el-input v-model.trim="formData.keywords" :placeholder="t('keywordsPlaceholder')" class="input-width" clearable maxlength="20" show-word-limit />
                </el-form-item>

                <el-form-item :label="t('desc')">
                    <el-input v-model.trim="formData.desc" type="textarea" :rows="4" clearable :placeholder="t('descPlaceholder')" class="input-width" maxlength="100" show-word-limit />
                </el-form-item>
            </el-card>
        </el-form>

        <div class="fixed-footer-wrap">
            <div class="fixed-footer">
                <el-button type="primary" :loading="loading" @click="save(formRef)">{{ t('save') }}</el-button>
            </div>
        </div>
    </div>
</template>

<script lang="ts" setup>
import { reactive, ref } from 'vue'
import { t } from '@/lang'
import { setConfig, getConfig } from '@/api/sys'
import { FormInstance, FormRules } from 'element-plus'
import { useRoute } from 'vue-router'

const route = useRoute()
const pageName = route.meta.title
const loading = ref(true)

const formData = reactive<Record<string, any>>({
    site_name: '',
    logo: '',
    desc: '',
    keywords: ''
})

const setFormData = async () => {
    const data = await (await getConfig()).data
    Object.keys(formData).forEach((key: string) => {
        if (data[key] != undefined) formData[key] = data[key]
    })
    loading.value = false
}
setFormData()

const formRef = ref<FormInstance>()

const formRules = reactive<FormRules>({
    site_name: [
        { required: true, message: t('siteNamePlaceholder'), trigger: 'blur' }
    ]
})

const save = async (formEl: FormInstance | undefined) => {
    if (loading.value || !formEl) return

    await formEl.validate(async (valid) => {
        if (valid) {
            loading.value = true
            try {
                await setConfig(formData)
                loading.value = false
            } catch (error) {
                loading.value = false
            }
        }
    })
}
</script>

<style lang="scss" scoped>
:deep(.loading-box .el-loading-spinner){
    top: 33%;
}
</style>
```

***

## 十二、开发流程总结

### 12.1 开发新页面的步骤

1. **创建页面文件** - 在 `src/views/` 下创建 `.vue` 文件
2. **创建API文件** - 在 `src/api/` 下定义接口函数
3. **创建语言文件** - 在 `src/lang/zh-cn/` 下添加翻译
4. **实现页面结构** - 使用标准页面模板
5. **实现功能逻辑** - 添加数据和方法
6. **添加样式** - 使用Tailwind CSS和SCSS
7. **测试功能** - 测试所有功能是否正常

### 12.2 开发新组件的步骤

1. **创建组件目录** - 在 `src/components/` 下创建组件文件夹
2. **创建组件文件** - 创建 `index.vue` 文件
3. **定义Props和Emits** - 定义组件接口
4. **实现组件逻辑** - 添加响应式数据和方法
5. **添加组件样式** - 使用Tailwind CSS和SCSS
6. **导出组件** - 在组件中导出
7. **测试组件** - 测试组件功能

### 12.3 关键要点

- **使用Composition API**：使用 `<script setup>` 语法
- **使用TypeScript**：添加类型定义
- **使用Element Plus**：使用UI组件库
- **使用Tailwind CSS**：使用原子化CSS
- **使用国际化**：所有文字使用 `t()` 函数
- **使用响应式数据**：使用 `ref` 和 `reactive`
- **使用路由**：使用 `useRoute` 获取路由信息
- **使用状态管理**：使用Pinia进行状态管理
- **遵循命名规范**：文件、变量、方法名都要符合规范
- **添加注释**：复杂逻辑添加注释说明

***

**End of Document**
