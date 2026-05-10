<template>
    <el-dialog v-model="showDialog" :title="title" width="500px" :before-close="beforeClose"  :destroy-on-close="true">
        <el-form :model="formData" label-width="120px" ref="formRef" :rules="formRules" class="page-form">
            <el-form-item :label="t('associatedType')" prop="type">
                <el-select :placeholder="t('associatedTypePlaceholder')" v-model="formData.type" class="input-width">
                    <el-option :label="t('hasOne')" value="has_one" />
                    <el-option :label="t('hasMany')" value="has_many" />
                </el-select>
            </el-form-item>
            <el-form-item :label="t('associatedName')" prop="name">
                <el-input v-model.trim="formData.name" :placeholder="t('associatedNamePlaceholder')" class="input-width" />
            </el-form-item>
            <el-form-item :label="t('associatedModel')" prop="model">
                <el-select :placeholder="t('associatedModelPlaceholder')" v-model="formData.model" class="input-width" filterable>
                    <el-option v-for="item in modelList" :label="item" :value="item" :key="item" />
                </el-select>
            </el-form-item>
            <el-form-item prop="local_key" :label="t('localKey')">
                <el-select class="input-width" :placeholder="t('localKeyPlaceholder')" v-model="formData.local_key">
                    <el-option :label="`${item.name}:${item.comment}`" :value="item.name" v-for="(item, index) in localKeyList" :key="index" />
                </el-select>
            </el-form-item>
            <el-form-item :label="t('foreignKey')" prop="foreign_key">
                <el-input v-model.trim="formData.foreign_key" :placeholder="t('foreignKeyPlaceholder')" class="input-width" />
            </el-form-item>
        </el-form>
        <template #footer>
            <span class="dialog-footer">
                <el-button @click="showDialog = false">{{ t('cancel') }}</el-button>
                <el-button type="primary" @click="confirm(formRef)">{{ t('confirm') }}</el-button>
            </span>
        </template>
    </el-dialog>
</template>

<script lang="ts" setup async>
import { ref, computed, toRaw } from 'vue'
import { t } from '@/lang'
import type { FormInstance } from 'element-plus'
import { getGeneratorAllModel, getGeneratorTableColumn } from '@/api/tools'
import { cloneDeep } from 'lodash-es'

const showDialog = ref(false)
const title = ref('')
const prop = defineProps({
    table_name: {
        type: String,
        required: true
    }
})
/**
 * 表单数据
 */
const initialFormData = {
    type: 'has_one',
    name: '',
    model: '',
    local_key: '',
    foreign_key: ''
}
const formData: Record<string, any> = ref({ ...initialFormData })

const formRef = ref<FormInstance>()

// 表单验证规则
const formRules = computed(() => {
    return {
        type: [
            { required: true, message: t('associatedTypePlaceholder'), trigger: 'change' }
        ],
        name: [
            { required: true, message: t('associatedNamePlaceholder'), trigger: 'blur' }
        ],
        model: [
            { required: true, message: t('associatedModelPlaceholder'), trigger: 'change' }
        ],
        local_key: [
            { required: true, message: t('localKeyPlaceholder'), trigger: 'change' }
        ],
        foreign_key: [
            { required: true, message: t('foreignKeyPlaceholder'), trigger: 'blur' }
        ]
    }
})

/**
 * 获取关联模型
 */
const modelList = ref([])
const getGeneratorAllModelFn = () => {
    getGeneratorAllModel().then(res => {
        modelList.value = res.data
    })
}

/**
 * 获取关联字段
 */
const localKeyList = ref([])
const getGeneratorTableColumnFn = (key: any) => {
    getGeneratorTableColumn({ table_name: key }).then(res => {
        localKeyList.value = res.data
    })
}

const beforeClose = (next:any) => {
    formRef.value?.clearValidate()
    next()
}
const emit = defineEmits(['complete'])
/**
 * 确认
 * @param formEl
 */
const confirm = async (formEl: FormInstance | undefined) => {
    if (!formEl) return

    await formEl.validate(async (valid) => {
        if (valid) {
            emit('complete', toRaw(formData.value))
            showDialog.value = false
        }
    })
}

const setFormData = async (row: any = null) => {
    getGeneratorTableColumnFn(prop.table_name)
    getGeneratorAllModelFn()
    if (row) {
        formData.value = cloneDeep(row)
    } else {
        formData.value = cloneDeep(initialFormData)
    }
    showDialog.value = true
}

defineExpose({
    showDialog,
    setFormData
})
</script>

<style lang="scss" scoped></style>

