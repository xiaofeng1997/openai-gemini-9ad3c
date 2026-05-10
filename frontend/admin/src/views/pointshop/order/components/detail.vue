<template>
    <el-dialog v-model="showDialog" :title="t('orderDetail')" width="600px" draggable>
        <el-descriptions :column="2" border>
            <el-descriptions-item :label="t('orderNo')">{{ formData.order_no }}</el-descriptions-item>
            <el-descriptions-item :label="t('status')">
                <el-tag :type="getStatusType(formData.status)">{{ formData.status_name }}</el-tag>
            </el-descriptions-item>
            <el-descriptions-item :label="t('createTime')">{{ formData.create_time }}</el-descriptions-item>
            <el-descriptions-item :label="t('memberInfo')">
                <div v-if="formData.member">
                    <p>{{ formData.member.nickname || '-' }}</p>
                    <p class="text-[12px] text-[#999]">{{ formData.member.mobile || '-' }}</p>
                </div>
                <span v-else>-</span>
            </el-descriptions-item>
        </el-descriptions>

        <el-divider />

        <div class="mb-[16px]">
            <h4 class="text-[14px] font-medium mb-[12px]">{{ t('goodsInfo') }}</h4>
            <div class="flex items-center p-[12px] bg-[#f5f5f5] rounded" v-if="formData.goods">
                <el-image class="w-[80px] h-[80px]" :src="img(formData.goods.goods_image)" fit="cover" />
                <div class="ml-[12px] flex-1">
                    <p>{{ formData.goods.goods_name }}</p>
                    <p class="text-primary mt-[4px]">{{ formData.goods.point_price }} {{ t('point') }} × {{ formData.num }}</p>
                </div>
            </div>
        </div>

        <div class="mb-[16px]">
            <h4 class="text-[14px] font-medium mb-[12px]">{{ t('address') }}</h4>
            <div class="p-[12px] bg-[#f5f5f5] rounded" v-if="formData.address">
                <p>{{ formData.address.name }} {{ formData.address.mobile }}</p>
                <p class="text-[#999] text-[12px] mt-[4px]">{{ formData.address.full_address }} {{ formData.address.address }}</p>
            </div>
        </div>

        <div class="mb-[16px]" v-if="formData.status == 2">
            <h4 class="text-[14px] font-medium mb-[12px]">{{ t('deliveryInfo') }}</h4>
            <div class="p-[12px] bg-[#f5f5f5] rounded">
                <p>{{ t('expressCompany') }}: {{ formData.express_company }}</p>
                <p class="mt-[4px]">{{ t('expressNo') }}: {{ formData.express_no }}</p>
            </div>
        </div>

        <div class="mb-[16px]" v-if="formData.status == 1">
            <h4 class="text-[14px] font-medium mb-[12px]">{{ t('deliveryInfo') }}</h4>
            <el-form :model="deliveryForm" :rules="rules" ref="formRef" label-width="100px">
                <el-form-item :label="t('expressCompany')" prop="express_company">
                    <el-input v-model="deliveryForm.express_company" :placeholder="t('expressCompanyPlaceholder')" />
                </el-form-item>
                <el-form-item :label="t('expressNo')" prop="express_no">
                    <el-input v-model="deliveryForm.express_no" :placeholder="t('expressNoPlaceholder')" />
                </el-form-item>
            </el-form>
        </div>
        <div class="mt-[16px] text-right">
            <p class="text-[16px]">
                {{ t('totalPoint') }}: <span class="text-primary text-[20px]">{{ formData.point_num }}</span> {{ t('point') }}
            </p>
        </div>
        <template #footer v-if="formData.status == 1">
            <el-button @click="showDialog = false">{{ t('cancel') }}</el-button>
            <el-button type="primary" @click="submitDelivery(formRef)">{{ t('confirmDeliver') }}</el-button>
        </template>
    </el-dialog>
</template>

<script lang="ts" setup>
import { reactive, ref } from 'vue'
import { t } from '@/lang'
import { FormInstance } from 'element-plus'
import { img } from '@/utils/common'
import { deliverPointOrder } from '@/api/pointshop'

const emit = defineEmits(['complete'])

const showDialog = ref(false)
const formData = reactive<any>({
    order_id: 0,
    order_no: '',
    status: 1,
    status_name: '',
    create_time: '',
    num: 1,
    point_num: 0,
    member: null,
    goods: null,
    address: null,
    express_company: '',
    express_no: ''
})

const deliveryForm = reactive({
    express_company: '',
    express_no: ''
})

const rules = {
    express_company: [{ required: true, message: '请输入快递公司', trigger: 'blur' }],
    express_no: [{ required: true, message: '请输入快递单号', trigger: 'blur' }]
}

const getStatusType = (status: number) => {
    const types: Record<number, string> = {
        '-1': 'info',
        '1': 'warning',
        '2': 'primary',
        '3': 'success'
    }
    return types[status] || 'info'
}

const setData = (data: any) => {
    Object.keys(formData).forEach(key => {
        if (data[key] !== undefined) {
            (formData as any)[key] = data[key]
        }
    })
    deliveryForm.express_company = ''
    deliveryForm.express_no = ''
}

const open = () => {
    showDialog.value = true
}

const formRef = ref<FormInstance>()
const submitDelivery = async (formEl: FormInstance | undefined) => {
    if (!formEl) return
    await formEl.validate((valid) => {
        if (valid) {
            deliverPointOrder({
                order_id: formData.order_id,
                express_company: deliveryForm.express_company,
                express_no: deliveryForm.express_no
            }).then(() => {
                showDialog.value = false
                emit('complete')
            })
        }
    })
}

defineExpose({
    open,
    setData
})
</script>
