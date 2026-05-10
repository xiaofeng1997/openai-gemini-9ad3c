<template>
    <div class="flex h-full min-w-[1200px] bg-[rgba(255,255,255,0.5)]">
        <div class="w-[1200px] mx-auto flex items-center relative">
            <div class="flex items-center ml-[20px]">
                <NuxtLink to="/">
                    <div class="w-[132px] mr-[10px]"><img src="@/assets/images/index/logo.png" /></div>
                </NuxtLink>
            </div>

            <div class="ml-auto flex-shrink">
                <el-menu :default-active="appStore.route" mode="horizontal" :ellipsis="false" :router="true" class="flex items-center h-full !bg-transparent">
                    <el-menu-item index="official" class="!pr-[0] cursor-pointer">
                        <span class="text-[14px] mx-[10px] text-[#333]" @click.stop="openOfficial">官网网站</span>
                        <span></span>
                    </el-menu-item>
                    <view class="h-[12px] w-[1px] bg-[#999999]"></view>
                    <el-menu-item index="bbs" class="!pr-[0] cursor-pointer">
                        <span class="text-[14px] mx-[10px] text-[#333]" @click.stop="openBbs">技术论坛</span>
                        <span></span>
                    </el-menu-item>
                </el-menu>
            </div>
            <div class="flex items-center justify-end whitespace-pre-wrap absolute -right-[112px]">
                <div v-if="info">
                    <NuxtLink to="/member/center">
                        <span class="cursor-pointer">{{ info.nickname }}</span>
                    </NuxtLink>
                    <span class="mx-2">|</span>
                    <span class="cursor-pointer" @click="logoutFn">退出</span>
                </div>
                <el-button type="primary" link v-else @click="toLogin">{{ t('登录') }} / {{ t('注册') }}</el-button>
            </div>
        </div>
        <LoadingDialog/>
    </div>
</template>

<script lang="ts" setup>
import {  getToken } from '@/utils/common'
import useMemberStore from '@/stores/member'
import useAppStore from '@/stores/app'
import useConfigStore from '@/stores/config'
import LoadingDialog from '@/components/login-dialog/index.vue'

const configStore = useConfigStore()
const memberStore = useMemberStore()
const info = computed(() => memberStore.info)

const toLogin = () => {
    if(!getToken() && !configStore.login.is_username && !configStore.login.is_mobile && !configStore.login.is_bind_mobile){
        ElMessage.error('商家未开启普通账号登录注册')
        return false
    }
    memberStore.logOpen()
}
const logoutFn = () => {
    memberStore.logout()
    navigateTo(`/index`)
}

const openBbs = () => {
    window.open('https://www.niushop.com/bbs.html')
}
const openOfficial = () => {
    window.open('https://www.niucloud.com/')
}
const appStore = useAppStore()
</script>

<style lang="scss" scoped>
:deep(.el-menu--horizontal) {
    border-bottom: none;
}

.el-menu-item {
    padding-left: 0;
    border: none !important;
    color: #000 !important;

    &.is-active {
        border: none !important;
        color: #000 !important;

        span {
            &:first-of-type {
                position: relative;
                z-index: 1;
            }

            &:last-of-type {
                position: absolute;
                width: 16px;
                height: 16px;
                background-image: linear-gradient(to bottom right, #FFFFFF, var(--el-color-primary));
                border-radius: 100px;
                bottom: 15px;
                right: 27px;
                z-index: 0;
            }
        }
    }

    &:hover {
        background-color: transparent !important;
        color: var(--el-menu-hover-text-color) !important;
    }

    &:focus {
        background-color: transparent !important;
    }
}
</style>
