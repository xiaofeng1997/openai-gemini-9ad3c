<template>
    <el-dialog v-model="showDialog" :title="popTitle" width="500px" :destroy-on-close="true">
        <el-form :model="formData" label-width="90px" ref="formRef" :rules="formRules" class="page-form" v-loading="loading">
            <el-form-item :label="t('positionName')" prop="name">
                <el-input v-model.trim="formData.name" :placeholder="t('positionNamePlaceholder')" clearable class="input-width" maxlength="50" show-word-limit />
            </el-form-item>

            <el-form-item :label="t('deptName')" prop="dept_id">
                <el-tree-select
                    v-model="formData.dept_id"
                    :data="deptList"
                    :props="{ label: 'name', value: 'id', children: 'children' }"
                    :placeholder="t('deptNamePlaceholder')"
                    clearable
                    check-strictly
                    :render-after-expand="false"
                    class="input-width"
                >
                    <template #default="{ data }">
                        <span>{{ data.name }}</span>
                    </template>
                </el-tree-select>
            </el-form-item>

            <el-form-item :label="t('sort')" prop="sort">
                <el-input-number v-model="formData.sort" :min="0" :max="9999" class="input-width" />
            </el-form-item>

            <el-form-item :label="t('status')" prop="status">
                <el-radio-group v-model="formData.status">
                    <el-radio :label="1">{{ t('statusUnlock') }}</el-radio>
                    <el-radio :label="0">{{ t('lock') }}</el-radio>
                </el-radio-group>
            </el-form-item>
        </el-form>
        <template #footer>
            <span class="dialog-footer">
                <el-button @click="showDialog = false">{{ t('cancel') }}</el-button>
                <el-button type="primary" @click="confirm(formRef)" :loading="loading">{{ t('confirm') }}</el-button>
            </span>
        </template>
    </el-dialog>
</template>

<script setup lang="ts">
import { ref, computed, onMounted } from 'vue'
import { ElMessage } from 'element-plus'
import { addPosition, editPosition, getDeptTree } from '@/api/sys'
import type { FormInstance } from 'element-plus'
import { t } from '@/lang'

const showDialog = ref(false)
const loading = ref(false)
const formRef = ref<FormInstance>()
const popTitle = computed(() => formData.value.id ? t('editPosition') : t('addPosition'))

const formData = ref({
    id: 0,
    name: '',
    dept_id: '',
    sort: 0,
    status: 1
})

const deptList = ref([])

const formRules = {
    name: [
        { required: true, message: t('positionNamePlaceholder'), trigger: 'blur' }
    ],
    dept_id: [
        { required: true, message: t('deptNamePlaceholder'), trigger: 'change' }
    ]
}

onMounted(() => {
    loadDeptList()
})

const setFormData = (data: any = {}) => {
    formData.value = {
        id: data.id || 0,
        name: data.name || '',
        dept_id: data.dept_id || '',
        sort: data.sort || 0,
        status: data.status ?? 1
    }
    loadDeptList()
}

const loadDeptList = async () => {
    const res = await getDeptTree()
    deptList.value = res.data
}

const confirm = async (formEl: FormInstance | undefined) => {
    if (!formEl) return
    await formEl.validate(async (valid) => {
        if (valid) {
            loading.value = true
            try {
                if (formData.value.id) {
                    await editPosition(formData.value)
                } else {
                    await addPosition(formData.value)
                }
                showDialog.value = false
                emit('complete')
            } finally {
                loading.value = false
            }
        }
    })
}

const emit = defineEmits(['complete'])

defineExpose({
    setFormData,
    showDialog
})
</script>

<style lang="scss" scoped></style>