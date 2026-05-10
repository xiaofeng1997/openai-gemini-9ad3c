<template>
    <view class="w-screen min-h-screen bg-[var(--page-bg-color)]" :style="themeColor()">
        <view class="member-top">
            <image
                class="absolute left-0 top-0 w-full h-[502rpx] pointer-events-none"
                :src="img('static/resource/images/member/my/top.png')"
                mode="aspectFill"
            />
            <view class="relative z-[1] box-border w-full px-[48rpx] flex flex-col">
                <view class="member-title text-center" :style="navbarInnerStyle">NIUCLOUD</view>
                <view class="member-title-fill" :style="navbarInnerStyle"></view>
                <view class="mt-[48rpx] flex flex-row items-center">
                    <u-avatar
                        :src="img(info.headimg)"
                        size="100rpx"
                        :default-url="img('static/resource/images/default_headimg.png')"
                        shape="circle"
                        @click="handleAvatarClick"
                    />
                    <view class="flex-1 min-w-0 ml-[24rpx]">
                        <view v-if="isLogin" class="flex flex-row items-center flex-wrap gap-[16rpx]">
                            <text class="text-[32rpx] font-bold text-[#111] truncate max-w-[320rpx]">{{ info.nickname }}</text>
                        </view>
                        <view v-else @click="toLogin">
                            <text class="text-[32rpx] font-bold text-[#111]">{{ t('login') }}/{{ t('register') }}</text>
                        </view>
                        <text v-if="isLogin" class="block mt-[12rpx] text-[24rpx] text-[#333]">ID: {{ info.member_no }}</text>
                    </view>
                    <view v-if="isLogin" @click="redirect({ url: '/pages/setting/index' })">
                        <text class="nc-iconfont nc-icon-shezhiV6xx-1 text-[40rpx] text-[#111]"></text>
                    </view>
                </view>
            </view>
        </view>

        <view class="relative z-[2] px-[32rpx] pt-0 pb-[calc(32rpx+env(safe-area-inset-bottom))] mt-[66rpx]">
            <view class="bg-white rounded-[24rpx] shadow-[0_8rpx_32rpx_rgba(0,0,0,0.06)] p-[30rpx] mb-[20rpx]">
                <text class="block text-[32rpx] font-500 text-[#111] mb-[36rpx] leading-[45rpx]">我的服务</text>
                <view class="flex flex-row justify-between items-start">
                    <view
                        v-for="item in serviceList"
                        :key="item.name"
                        class="flex-1 flex flex-col items-center gap-[16rpx]"
                        @click="redirect({ url: item.url })"
                    >
                        <image
                            class="w-[46rpx] h-[46rpx]"
                            :src="img(item.icon)"
                            mode="aspectFit"
                        />
                        <text class="text-[24rpx] text-[#333] font-500 text-center leading-[1.3]">{{ item.name }}</text>
                    </view>
                </view>
            </view>

            <view class="rounded-[24rpx] h-[214rpx] overflow-hidden"  @click="redirect({ url: 'https://gitee.com/niucloud-team/niucloud-lite-ai' })">
                <image
                    class="block w-full"
                    :src="img('static/resource/images/member/my/other_functions.jpg')"
                    mode="widthFix"
                />
            </view>
        </view>

        <view class="relative z-[3]">
            <tabbar />
        </view>
    </view>
</template>

<script setup lang="ts">
import { computed } from 'vue'
import { img, redirect, moneyFormat } from '@/utils/common'
import { t } from '@/locale'
import useMemberStore from '@/stores/member'
import { useLogin } from '@/hooks/useLogin'
import useConfigStore from '@/stores/config'
import { onPageScroll, onReachBottom, onLoad, onShow } from '@dcloudio/uni-app'
import useSystemStore from '@/stores/system';

interface ServiceItem {
    name: string
    icon: string
    url: string
}

const systemStore = useSystemStore()
const memberStore = useMemberStore()
const configStore = useConfigStore()

const isLogin = computed(() => !!memberStore.token)
const info = computed(() => memberStore.info || {
    headimg: '',
    nickname: '',
    member_no: '',
    point: 0,
    commission: 0,
    balance: 0,
    money: 0
})

// 导航栏内部盒子的样式
const navbarInnerStyle = computed(() => {
    let style = '';
    style += 'padding-right: 30rpx;'; //右边留边
    style += 'padding-left: 30rpx;'; //左边留边
    // #ifdef MP
    // 导航栏宽度，如果在小程序下，导航栏宽度为胶囊的左边到屏幕左边的距离
    style += 'height:' + systemStore.menuButtonInfo.height + 'px;';
    style += 'padding-top:' + systemStore.menuButtonInfo.top + 'px;';
    style += 'padding-bottom: 8px;';
    // #endif
    // #ifdef APP-PLUS
     style += 'padding-top:' + systemStore.systemInfo.statusBarHeight + 'px;';
    // #endif
    return style;
})

onLoad(() => {
    if (memberStore.token && !memberStore.info) {
        memberStore.getMemberInfo()
    }
})

onShow(() => {
    if (memberStore.token && !memberStore.info) {
        memberStore.getMemberInfo()
    }
})

const balance = computed(() => {
    const infoData = info.value
    return parseFloat(infoData.balance || 0) + parseFloat(infoData.money || 0)
})

const serviceList: ServiceItem[] = [
    { name: '个人设置', icon: 'static/resource/images/member/my/settings.png', url: '/pages/member/personal' },
    { name: '联系客服', icon: 'static/resource/images/member/my/service.png', url: '/pages/member/contact' },
    { name: '关于', icon: 'static/resource/images/member/my/coupon.png', url: '/pages/member/about' },
    { name: '首页', icon: 'static/resource/images/member/my/home.png', url: '/pages/index/index' }
]

const toLogin = () => {
    let normalLogin = !configStore.login.is_username && !configStore.login.is_mobile && !configStore.login.is_bind_mobile
    let authRegisterLogin = !configStore.login.is_auth_register

    if (normalLogin && authRegisterLogin) {
        uni.showToast({ title: '商家未开启登录注册', icon: 'none' })
        return
    }

    if (configStore.login.is_username || configStore.login.is_mobile || configStore.login.is_bind_mobile) {
        useLogin().setLoginBack({ url: '/pages/member/index' })
    }
}

const handleAvatarClick = () => {
    if (isLogin.value) {
        redirect({ url: '/pages/member/personal' })
    } else {
        toLogin()
    }
}
</script>
<style scoped lang="scss">
.member-title {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    font-size: 36rpx;
    font-weight: bold;
    color: #111;
    height: 88rpx;
    line-height: 88rpx;
}
.member-title-fill{
    width: 100%;
    height: 88rpx;
}
</style>
