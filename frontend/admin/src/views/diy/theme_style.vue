<template>
<div class="main-container">
<el-card class="box-card !border-none" shadow="never">
<div class="flex justify-between items-center mb-4">
<span class="text-page-title">{{ pageName }}</span>
<el-button type="primary" @click="addEvent">添加主题</el-button>
</div>
<div class="mt-[20px]">
<el-table :data="themeTableData.data" size="large" v-loading="themeTableData.loading">
<template #empty>
<span>{{ !themeTableData.loading ? t('emptyData') : '' }}</span>
</template>

<el-table-column label="主题名称" min-width="120">
<template #default="{ row }">
<div>{{ row.title }}</div>
</template>
</el-table-column>

<el-table-column label="主题颜色" min-width="120">
<template #default="{ row }">
<div class="theme-color-group" v-if="row.theme">
<div class="color-block" :style="{ backgroundColor: row.theme['--primary-color'] }"></div>
<div class="color-block" :style="{ backgroundColor: row.theme['--secondary-color'] }"></div>
<div class="color-block" :style="{ backgroundColor: row.theme['--primary-text-color'] }"></div>
</div>
</template>
</el-table-column>

<el-table-column :label="t('status')" min-width="100">
<template #default="{ row }">
<el-tag type="success" v-if="row.is_selected">{{ t('inUse') }}</el-tag>
<el-tag v-else>{{ t('notUsed') }}</el-tag>
</template>
</el-table-column>

<el-table-column :label="t('operation')" align="right" fixed="right" width="250">
<template #default="{ row }">
<el-button type="primary" link @click="setThemeEvent(row)" v-if="!row.is_selected">{{ t('setUse') }}</el-button>
<el-button type="primary" link @click="editEvent(row)">{{ t('edit') }}</el-button>
<el-button type="danger" link @click="delEvent(row)">{{ t('delete') }}</el-button>
</template>
</el-table-column>
</el-table>
</div>
<theme-edit ref="themeEditDialog" @complete="initData" />
</el-card>
</div>
</template>

<script lang="ts" setup>
import { reactive, ref } from 'vue'
import { t } from '@/lang'
import { getDiyTheme, addDiyTheme, editDiyTheme, delDiyTheme, setDiyTheme } from '@/api/diy_theme'
import { useRoute } from 'vue-router'
import { ElMessageBox, ElMessage } from 'element-plus'
import ThemeEdit from './components/theme-edit.vue'

const route = useRoute()
const pageName = route.meta.title
const themeEditDialog = ref(null)

const themeTableData = reactive({
data: [],
loading: false
})

const initData = () => {
themeTableData.loading = true
getDiyTheme({}).then((res) => {
themeTableData.data = res.data
}).finally(() => {
themeTableData.loading = false
})
}

// 添加事件
const addEvent = () => {
themeEditDialog.value.setFormData()
themeEditDialog.value.showDialog = true
}

// 编辑事件
const editEvent = (row) => {
themeEditDialog.value.setFormData(row)
themeEditDialog.value.showDialog = true
}

// 删除事件
const delEvent = (row) => {
ElMessageBox.confirm(t('deleteConfirm'), t('prompt'), {
confirmButtonText: t('confirm'),
cancelButtonText: t('cancel'),
type: 'warning'
}).then(() => {
delDiyTheme(row.id).then(() => {
initData()
})
})
}

// 设置主题事件
const setThemeEvent = (row) => {
setDiyTheme(row.id).then(() => {
initData()
})
}

// 页面加载时初始化数据
initData()
</script>

<style scoped>
.theme-color-group {
display: inline-flex;
border-radius: 4px;
overflow: hidden;
border: 1px solid #e4e7ed;
}

.color-block {
width: 24px;
height: 24px;
}
</style>

