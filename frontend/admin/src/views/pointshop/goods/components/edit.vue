<template>
    <el-dialog v-model="showDialog" :title="formData.goods_id ? t('editGoods') : t('addGoods')" :close-on-click-modal="false" width="700px" draggable>
        <el-form :model="formData" label-width="120px" ref="formRef" :rules="rules">
            <el-form-item :label="t('goodsName')" prop="goods_name">
                <el-input v-model="formData.goods_name" :placeholder="t('goodsNamePlaceholder')" maxlength="200" />
            </el-form-item>
            <el-form-item :label="t('category')" prop="category_id">
                <el-select v-model="formData.category_id" :placeholder="t('selectCategory')" class="!w-full">
                    <el-option :label="item.category_name" :value="item.category_id" v-for="item in formData.categoryList" :key="item.category_id" />
                </el-select>
            </el-form-item>
            <el-form-item :label="t('goodsImage')" prop="goods_image">
                <div>
                    <upload-image v-model="formData.goods_image" :limit="1" />
                    <div class="text-[12px] text-[#999] mt-[8px]">{{ t('goodsImageTip') }}</div>
                </div>
            </el-form-item>
            <el-form-item :label="t('pointPrice')" prop="point_price">
                <el-input-number v-model="formData.point_price" :min="0" :precision="0" controls-position="right" />
                <span class="ml-[8px]">{{ t('point') }}</span>
            </el-form-item>
            <el-form-item :label="t('marketPrice')" prop="price">
                <el-input-number v-model="formData.price" :min="0" :precision="2" controls-position="right" />
                <span class="ml-[8px]">¥</span>
            </el-form-item>
            <el-form-item :label="t('stock')" prop="stock">
                <el-input-number v-model="formData.stock" :min="0" :precision="0" controls-position="right" />
            </el-form-item>
            <el-form-item :label="t('limitNum')" prop="limit_num">
                <el-input-number v-model="formData.limit_num" :min="0" :precision="0" controls-position="right" />
                <div class="text-[12px] text-[#999] ml-[8px]">{{ t('limitNumPlaceholder') }}</div>
            </el-form-item>
            <el-form-item :label="t('exchangeDesc')" prop="exchange_desc">
                <el-input v-model="formData.exchange_desc" type="textarea" :rows="3" maxlength="500" show-word-limit />
            </el-form-item>
            <el-form-item :label="t('sort')" prop="sort">
                <el-input-number v-model="formData.sort" :min="0" :precision="0" controls-position="right" />
            </el-form-item>
            <el-form-item :label="t('status')" prop="status">
                <el-radio-group v-model="formData.status">
                    <el-radio :label="1">{{ t('enable') }}</el-radio>
                    <el-radio :label="0">{{ t('disable') }}</el-radio>
                </el-radio-group>
            </el-form-item>
        </el-form>
        <template #footer>
            <el-button @click="showDialog = false">{{ t('cancel') }}</el-button>
            <el-button type="primary" @click="submitForm(formRef)">{{ t('confirm') }}</el-button>
        </template>
    </el-dialog>
</template>

<script lang="ts" setup>
import { reactive, ref } from 'vue'
import { t } from '@/lang'
import { FormInstance } from 'element-plus'
import { addPointGoods, editPointGoods } from '@/api/pointshop'
import { img } from '@/utils/common'
import uploadImage from '@/components/upload-image/index.vue'

const emit = defineEmits(['complete'])

const showDialog = ref(false)
const formRef = ref<FormInstance>()
const formData = reactive<any>({
    goods_id: 0,
    goods_name: '',
    category_id: '',
    goods_image: '',
    point_price: 0,
    price: 0,
    stock: 0,
    sales_num: 0,
    limit_num: 0,
    exchange_desc: '',
    sort: 0,
    status: 1,
    categoryList: []
})

const rules = reactive({
    goods_name: [{ required: true, message: t('goodsNamePlaceholder'), trigger: 'blur' }],
    category_id: [{ required: true, message: t('selectCategory'), trigger: 'change' }],
    goods_image: [{ required: true, message: t('goodsImageTip'), trigger: 'change' }],
    point_price: [{ required: true, message: t('pointPriceRequired'), trigger: 'blur' }],
    price: [{ required: true, message: t('marketPriceRequired'), trigger: 'blur' }],
    stock: [{ required: true, message: t('stockRequired'), trigger: 'blur' }]
})

const setData = (data: any) => {
    Object.keys(formData).forEach(key => {
        if (data[key] !== undefined) {
            (formData as any)[key] = data[key]
        }
    })
}

const open = () => {
    showDialog.value = true
}

const submitForm = async (formEl: FormInstance | undefined) => {
    if (!formEl) return
    await formEl.validate((valid) => {
        if (valid) {
            const data = { ...formData }
            delete data.categoryList
            if (data.goods_id) {
                editPointGoods(data.goods_id, data).then(() => {
                    showDialog.value = false
                    emit('complete')
                })
            } else {
                addPointGoods(data).then(() => {
                    showDialog.value = false
                    emit('complete')
                })
            }
        }
    })
}

defineExpose({
    open,
    setData
})
</script>
