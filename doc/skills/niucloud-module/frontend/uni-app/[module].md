# 移动端模块页面

## 概述

移动端模块页面用于在微信小程序等移动端平台展示和提交模块数据。

## 代码结构

```vue
<template>
    <view :style="themeColor()">
        <loading-page :loading="module.getLoading()"></loading-page>
        
        <view v-show="requestData.status == 1 && requestData.error && requestData.error.length === 0 && !module.getLoading()">
            <!-- 自定义模板渲染 -->
            <view class="module-template-wrap bg-index" :style="module.pageStyle()">
                <module-group ref="moduleGroupRef" :data="module.data" />
            </view>
        </view>
        
        <view class="w-screen h-screen flex flex-col " v-if="requestData.error && requestData.error.length > 0">
            <view class="flex-1 flex flex-col items-center pt-[180rpx] px-[60rpx]" v-for="(item, index) in requestData.error.slice(0, 1)" :key="index">
                <text class="nc-iconfont nc-icon-tanhaoV6mm text-[#ccc] mb-[30rpx] !text-[100rpx]"></text>
                <view class="text-[38rpx] font-bold mt-3">{{ item.title }}</view>
                <view class="p-[30rpx] mt-10 w-full ">
                    <view class="flex w-full">
                        <view class="w-[30%] text-[#999] text-left">{{ item.type }}</view>
                        <view class="w-[70%] text-left">{{ item.desc }}</view>
                    </view>
                </view>
            </view>
            <view class="pb-[260rpx]">
                <button class="w-[380rpx] !border-0 h-[80rpx] text-[28rpx] text-[#333] !bg-[#f2f2f2] flex-center font-500 rounded-[20rpx]" :plain="true" @click="finishFn">{{ t('close') }}</button>
            </view>
        </view>
        
        <!-- #ifdef MP-WEIXIN -->
        <!-- 小程序隐私协议 -->
        <wx-privacy-popup ref="wxPrivacyPopupRef"></wx-privacy-popup>
        <!-- #endif -->
    </view>
</template>

<script setup lang="ts">
import { ref, nextTick, computed } from 'vue';
import { useModule } from '@/hooks/useModule'
import { useShare } from '@/hooks/useShare'
import { img, redirect } from '@/utils/common';
import { t } from '@/locale'

const { setShare } = useShare()

const module = useModule({
    needLogin: false // 检测登录
})

const moduleGroupRef = ref(null)

const wxPrivacyPopupRef: any = ref(null)

const requestData = computed(() => {
    return module.requestData;
})

const finishFn = () => {
    redirect({
        url: '/pages/index/index',
        mode: 'reLaunch'
    });
}

module.onLoad((data: any) => {
    let share = data.share ? data.share : null;
    setShare(share);
    moduleGroupRef.value?.refresh();
    // #ifdef MP
    nextTick(() => {
        if (wxPrivacyPopupRef.value) wxPrivacyPopupRef.value.proactive();
    })
    // #endif
});

// 监听页面显示
module.onShow((data: any) => {
    let share = data.share ? data.share : null;
    if (share) {
        setShare(share);
    }
    moduleGroupRef.value?.refresh();
    // #ifdef MP
    nextTick(() => {
        if (wxPrivacyPopupRef.value) wxPrivacyPopupRef.value.proactive();
    })
    // #endif
});

// 监听页面隐藏
module.onHide();

// 监听页面卸载
module.onUnload();

// 监听滚动事件
module.onPageScroll()
</script>

<style lang="scss" scoped>
@import '@/styles/module.scss';
</style>

<style lang="scss">
.module-template-wrap {
    /* #ifdef MP */
    .child-module-template-wrap {
        ::v-deep .module-group {
            > .draggable-element.top-fixed-module {
                display: block !important;
            }
        }
    }
    /* #endif */
}
</style>
```