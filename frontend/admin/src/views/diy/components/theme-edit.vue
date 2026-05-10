<template>
<el-dialog
v-model="showDialog"
:title="isEdit ? t('editTheme') : t('addTheme')"
width="600px"
@close="closeDialog"
>
<el-form ref="formRef" :model="formData" label-width="100px">
<!-- 主题名称 -->
<el-form-item :label="t('themeName')" prop="title">
<el-input v-model="formData.title" :placeholder="t('themeNamePlaceholder')" />
</el-form-item>

<!-- 主题颜色配置（调用字典类字段） -->
<el-form-item :label="t('themeColor')">
<div class="color-config-list">
<div v-for="(colorInfo, colorKey) in themeColorDict" :key="colorKey" class="color-item">
<div class="color-label">{{ colorInfo.title }}</div>
<div class="color-picker-container">
<el-color-picker
v-model="formData.theme[colorKey]"
show-alpha
size="small"
@change="handleColorChange"
/>
<span class="color-preview" :style="{ backgroundColor: formData.theme[colorKey] }"></span>
<span class="color-value">{{ formData.theme[colorKey] }}</span>
</div>
</div>
</div>
</el-form-item>

<!-- 实时预览 -->
<el-form-item :label="t('realTimePreview')">
<div class="preview-container">
<div class="preview-header" :style="{ backgroundColor: formData.theme['--primary-color'] }">
<h3>{{ t('previewTitle') }}</h3>
</div>
<div class="preview-content" :style="{ backgroundColor: formData.theme['--page-bg-color'] }">
<p>{{ t('previewContent') }}</p>
<div class="preview-buttons">
<el-button 
v-for="(colorInfo, colorKey) in themeColorDict" 
:key="colorKey"
:style="{ 
backgroundColor: formData.theme[colorKey],
borderColor: formData.theme[colorKey],
color: isLightColor(formData.theme[colorKey]) ? '#303133' : '#ffffff'
}"
size="small"
>
{{ colorInfo.title }}
</el-button>
</div>
</div>
</div>
</el-form-item>
</el-form>

<template #footer>
<div class="dialog-footer">
<el-button @click="closeDialog">{{ t('cancel') }}</el-button>
<el-button type="primary" @click="submitForm">{{ t('confirm') }}</el-button>
</div>
</template>
</el-dialog>
</template>

<script lang="ts" setup>
import { ref, reactive, onMounted } from 'vue'
import { t } from '@/lang'
import { getThemeColorDict, addDiyTheme, editDiyTheme } from '@/api/diy_theme'
import { ElMessage } from 'element-plus'

const emit = defineEmits(['complete'])

const showDialog = ref(false)
const formRef = ref(null)
const isEdit = ref(false)
const themeColorDict = ref({})

const formData = reactive({
id: '',
title: '',
theme: {}
})

// 判断颜色是否为浅色
const isLightColor = (color) => {
if (!color) return false
color = color.replace('#', '')
const r = parseInt(color.substr(0, 2), 16)
const g = parseInt(color.substr(2, 2), 16)
const b = parseInt(color.substr(4, 2), 16)
const brightness = (r * 299 + g * 587 + b * 114) / 1000
return brightness > 128
}

// 初始化主题色字典（调用字典类）
const initThemeColorDict = () => {
getThemeColorDict({}).then((res) => {
themeColorDict.value = res.data
})
}

// 设置表单数据（参考会员标签组件模式）
const setFormData = (data = null) => {
isEdit.value = !!data
formData.id = data ? data.id : ''
formData.title = data ? data.title : ''
formData.theme = {}

// 根据字典类字段初始化颜色值
for (const colorKey in themeColorDict.value) {
if (data && data.theme && data.theme[colorKey]) {
formData.theme[colorKey] = data.theme[colorKey]
} else {
formData.theme[colorKey] = themeColorDict.value[colorKey].default
}
}
}

// 关闭弹窗
const closeDialog = () => {
showDialog.value = false
}

// 提交表单
const submitForm = () => {
const api = isEdit.value ? editDiyTheme : addDiyTheme
const params = isEdit.value ? { id: formData.id, title: formData.title, theme: formData.theme } : { title: formData.title, theme: formData.theme }

api(params).then(() => {
showDialog.value = false
emit('complete')
})
}

// 颜色变化处理
const handleColorChange = () => {
// 可以在这里添加颜色变化的额外处理逻辑
}

// 组件挂载时初始化
onMounted(() => {
initThemeColorDict()
})

// 暴露方法给父组件（参考会员标签组件模式）
defineExpose({
setFormData,
showDialog
})
</script>

<style scoped>
.color-config-list {
display: flex;
flex-direction: column;
gap: 16px;
}

.color-item {
display: flex;
align-items: center;
gap: 12px;
}

.color-label {
width: 100px;
font-size: 14px;
}

.color-picker-container {
display: flex;
align-items: center;
gap: 8px;
flex: 1;
}

.color-preview {
width: 24px;
height: 24px;
border-radius: 4px;
border: 1px solid #dcdfe6;
}

.color-value {
font-size: 12px;
color: #909399;
min-width: 80px;
}

.preview-container {
border: 1px solid #dcdfe6;
border-radius: 4px;
overflow: hidden;
}

.preview-header {
padding: 16px;
color: #ffffff;
text-align: center;
}

.preview-content {
padding: 16px;
min-height: 100px;
}

.preview-buttons {
margin-top: 16px;
display: flex;
gap: 8px;
flex-wrap: wrap;
}
</style>