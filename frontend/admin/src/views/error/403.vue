<template>
    <div class="error-page">
        <div class="error-inner">
            <div class="error-visual">
                <img
                    class="error-illustration"
                    src="@/assets/images/defaultImg/403Img.png"
                    alt=""
                />
     
            </div>
            <div class="error-copy">
                <h1 class="error-title">抱歉！</h1>
                <p class="error-sub">您没有操作角色...</p>
                <p class="error-desc">
                    当前账号没有操作角色，请联系管理员。
                </p>
                <el-button class="error-btn" @click="goBack">返回</el-button>
            </div>
        </div>
    </div>
</template>

<script lang="ts" setup>
import { useRouter } from 'vue-router'
import { getAppType } from '@/utils/common'

const router = useRouter()

function goBack () {
    if (window.history.length > 1) {
        router.go(-1)
    } else {
        router.push({ path: `/${getAppType()}` })
    }
}
</script>

<style lang="scss" scoped>
$error-font: 'Source Han Sans CN', 'Noto Sans SC', 'PingFang SC', sans-serif;

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

.error-code {
    margin-top: 8px;
    font-size: clamp(48px, 8vw, 72px);
    font-weight: 700;
    line-height: 1;
    color: #2774e9;
    font-family: $error-font;
    letter-spacing: 0.02em;
}

.error-copy {
    flex: 1;
    min-width: 260px;
    max-width: 420px;
    text-align: left;
}

.error-title {
    margin: 0;
    color: #2774e9;
    font-family: $error-font;
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
    margin-top: 24px;
    padding: 0;
    border-radius: 20px;
    background: #2774e9;
    border: 1px solid #2774e9;
    color: #ffffff;
    font-family: $error-font;
    font-size: 14px;
    font-style: normal;
    font-weight: 400;
    line-height: normal;

    &:hover,
    &:focus {
        background: #1f66d4;
        border-color: #1f66d4;
        color: #ffffff;
    }
}
</style>
