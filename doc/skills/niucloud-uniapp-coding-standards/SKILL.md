name: "niucloud-uniapp-coding-standards"
description: "提供NiuCloud手机端uni-app编码规范，包括页面结构、组件开发、API调用、DIY系统、样式编写、国际化等完整开发标准。触发关键词：uni-app、手机端、移动端、小程序、H5、APP、移动开发、uniapp、跨平台、移动端编码、小程序开发、H5开发。在开发手机端功能时调用此技能。"
---

# NiuCloud Uni-App 编码规范

> 本规范基于 NiuCloud 手机端的实际代码分析总结，提供完整的 uni-app + Vue3 + TypeScript 编码标准。

## 📋 快速导航

- [一、技术栈](#一技术栈)
- [二、项目结构](#二项目结构)
- [三、页面基础结构](#三页面基础结构)
- [四、组件开发规范](#四组件开发规范)
- [五、API调用规范](#五api调用规范)
- [六、DIY系统开发](#六diy系统开发)
- [七、状态管理](#七状态管理)
- [八、样式编写规范](#八样式编写规范)
- [九、国际化规范](#九国际化规范)
- [十、条件编译](#十条件编译)
- [十一、完整示例](#十一完整示例)

---

## 一、技术栈

### 1.1 核心技术

| 技术 | 版本 | 用途 |
|------|------|------|
| Vue | 3.3.0 | 前端框架 |
| TypeScript | 4.9.4 | 类型系统 |
| uni-app | 3.0.0 | 跨平台框架 |
| uview-plus | 3.1.29 | UI组件库 |
| Pinia | 2.0.36 | 状态管理 |
| Vite | 4.0.4 | 构建工具 |
| Vue I18n | 9.2.2 | 国际化 |
| Sass | 1.54.5 | CSS预处理器 |

### 1.2 依赖库

```json
{
  "dependencies": {
    "@dcloudio/uni-app": "3.0.0-3080720230703001",
    "pinia": "2.0.36",
    "uview-plus": "^3.1.29",
    "vue": "^3.3.0",
    "vue-i18n": "^9.2.2",
    "lodash-es": "^4.17.21",
    "qrcode": "^1.5.1",
    "qs": "6.7.0"
  }
}
```

### 1.3 支持平台

- **H5**：网页端
- **MP-WEIXIN**：微信小程序
- **MP-ALIPAY**：支付宝小程序
- **MP-BAIDU**：百度小程序
- **MP-TOUTIAO**：字节跳动小程序
- **APP**：原生应用
- **APP-ANDROID**：Android应用
- **APP-IOS**：iOS应用

---

## 二、项目结构

### 2.1 目录结构

```
src/
├── api/                    # API接口定义
│   ├── auth.ts           # 认证相关API
│   ├── member.ts         # 会员相关API
│   ├── system.ts         # 系统相关API
│   └── diy.ts           # DIY相关API
├── components/            # 公共组件
│   ├── diy/             # DIY组件
│   ├── upload-image/     # 图片上传组件
│   └── sms-code/        # 短信验证码组件
├── hooks/                # 自定义hooks
│   ├── useDiy.ts        # DIY hook
│   ├── useLogin.ts       # 登录hook
│   └── useShare.ts      # 分享hook
├── locale/               # 国际化文件
│   ├── zh-Hans/         # 中文语言包
│   └── en/              # 英文语言包
├── pages/                # 页面
│   ├── index/           # 首页
│   ├── member/          # 会员中心
│   ├── auth/            # 认证页面
│   └── pay/             # 支付页面
├── stores/               # Pinia状态管理
│   ├── member.ts        # 会员状态
│   ├── config.ts        # 配置状态
│   └── diy.ts          # DIY状态
├── styles/               # 样式文件
│   ├── common.scss      # 通用样式
│   ├── diy.scss         # DIY样式
│   └── index.scss       # 入口样式
├── utils/                # 工具函数
│   ├── request.ts       # 请求封装
│   ├── common.ts        # 通用函数
│   └── storage.ts      # 本地存储
├── App.vue               # 根组件
├── main.js               # 入口文件
├── pages.json            # 页面配置
└── manifest.json         # 应用配置
```

### 2.2 文件命名规范

- **页面文件**：小写+连字符，如 `personal.vue`、`index.vue`
- **组件文件**：小写+连字符，如 `upload-image/index.vue`
- **API文件**：小写+下划线，如 `member.ts`、`auth.ts`
- **语言文件**：小写+连字符，如 `common.json`
- **Hook文件**：小写+连字符，如 `useDiy.ts`

---

## 三、页面基础结构

### 3.1 标准页面模板

```vue
<template>
    <view class="page-wrap" :style="themeColor()">
        <!-- 页面内容 -->
    </view>
</template>

<script setup lang="ts">
import { ref, computed, onMounted } from 'vue'
import { onLoad, onShow, onHide, onUnload } from '@dcloudio/uni-app'
import { t } from '@/locale'

// 页面数据
const loading = ref(true)

// 监听页面加载
onLoad((option: any) => {
    // 页面加载逻辑
})

// 监听页面显示
onShow(() => {
    // 页面显示逻辑
})

// 监听页面隐藏
onHide(() => {
    // 页面隐藏逻辑
})

// 监听页面卸载
onUnload(() => {
    // 页面卸载逻辑
})
</script>

<style lang="scss" scoped>
.page-wrap {
    // 页面样式
}
</style>
```

### 3.2 页面生命周期

```typescript
import { onLoad, onShow, onHide, onUnload, onPullDownRefresh, onReachBottom } from '@dcloudio/uni-app'

// 页面加载
onLoad((option: any) => {
    console.log('页面加载', option)
})

// 页面显示
onShow(() => {
    console.log('页面显示')
})

// 页面隐藏
onHide(() => {
    console.log('页面隐藏')
})

// 页面卸载
onUnload(() => {
    console.log('页面卸载')
})

// 下拉刷新
onPullDownRefresh(() => {
    console.log('下拉刷新')
    uni.stopPullDownRefresh()
})

// 触底加载
onReachBottom(() => {
    console.log('触底加载')
})
```

### 3.3 页面导航

```typescript
import { redirect, navigateTo, switchTab, reLaunch } from '@/utils/common'

// 跳转页面（保留当前页）
navigateTo({ url: '/pages/member/personal' })

// 跳转页面（关闭当前页）
redirect({ url: '/pages/member/personal' })

// 跳转tabbar页面
switchTab({ url: '/pages/index/index' })

// 重启应用
reLaunch({ url: '/pages/index/index' })

// 返回上一页
uni.navigateBack({ delta: 1 })
```

---

## 四、组件开发规范

### 4.1 组件基础结构

```vue
<template>
    <view class="component-name">
        <!-- 组件内容 -->
    </view>
</template>

<script setup lang="ts">
import { ref, reactive, computed, watch } from 'vue'

// Props定义
interface Props {
    modelValue: any
    disabled?: boolean
}

const props = withDefaults(defineProps<Props>(), {
    disabled: false
})

// Emits定义
const emit = defineEmits<{
    'update:modelValue': [value: any]
    'change': [value: any]
}>()

// 响应式数据
const data = ref<any>(null)

// 计算属性
const computedValue = computed(() => {
    return props.modelValue
})

// 监听
watch(() => props.modelValue, (newVal) => {
    data.value = newVal
})

// 方法
const handleChange = (value: any) => {
    emit('update:modelValue', value)
    emit('change', value)
}
</script>

<style lang="scss" scoped>
.component-name {
    // 组件样式
}
</style>
```

### 4.2 常用uview-plus组件

#### Cell单元格

```vue
<u-cell-group :border="false" class="cell-group">
    <u-cell :title="t('nickname')" :is-link="true" :value="info.nickname" @click="handleClick" />
    <u-cell :title="t('mobile')" :value="info.mobile" />
</u-cell-group>
```

#### Popup弹窗

```vue
<u-popup :show="showPopup" mode="center" round="10" @close="showPopup = false">
    <view class="popup-content">
        <!-- 弹窗内容 -->
    </view>
</u-popup>
```

#### ActionSheet选择器

```vue
<u-action-sheet :actions="actions" :show="showSheet" @close="showSheet = false" @select="handleSelect" />
```

#### DateTimePicker时间选择

```vue
<u-datetime-picker
    v-model="dateValue"
    :show="showPicker"
    mode="date"
    :maxDate="new Date().valueOf()"
    @confirm="handleConfirm"
    @cancel="showPicker = false"
/>
```

#### Avatar头像

```vue
<u-avatar
    :src="img(info.headimg)"
    :default-url="img('static/resource/images/default_headimg.png')"
    size="40"
/>
```

#### Upload上传

```vue
<u-upload @afterRead="afterRead" :maxCount="1" />
```

---

## 五、API调用规范

### 5.1 API文件结构

```typescript
import request from '@/utils/request'

/**
 * 获取会员信息
 */
export function getMemberInfo() {
    return request.get('member/member')
}

/**
 * 获取积分流水
 */
export function getPointList(data: AnyObject) {
    return request.get('member/account/point', data)
}

/**
 * 修改会员信息
 */
export function modifyMember(data: AnyObject) {
    return request.put(`member/modify/${data.field}`, data, { showErrorMessage: true })
}

/**
 * 上传图片
 */
export function uploadImage(data: AnyObject) {
    return request.upload('upload/image', data)
}
```

### 5.2 请求配置

```typescript
// 显示成功消息
return request.get('member/member', {}, { showSuccessMessage: true })

// 不显示错误消息
return request.get('member/member', {}, { showErrorMessage: false })

// 自定义配置
return request.get('member/member', {}, {
    showSuccessMessage: true,
    showErrorMessage: true
})
```

### 5.3 API调用示例

```typescript
import { getMemberInfo, modifyMember, getPointList } from '@/api/member'

// 获取数据
const loadData = async () => {
    try {
        const res = await getMemberInfo()
        info.value = res.data
    } catch (error) {
        console.error(error)
    }
}

// 提交数据
const handleSubmit = async () => {
    try {
        await modifyMember({
            field: 'nickname',
            value: nickname.value
        })
        uni.showToast({ title: '修改成功', icon: 'success' })
    } catch (error) {
        console.error(error)
    }
}

// 分页加载
const loadMore = async () => {
    if (loading.value) return
    loading.value = true
    try {
        const res = await getPointList({
            page: page.value,
            limit: limit.value
        })
        list.value = [...list.value, ...res.data.data]
        total.value = res.data.total
    } catch (error) {
        console.error(error)
    } finally {
        loading.value = false
    }
}
```

---

## 六、DIY系统开发

### 6.1 DIY页面结构

```vue
<template>
    <view :style="themeColor()">
        <loading-page :loading="diy.getLoading()"></loading-page>

        <view v-show="!diy.getLoading()">
            <view class="diy-template-wrap" :style="diy.pageStyle()">
                <diy-group ref="diyGroupRef" :data="diy.data" />
            </view>
        </view>
    </view>
</template>

<script setup lang="ts">
import { ref, nextTick } from 'vue'
import { useDiy } from '@/hooks/useDiy'

const diy = useDiy({
    name: 'DIY_MEMBER_INDEX'
})

const diyGroupRef = ref(null)

// 监听页面加载
diy.onLoad()

// 监听页面显示
diy.onShow((data: any) => {
    if (data.value) {
        diyGroupRef.value?.refresh()
    }
})

// 监听页面隐藏
diy.onHide()

// 监听页面卸载
diy.onUnload()

// 监听滚动事件
diy.onPageScroll()
</script>

<style lang="scss" scoped>
@import '@/styles/diy.scss';
</style>
```

### 6.2 DIY组件开发

```vue
<template>
    <view class="diy-component" :style="component.pageStyle">
        <view class="component-content">
            <!-- 组件内容 -->
        </view>
    </view>
</template>

<script setup lang="ts">
import { computed } from 'vue'
import { img } from '@/utils/common'

const props = defineProps<{
    component: any
    global: any
    index: number
}>()

const componentData = computed(() => {
    return props.component
})
</script>

<style lang="scss" scoped>
.diy-component {
    // 组件样式
}
</style>
```

### 6.3 常用DIY组件

| 组件名 | 用途 |
|--------|------|
| GraphicNav | 图文导航 |
| ImageAds | 图片广告 |
| Notice | 公告通知 |
| MemberInfo | 会员信息 |
| RichText | 富文本 |
| CarouselSearch | 轮播搜索 |
| FloatBtn | 悬浮按钮 |

---

## 七、状态管理

### 7.1 Store基础结构

```typescript
import { defineStore } from 'pinia'

export const useMemberStore = defineStore('member', {
    state: () => ({
        info: null as any,
        token: ''
    }),
    getters: {
        isLogin: (state) => !!state.token,
        nickname: (state) => state.info?.nickname || ''
    },
    actions: {
        setInfo(info: any) {
            this.info = info
        },
        setToken(token: string) {
            this.token = token
        },
        async getMemberInfo() {
            const res = await getMemberInfo()
            this.info = res.data
        }
    }
})
```

### 7.2 使用Store

```typescript
import useMemberStore from '@/stores/member'

const memberStore = useMemberStore()

// 获取状态
const info = computed(() => memberStore.info)
const isLogin = computed(() => memberStore.isLogin)

// 调用方法
memberStore.setInfo(data)
memberStore.setToken(token)
await memberStore.getMemberInfo()
```

---

## 八、样式编写规范

### 8.1 单位使用

```scss
// 使用rpx单位（响应式像素）
width: 750rpx;
height: 100rpx;
font-size: 28rpx;
margin: 20rpx;
padding: 30rpx;

// 使用px单位（固定像素）
border-width: 1px;
```

### 8.2 常用样式类

```scss
// 页面容器
.page-wrap {
    width: 100%;
    min-height: 100vh;
}

// 卡片样式
.card-template {
    background: #fff;
    border-radius: 10rpx;
    padding: 20rpx;
}

// 按钮样式
.primary-btn {
    background: var(--primary-color);
    color: #fff;
    border-radius: 100rpx;
    height: 80rpx;
    line-height: 80rpx;
}

// 文字样式
.text-primary {
    color: var(--primary-color);
}

.text-gray {
    color: #999;
}
```

### 8.3 主题色使用

```vue
<template>
    <view :style="themeColor()">
        <!-- 使用主题色 -->
        <view class="text-primary">{{ t('title') }}</view>
    </view>
</template>

<script setup lang="ts">
const themeColor = () => {
    return {
        '--primary-color': '#ff6b00'
    }
}
</script>
```

---

## 九、国际化规范

### 9.1 语言文件结构

```json
{
    "nickname": "昵称",
    "nicknamePlaceholder": "请输入昵称",
    "headimg": "头像",
    "mobile": "手机号",
    "confirm": "确认",
    "cancel": "取消",
    "save": "保存",
    "delete": "删除",
    "edit": "编辑",
    "search": "搜索",
    "reset": "重置"
}
```

### 9.2 使用国际化

```typescript
import { t } from '@/locale'

// 在模板中使用
{{ t('nickname') }}
{{ t('nicknamePlaceholder') }}

// 在脚本中使用
const message = t('nicknamePlaceholder')
```

### 9.3 国际化命名规范

- **字段名**：`fieldName`
- **占位符**：`fieldNamePlaceholder`
- **错误提示**：`fieldNameError`
- **成功提示**：`fieldNameSuccess`
- **按钮文字**：`confirm`、`cancel`、`save`
- **状态文字**：`statusNormal`、`statusDeactivate`

---

## 十、条件编译

### 10.1 平台判断

```vue
<!-- #ifdef MP-WEIXIN -->
<view>微信小程序</view>
<!-- #endif -->

<!-- #ifdef H5 -->
<view>H5端</view>
<!-- #endif -->

<!-- #ifdef APP-PLUS -->
<view>APP端</view>
<!-- #endif -->

<!-- #ifndef MP-WEIXIN -->
<view>非微信小程序</view>
<!-- #endif -->
```

### 10.2 常用条件编译场景

```vue
<!-- 微信小程序获取头像 -->
<!-- #ifdef MP-WEIXIN -->
<button open-type="chooseAvatar" @chooseavatar="onChooseAvatar">
    <u-avatar :src="info.headimg" />
</button>
<!-- #endif -->

<!-- 非微信小程序上传头像 -->
<!-- #ifndef MP-WEIXIN -->
<u-upload @afterRead="afterRead">
    <u-avatar :src="info.headimg" />
</u-upload>
<!-- #endif -->

<!-- 微信小程序获取手机号 -->
<!-- #ifdef MP-WEIXIN -->
<button open-type="getPhoneNumber" @getphonenumber="getPhoneNumber">
    {{ t('bindMobile') }}
</button>
<!-- #endif -->

<!-- H5跳转绑定 -->
<!-- #ifdef H5 -->
<button @click="redirect({ url: '/pages/auth/bind' })">
    {{ t('bindMobile') }}
</button>
<!-- #endif -->
```

### 10.3 条件编译API

```typescript
// #ifdef MP-WEIXIN
wx.openSetting()
// #endif

// #ifdef H5
window.location.href = url
// #endif

// #ifdef APP-PLUS
plus.runtime.openURL(url)
// #endif
```

---

## 十一、完整示例

### 11.1 个人中心页面

```vue
<template>
    <view class="w-full min-h-screen bg-page personal-wrap" v-if="info" :style="themeColor()">
        <view class="py-[20rpx]">
            <u-cell-group :border="false" class="cell-group">
                <u-cell :title="t('headimg')" :is-link="true">
                    <template #value>
                        <!-- #ifdef MP-WEIXIN -->
                        <button open-type="chooseAvatar" @chooseavatar="onChooseAvatar" :plain="true" class="border-0">
                            <u-avatar :src="img(info.headimg)" size="40" />
                        </button>
                        <!-- #endif -->
                        <!-- #ifndef MP-WEIXIN -->
                        <u-upload @afterRead="afterRead" :maxCount="1">
                            <u-avatar :src="img(info.headimg)" size="40" />
                        </u-upload>
                        <!-- #endif -->
                    </template>
                </u-cell>
                <u-cell :title="t('nickname')" :is-link="true" :value="info.nickname" @click="showNickname = true" />
                <u-cell :title="t('mobile')" :value="info.mobile" />
            </u-cell-group>
        </view>

        <!-- 修改昵称弹窗 -->
        <u-popup :show="showNickname" mode="center" round="10" @close="showNickname = false">
            <view class="popup-content">
                <view class="title">{{ t('updateNickname') }}</view>
                <input v-model="nickname" :placeholder="t('nicknamePlaceholder')" class="input" />
                <button @click="updateNicknameConfirm" class="primary-btn">{{ t('confirm') }}</button>
            </view>
        </u-popup>
    </view>
</template>

<script setup lang="ts">
import { ref, computed } from 'vue'
import { t } from '@/locale'
import useMemberStore from '@/stores/member'
import { img, mobileConceal } from '@/utils/common'
import { modifyMember } from '@/api/member'
import { fetchBase64Image, uploadImage } from '@/api/system'

const memberStore = useMemberStore()
const info = computed(() => memberStore.info)

const showNickname = ref(false)
const nickname = ref('')

// 修改昵称
const updateNicknameConfirm = () => {
    if (!nickname.value) {
        uni.showToast({ title: t('nicknamePlaceholder'), icon: 'none' })
        return
    }

    modifyMember({
        field: 'nickname',
        value: nickname.value
    }).then(() => {
        memberStore.info.nickname = nickname.value
        showNickname.value = false
        uni.showToast({ title: '修改成功', icon: 'success' })
    })
}

// 微信小程序选择头像
const onChooseAvatar = (e: any) => {
    uni.getFileSystemManager().readFile({
        filePath: e.detail.avatarUrl,
        encoding: 'base64',
        success: res => {
            fetchBase64Image({ content: res.data }).then((res: any) => {
                modifyMember({
                    field: 'headimg',
                    value: res.data.url
                }).then(() => {
                    memberStore.info.headimg = res.data.url
                })
            })
        }
    })
}

// 上传头像
const afterRead = (event: any) => {
    uploadImage({
        filePath: event.file.url,
        name: 'file'
    }).then((res: any) => {
        modifyMember({
            field: 'headimg',
            value: res.data.url
        }).then(() => {
            memberStore.info.headimg = res.data.url
        })
    })
}
</script>

<style lang="scss" scoped>
.personal-wrap {
    padding: 20rpx;
}

.cell-group {
    background: #fff;
    border-radius: 10rpx;
    overflow: hidden;
}

.popup-content {
    width: 620rpx;
    padding: 40rpx;
    text-align: center;

    .title {
        font-size: 32rpx;
        font-weight: bold;
        margin-bottom: 40rpx;
    }

    .input {
        width: 100%;
        height: 80rpx;
        border: 1px solid #eee;
        border-radius: 10rpx;
        padding: 0 20rpx;
        margin-bottom: 40rpx;
    }

    .primary-btn {
        width: 100%;
        height: 80rpx;
        background: var(--primary-color);
        color: #fff;
        border-radius: 100rpx;
        line-height: 80rpx;
    }
}
</style>
```

### 11.2 列表页面

```vue
<template>
    <view class="list-page" :style="themeColor()">
        <mescroll-body
            ref="mescrollRef"
            :down="downOption"
            :up="upOption"
            @init="mescrollInit"
            @down="downCallback"
            @up="upCallback"
        >
            <view class="list-item" v-for="item in list" :key="item.id">
                <view class="item-title">{{ item.title }}</view>
                <view class="item-time">{{ item.create_time }}</view>
            </view>
        </mescroll-body>
    </view>
</template>

<script setup lang="ts">
import { ref } from 'vue'
import { t } from '@/locale'
import { getPointList } from '@/api/member'

const mescrollRef = ref(null)
const list = ref<any[]>([])
const page = ref(1)
const limit = ref(10)

const downOption = {
    textInOffset: t('pullRefresh'),
    textOutOffset: t('releaseRefresh'),
    textLoading: t('refreshing')
}

const upOption = {
    textLoading: t('loading'),
    textNoMore: t('noMore'),
    empty: {
        tip: t('emptyData')
    }
}

const mescrollInit = (mescroll: any) => {
    mescrollRef.value = mescroll
}

const downCallback = (mescroll: any) => {
    page.value = 1
    loadData(mescroll)
}

const upCallback = (mescroll: any) => {
    page.value++
    loadData(mescroll)
}

const loadData = async (mescroll: any) => {
    try {
        const res = await getPointList({
            page: page.value,
            limit: limit.value
        })

        if (page.value === 1) {
            list.value = res.data.data
        } else {
            list.value = [...list.value, ...res.data.data]
        }

        mescroll.endSuccess(res.data.data.length, res.data.data.length >= limit.value)
    } catch (error) {
        mescroll.endErr()
    }
}
</script>

<style lang="scss" scoped>
.list-page {
    min-height: 100vh;
    padding: 20rpx;
}

.list-item {
    background: #fff;
    border-radius: 10rpx;
    padding: 30rpx;
    margin-bottom: 20rpx;

    .item-title {
        font-size: 28rpx;
        color: #333;
        margin-bottom: 10rpx;
    }

    .item-time {
        font-size: 24rpx;
        color: #999;
    }
}
</style>
```

### 11.3 DIY首页

```vue
<template>
    <view :style="themeColor()">
        <loading-page :loading="diy.getLoading()"></loading-page>

        <view v-show="!diy.getLoading()">
            <view class="diy-template-wrap" :style="diy.pageStyle()">
                <diy-group ref="diyGroupRef" :data="diy.data" />
            </view>
        </view>
    </view>
</template>

<script setup lang="ts">
import { ref, nextTick } from 'vue'
import { useDiy } from '@/hooks/useDiy'
import { useShare } from '@/hooks/useShare'

const { setShare } = useShare()

const diy = useDiy({
    name: 'DIY_INDEX'
})

const diyGroupRef = ref(null)

// 监听页面加载
diy.onLoad()

// 监听页面显示
diy.onShow((data: any) => {
    if (data.value) {
        let share = data.share ? JSON.parse(data.share) : null
        setShare(share)
        diyGroupRef.value?.refresh()
    }
})

// 监听页面隐藏
diy.onHide()

// 监听页面卸载
diy.onUnload()

// 监听滚动事件
diy.onPageScroll()
</script>

<style lang="scss" scoped>
@import '@/styles/diy.scss';
</style>
```

---

## 十二、开发流程总结

### 12.1 开发新页面的步骤

1. **创建页面文件** - 在 `src/pages/` 下创建 `.vue` 文件
2. **配置路由** - 在 `pages.json` 中添加页面配置
3. **创建API文件** - 在 `src/api/` 下定义接口函数
4. **创建语言文件** - 在 `src/locale/` 下添加翻译
5. **实现页面结构** - 使用标准页面模板
6. **实现功能逻辑** - 添加数据和方法
7. **添加样式** - 使用rpx单位和主题色
8. **测试功能** - 在不同平台测试

### 12.2 开发新组件的步骤

1. **创建组件目录** - 在 `src/components/` 下创建组件文件夹
2. **创建组件文件** - 创建 `index.vue` 文件
3. **定义Props和Emits** - 定义组件接口
4. **实现组件逻辑** - 添加响应式数据和方法
5. **添加组件样式** - 使用rpx单位和主题色
6. **导出组件** - 在组件中导出
7. **测试组件** - 在不同平台测试

### 12.3 关键要点

- **使用Composition API**：使用 `<script setup>` 语法
- **使用TypeScript**：添加类型定义
- **使用uview-plus**：使用UI组件库
- **使用rpx单位**：使用响应式像素单位
- **使用条件编译**：区分不同平台
- **使用国际化**：所有文字使用 `t()` 函数
- **使用响应式数据**：使用 `ref` 和 `reactive`
- **使用生命周期**：使用 `onLoad`、`onShow` 等
- **使用状态管理**：使用Pinia进行状态管理
- **遵循命名规范**：文件、变量、方法名都要符合规范
- **添加注释**：复杂逻辑添加注释说明

---

**End of Document**
