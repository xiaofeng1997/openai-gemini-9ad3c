<template>
    <el-dialog v-model="showDialog" :title="t('messageInfo')" width="550px" :destroy-on-close="true">
        <el-form :model="formData" label-width="110px" ref="formRef" :rules="formRules" class="page-form" v-loading="loading">

            <el-form-item :label="t('noticeKey')">
                <div class="input-width"> {{ formData.name }} </div>
            </el-form-item>

            <el-form-item :label="t('receiver')">
                <div class="input-width"> {{ formData.receiver }} </div>
            </el-form-item>

            <el-form-item :label="t('createTime')">
                <div class="input-width"> {{ formData.create_time }} </div>
            </el-form-item>
            <el-form-item :label="t('content')">
                <div class="input-width"> {{ JSON.stringify(formData.content, null, 2) }} </div>
            </el-form-item>
            <el-form-item :label="t('sendResult')">
                <div class="input-width" v-if="formData.status === 0"> {{ t('sending') }}</div>
                <div class="input-width" v-else-if="formData.status === 1"> {{ t('success') }}</div>
                <div class="input-width" v-else-if="formData.status === 2"> {{ JSON.stringify(formData.result) }} </div>
            </el-form-item>
        </el-form>

        <template #footer>
            <span class="dialog-footer">
                <el-button type="primary" @click="showDialog = false">{{ t('confirm') }}</el-button>
            </span>
        </template>
    </el-dialog>
</template>

<script lang="ts" setup>
import { ref, reactive, computed } from 'vue'
import { t } from '@/lang'
import type { FormInstance } from 'element-plus'

const showDialog = ref(false)
const loading = ref(true)

/**
 * 表单数据
 */
const initialFormData = {
    create_time: '',
    name: '',
    receiver: '',
    status: 0,
    content: '',
    result: ''
}
const formData: Record<string, any> = reactive({ ...initialFormData })

const formRef = ref<FormInstance>()

// 表单验证规则
const formRules = computed(() => {
    return {

    }
})

const setFormData = async (row: any = null) => {
    loading.value = true
    Object.assign(formData, initialFormData)

    if (row) {
        Object.keys(formData).forEach((key: string) => {
            if (row[key] != undefined) formData[key] = row[key]
        })
    }

    loading.value = false
}

defineExpose({
    showDialog,
    setFormData
})
</script>

<style lang="scss" scoped></style>