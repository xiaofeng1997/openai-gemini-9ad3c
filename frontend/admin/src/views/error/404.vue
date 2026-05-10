<template>
    <div class="error-page">
        <div class="error-inner">
            <div class="error-visual">
                <slot name="content">
                    <img
                        class="error-illustration"
                        src="@/assets/images/defaultImg/404Img.png"
                        alt=""
                    />
                </slot>
            </div>
            <div class="error-copy">
                <h1 class="error-title">抱歉！</h1>
                <p class="error-sub">当前页面不存在...</p>
                <p class="error-desc">
                    请检查您输入的地址是否正确，或点击下面的按钮返回首页。
                </p>
                <el-button class="error-btn" @click="goHome">返回首页</el-button>
            </div>
        </div>
    </div>
</template>

<script lang="ts" setup>
import { useRouter } from 'vue-router'
import { getAppType } from '@/utils/common'

const router = useRouter()

function goHome () {
    router.push({ path: `/${getAppType()}` })
}
</script>

<style lang="scss" scoped>
.error-page {
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    background: #fff;
    padding: 32px 24px;
    box-sizing: border-box;
}

.error-inner {
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    justify-content: center;
    gap: clamp(32px, 6vw, 72px);
    max-width: 960px;
    width: 100%;
}

.error-visual {
    display: flex;
    flex-direction: column;
    align-items: center;
    flex-shrink: 0;
}

.error-illustration {
    display: block;
    width: min(100%, 360px);
    height: auto;
}

.error-copy {
    flex: 1;
    min-width: 260px;
    max-width: 420px;
    text-align: left;
}

$error-font: 'Source Han Sans CN', 'Noto Sans SC', 'PingFang SC', sans-serif;

.error-title {
    margin: 0;
    color: #2774e9;
 font-family: "Source Han Sans CN";
 font-size: 30px;
 font-style: normal;
 font-weight: 400;
 line-height: normal;
}

.error-sub {
    margin: 12px 0 0;
    color: #333333;
    font-family: $error-font;
    font-size: 20px;
    font-style: normal;
    font-weight: 400;
    line-height: normal;
}

.error-desc {
    margin: 9px 0 0;
    width: 302px;
    max-width: 100%;
    box-sizing: border-box;
    color: #666666;
    font-family: $error-font;
    font-size: 14px;
    font-style: normal;
    font-weight: 400;
    line-height: normal;
}

.error-btn {
    width: 110px;
    height: 36px;
    border-radius: 20px;
    background: #2774E9;
    margin-top:31px;
    color: #fff;
}
</style>
