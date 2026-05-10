<template>
    <!--编辑等级-->
    <div class="main-container">

        <el-card class="card !border-none" shadow="never">
            <el-page-header :content="pageName" :icon="ArrowLeft" @back="back()" />
        </el-card>

        <el-card class="box-card mt-[15px] !border-none" shadow="never" v-loading="loading">
            <el-form class="page-form" :model="formData" label-width="120px" ref="formRef" :rules="formRules">
                <h3 class="panel-title !text-sm">{{ t('basicInfo') }}</h3>

                <el-form-item :label="t('levelName')" prop="level_name">
                    <el-input v-model.trim="formData.level_name" :placeholder="t('levelNamePlaceholder')" class="input-width" maxlength="20" show-word-limit clearable />
                </el-form-item>
                <el-form-item :label="t('remark')" prop="remark">
                    <el-input v-model.trim="formData.remark" type="textarea" :placeholder="t('remarkPlaceholder')" class="input-width" clearable rows="4" maxlength="200" show-word-limit />
                </el-form-item>
                <el-form-item :label="t('growth')" prop="growth">
                    <div>
                        <div class="w-[150px]">
                            <el-input v-model.number.trim="formData.growth" :placeholder="t('growthPlaceholder')" clearable />
                        </div>
                        <div class="text-sm text-gray-400 mb-[5px]">{{ t('growthTips') }}</div>
                    </div>
                </el-form-item>
            </el-form>

            <h3 class="panel-title !text-sm">{{ t('levelBenefits') }}</h3>
            <div class="pl-[100px]">
                <benefits-discount v-if="!loading" ref="benefitsDiscountRef" v-model="formData.level_benefits.discount"/>
            </div>

            <h3 class="panel-title !text-sm">{{ t('levelGift') }}</h3>
            <div class="pl-[100px]">
                <gift-balance v-if="!loading" ref="giftBalanceRef" v-model="formData.level_gifts.balance"/>
                <gift-point v-if="!loading" ref="giftPointRef" v-model="formData.level_gifts.point"/>
            </div>

        </el-card>

        <div class="fixed-footer-wrap">
            <div class="fixed-footer">
                <el-button type="primary" :loading="saveLoading" @click="save(formRef)">{{ t('save') }}</el-button>
            </div>
        </div>
    </div>
</template>

<script lang="ts" setup>
import { reactive, ref } from 'vue'
import { t } from '@/lang'
import { FormInstance, FormRules } from 'element-plus'
import { ArrowLeft } from '@element-plus/icons-vue'
import { useRoute, useRouter } from 'vue-router'
import benefitsDiscount from '@/views/member/components/benefits-discount.vue'
import giftBalance from '@/views/member/components/gift-balance.vue'
import giftPoint from '@/views/member/components/gift-point.vue'
import { getMemberLevelInfo, addMemberLevel, updateMemberLevel, getMemberLevelAll } from '@/api/member'
import Test from '@/utils/test'
import { cloneDeep } from 'lodash-es'

const route = useRoute()
const router = useRouter()
const pageName = route.meta.title

const back = () => {
    router.push('/member/level')
}

const benefitsDiscountRef = ref(null)
const giftBalanceRef = ref(null)
const giftPointRef = ref(null)
const loading = ref(true)
const growthInterval = ref({ min: 0, max: 0 })

const formData = reactive<Record<string, any>>({
    level_id: 0,
    level_name: '',
    remark: '',
    growth: '',
    level_benefits: {},
    level_gifts: {
        balance: {},
        point: {}
    }
})

const formRef = ref<FormInstance>()

// 表单验证规则
const formRules = reactive<FormRules>({
    level_name: [
        { required: true, message: t('levelNamePlaceholder'), trigger: 'blur' }
    ],
    growth: [
        { required: true, message: t('growthPlaceholder'), trigger: 'blur' },
        {
            validator: (rule: any, value: any, callback: any) => {
                if (!Test.digits(formData.growth)) {
                    callback(t('growthFormatError'))
                }
                if (formData.growth <= 0) {
                    callback(t('growthNeedGt') + 0)
                }
                if (growthInterval.value.min && formData.growth <= growthInterval.value.min) {
                    callback(t('growthNeedGt') + growthInterval.value.min)
                }
                if (growthInterval.value.max && formData.growth >= growthInterval.value.max) {
                    callback(t('growthNeedLt') + growthInterval.value.max)
                }
                callback()
            }
        }
    ]
})

if (route.query.id) {
    getMemberLevelInfo(route.query.id).then(({ data }) => {
        Object.assign(formData, data)

        getMemberLevelAll().then(({ data }) => {
            let index = 0
            data.forEach((item, i) => {
                item.level_id == formData.level_id && (index = i)
            })
            data[index - 1] && (growthInterval.value.min = data[index - 1].growth)
            data[index + 1] && (growthInterval.value.max = data[index + 1].growth)
        })
        loading.value = false
    })
} else {
    getMemberLevelAll().then(({ data }) => {
        data[data.length - 1] && (growthInterval.value.min = data[data.length - 1].growth)
    })
    loading.value = false
}

const saveLoading = ref(false)
/**
 * 保存
 */
const save = async (formEl: FormInstance | undefined) => {
    if (saveLoading.value || !formEl) return

    await formEl.validate(async (valid) => {
        if (valid) {
            if (!await benefitsDiscountRef.value?.verify()) return
            if (!await giftBalanceRef.value?.verify()) return
            if (!await giftPointRef.value?.verify()) return

            saveLoading.value = true

            const saveData = cloneDeep(formData)

            // 处理 discount 数据
            if (saveData.level_benefits.discount && saveData.level_benefits.discount.is_use == 1) {
                saveData.level_benefits.discount.discount = Number(saveData.level_benefits.discount.discount)
            }

            // 清理空的 level_benefits 数据
            const hasDiscount = saveData.level_benefits.discount && Object.keys(saveData.level_benefits.discount).length > 0
            if (!hasDiscount) {
                saveData.level_benefits = {}
            }

            // 处理 balance 数据
            if (saveData.level_gifts.balance && saveData.level_gifts.balance.is_use == 1) {
                saveData.level_gifts.balance.money = Number(saveData.level_gifts.balance.money)
            }

            // 清理空的 level_gifts 数据
            const hasBalance = saveData.level_gifts.balance && Object.keys(saveData.level_gifts.balance).length > 0
            const hasPoint = saveData.level_gifts.point && Object.keys(saveData.level_gifts.point).length > 0
            if (!hasBalance && !hasPoint) {
                saveData.level_gifts = {}
            }

            const save = saveData.level_id ? updateMemberLevel : addMemberLevel
            save(saveData).then(() => {
                router.push({ path: '/member/level' })
            }).catch(() => {
                saveLoading.value = false
            })
        }
    })
}
</script>

<style lang="scss" scoped></style>

