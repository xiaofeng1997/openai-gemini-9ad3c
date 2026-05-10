<template>
    <view class="w-screen min-h-screen bg-[var(--page-bg-color)]" :style="themeColor()">
        <view class="home-wrap">
            <image
                class="w-full h-full"
                :src="img('static/resource/images/home.jpg')"
                mode="aspectFill"
            />
            <view class="absolute top-[120rpx] left-[56rpx] w-[650rpx]">
                <view class="flex flex-col">
                    <view class="mb-[50rpx] relative">
                        <view class="text-[#333] text-[36rpx] font-700">Hello</view>
                        <view class="absolute bottom-[-20rpx] left-0 w-[54rpx] h-[8rpx] bg-[#333]"></view>
                    </view>
                    <view class="mb-[32rpx] text-[#333] text-[48rpx] font-500 leading-[72rpx]">欢迎使用</view>
                    <view class="mb-[30rpx] text-[#010101] text-[48rpx] font-bold">NIUCLOUD Lite AI</view>
                    <view class="text-[#687387] text-[24rpx]">非插件化·易上手·灵活定制·AI辅助开发与业务功能智能化</view>
                </view>
            </view>
        </view>

        <!-- #ifdef MP-WEIXIN -->
        <collect-tip ref="collectTipRef" />
        <wx-privacy-popup ref="wxPrivacyPopupRef" />
        <!-- #endif -->

        <view class="relative z-[1] min-h-screen">
            <tabbar />
        </view>
    </view>
</template>

<script setup lang="ts">
import { ref } from 'vue'
import { img } from '@/utils/common'
import useConfigStore from '@/stores/config'

const configStore = useConfigStore()

const themeColor = () => {
    return configStore.getThemeColor()
}

const collectTipRef = ref()
const wxPrivacyPopupRef = ref()
</script>

<style lang="scss" scoped>
.home-wrap {
    position: fixed;
    top: 0;
    left: 0;
    z-index: 0;
    width: 100%;
    height: 100vh;
}
</style>

<style lang="scss">
.diy-template-wrap {
    /* #ifdef MP */
    .child-diy-template-wrap {
        ::v-deep .diy-group {
            > .draggable-element.top-fixed-diy {
                display: block !important;
            }
        }
    }
    /* #endif */
}
</style>