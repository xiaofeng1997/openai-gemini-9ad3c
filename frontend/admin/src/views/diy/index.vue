<template>
    <div class="main-container">
        <el-card class="box-card !border-none" shadow="never">

            <div class="flex flex-wrap min-w-[1200px]" v-if="page.use_template">
                <div class="page-item relative w-[340px] mr-[40px] pt-[90px] pb-[20px] bg-[#f7f7f7] bg-no-repeat">
                    <p class="absolute top-[54px] left-[50%] translate-x-[-50%] w-[130px] text-[14px] truncate text-center">{{ page.use_template.title }}</p>

                    <div v-show="page.use_template.url" class="w-[320px] h-[550px] mx-auto">
                        <iframe :id="'previewIframe_' + type" class="w-[320px] h-[550px] mx-auto" :src="page.use_template.wapPreview" frameborder="0"></iframe>
                    </div>

                </div>

                <div class="w-[700px]">

                    <div class="info-wrap">
                        <div class="mt-[20px] p-[20px] flex items-center justify-between bg">
                            <div>
                                <div class="font-bold">{{ t('H5') }}</div>
                                <el-form label-width="40px" class="mt-[5px]">
                                    <el-form-item :label="t('link')" class="mb-[5px]">
                                        <el-input readonly :value="page.use_template.shareUrl" class="!w-[390px]">
                                            <template #append>
                                                <el-button @click="copyEvent(page.use_template.shareUrl)" class="bg-primary copy">{{ t('copy') }}</el-button>
                                            </template>
                                        </el-input>
                                    </el-form-item>
                                </el-form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </el-card>
    </div>
</template>

<script lang="ts" setup>
import { reactive, ref, watch } from 'vue'
import { t } from '@/lang'
import { img } from '@/utils/common'
import { useRouter } from 'vue-router'
import { ElMessage } from 'element-plus'
import storage from '@/utils/storage'
import QRCode from 'qrcode'
import { useClipboard } from '@vueuse/core'

const type: any = ref('DIY_INDEX');
const page: any = reactive({
    use_template: {},
    loadingDev: true,
    difference: 0,
    isDisabledPop: true,
    timeIframe: 0,
    shareUrl: '',
    wapUrl: '',
})
const router = useRouter()

const refreshData = ()=>{
    page.use_template.title = 'Lite 预览'
    page.use_template.url = import.meta.env.VITE_WAP_DOMAIN || `${ location.origin }/wap/`
    page.use_template.wapPreview = import.meta.env.VITE_WAP_DOMAIN || `${ location.origin }/wap/`
    page.use_template.shareUrl = import.meta.env.VITE_WAP_DOMAIN || `${ location.origin }/wap/`
}
refreshData()


// 复制
const { copy, isSupported, copied } = useClipboard()
const copyEvent = (text: string) => {
    if (!isSupported.value) {
        ElMessage({
            message: t('notSupportCopy'),
            type: 'warning'
        })
    }
    copy(text)
}

watch(copied, () => {
    if (copied.value) {
        ElMessage({
            message: t('copySuccess'),
            type: 'success'
        })
    }
})
</script>

<style lang="scss" scoped>
    .page-item {
        background-image: url(@/assets/images/iphone_bg.png);
        background-color: var(--el-bg-color);
        background-size: 100%;

        .popup-wrap {
            display: none;
        }

        &:hover {
            .popup-wrap:not(.disabled) {
                display: block !important;
            }
        }
    }
</style>

