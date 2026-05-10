<template>
    <div class="main-container">
        <div class="overview-top p-[16px]">
            <!-- 欢迎横幅 -->
            <div class="welcome-banner mb-[20px] px-[30px] py-[15px] rounded-[6px]">
                <div class="flex items-center">
                    <div class="w-[86px] h-[86px] mr-[16px] flex-shrink-0">
                        <img src="@/assets/images/index/logo.png" alt="" class="w-full h-full object-contain" />
                    </div>
                    <div>
                        <h3 class="text-[16px] font-500 text-[#333] mb-[4px]">{{ '上午好 ' + (userStore.userInfo?.username || '用户') + '，看到您很高兴。' }}</h3>
                        <p class="text-[13px] text-[#666]">NiuCloud Lite (AI) 是一款轻量级快速开发框架，采用<span class="text-[var(--el-color-primary)]">前后端分离架构，无插件设计，易上手二次开发。</span>框架深度集成 AI 代码生成能力，可自动生成接口与页面，内置权限、支付、微信等通用能力，适合中小企业独立项目与各类管理系统系统快速搭建。</p>
                    </div>
                </div>
            </div>

            <!-- 快速开始和 AI 编程 -->
            <el-row :gutter="20" class="mb-[20px]">
                <el-col :span="24">
                    <el-card class="box-card project-data-overview-card" shadow="never">
                        <template #header>
                            <div class="section-card-header">
                                <img src="@/assets/images/index/project.png" class="section-card-header__mark" alt="" />
                                <span class="section-card-header__title">{{ t('快速开始，构建你的项目及应用') }}</span>
                            </div>
                        </template>
                        <el-row :gutter="16">
                            <el-col :span="6">
                                <div class="quick-start-item h-[92px] px-[25px] mb-[20px] rounded-[6px] cursor-pointer transition-colors bg-[#F9F5FF]" @click="toLink('https://doc.press.niucloud.com/php/niucloud-lite-ai/dev/')">
                                    <div class="flex items-center">
                                        <div class="w-[20px] h-[20px] mr-[12px] flex items-center justify-center">
                                            <img src="@/assets/images/index/index_01.png" alt="" class="w-[20px] h-[20px] object-contain" />
                                        </div>
                                        <span class="text-[14px] text-[#333]">{{ t('开发手册') }}</span>
                                    </div>
                                </div>
                            </el-col>
                            <el-col :span="6">
                                <div class="quick-start-item h-[92px] px-[25px] mb-[20px] rounded-[6px] cursor-pointer transition-colors bg-[#F9F5FF]" @click="toLink('https://doc.press.niucloud.com/php/niucloud-lite-ai/dev/ai-skills-usage.html')">
                                    <div class="flex items-center">
                                        <div class="w-[20px] h-[20px] mr-[12px] flex items-center justify-center">
                                            <img src="@/assets/images/index/index_02.png" alt="" class="w-[20px] h-[20px] object-contain" />
                                        </div>
                                        <span class="text-[14px] text-[#333]">{{ t('AI技能使用') }}</span>
                                    </div>
                                </div>
                            </el-col>
                            <el-col :span="6">
                                <div class="quick-start-item h-[92px] px-[25px] mb-[20px] rounded-[6px] cursor-pointer transition-colors bg-[#F9F5FF]" @click="toLink('https://doc.press.niucloud.com/php/niucloud-lite-ai/dev/ai-module-development.html')">
                                    <div class="flex items-center">
                                        <div class="w-[20px] h-[20px] mr-[12px] flex items-center justify-center">
                                            <img src="@/assets/images/index/index_03.png" alt="" class="w-[20px] h-[20px] object-contain" />
                                        </div>
                                        <span class="text-[14px] text-[#333]">{{ t('AI模块开发') }}</span>
                                    </div>
                                </div>
                            </el-col>
                            <el-col :span="6">
                                <div class="quick-start-item h-[92px] px-[25px] mb-[20px] rounded-[6px] cursor-pointer transition-colors bg-[#F9F5FF]" @click="toLink('https://doc.press.niucloud.com/php/niucloud-lite-ai/dev/ai-module-import.html')">
                                    <div class="flex items-center">
                                        <div class="w-[20px] h-[20px] mr-[12px] flex items-center justify-center">
                                            <img src="@/assets/images/index/index_04.png" alt="" class="w-[20px] h-[20px] object-contain" />
                                        </div>
                                        <span class="text-[14px] text-[#333]">{{ t('AI 模块导入') }}</span>
                                    </div>
                                </div>
                            </el-col>
                        </el-row>
                    </el-card>
                </el-col>
            </el-row>


            <!-- 2. 基本数据 -->
            <el-card class="box-card basic-data-overview-card mb-[20px]" shadow="never">
                <template #header>
                    <div class="section-card-header">
                        <img :src="homeImgJibenshuju" class="section-card-header__mark" alt="" />
                        <span class="section-card-header__title">{{ t('basicData') }}</span>
                        <span class="section-card-header__time">
                            <el-icon class="section-card-header__clock !text-[#666]"><Clock /></el-icon>
                            <span class="leading-[1] text-[#666]">{{ basicDataTime }}</span>
                        </span>
                    </div>
                </template>
                <el-row :gutter="16">
                    <el-col
                        v-for="(col, i) in basicStatRows"
                        :key="i"
                        :xs="24"
                        :sm="12"
                        :md="6"
                        class="basic-statistic-col py-[8px]"
                        :class="i < 3 ? 'basic-statistic-col--divide' : ''"
                    >
                        <el-statistic
                            class="basic-statistic"
                            :title="col.label"
                            :value="col.output"
                            :precision="col.precision"
                            :suffix="col.suffix"
                        />
                        <div class="basic-statistic__sub">{{ col.sub }}</div>
                    </el-col>
                </el-row>
            </el-card>

            <!-- 3. 常用功能 -->
            <el-card class="box-card !border-none mb-[20px]" shadow="never">
                <template #header>
                    <div class="section-card-header">
                        <img :src="homeImgChangyonggongneng" class="section-card-header__mark" alt="" />
                        <span class="section-card-header__title">{{ t('commonFunctions') }}</span>
                        <span class="section-card-header__time">
                            <el-icon class="section-card-header__clock !text-[#666]"><Clock /></el-icon>
                            <span class="leading-[1] text-[#666]">{{ basicDataTime }}</span>
                        </span>
                    </div>
                </template>
                <el-row :gutter="16">
                    <el-col v-for="(fn, i) in quickFunctions" :key="i" :span="3">
                        <div
                            class="quick-fn flex flex-col items-center py-[12px] rounded-[8px] cursor-pointer transition-colors hover:bg-[#f5f7fa]"
                            @click="goQuick(fn.path)"
                        >
                            <div
                                class="quick-fn__icon-box mb-[10px]"
                                :style="{ backgroundColor: fn.bg, color: fn.fg }"
                            >
                                <img
                                    v-if="fn.img"
                                    :src="fn.img"
                                    class="quick-fn__icon-img"
                                    alt=""
                                />
                                <el-icon v-else-if="fn.icon" class="quick-fn__icon-el text-[22px]">
                                    <component :is="fn.icon" />
                                </el-icon>
                            </div>
                            <span class="text-[14px] text-[#333] text-center leading-tight">{{ fn.label }}</span>
                        </div>
                    </el-col>
                </el-row>
            </el-card>

            <!-- 4. 趋势图 -->
            <el-row :gutter="20" class="mb-[20px]">
                <el-col :span="12">
                    <el-card class="box-card !border-none h-[380px]" shadow="never">
                        <template #header>
                            <div class="section-card-header">
                                <img :src="homeImgYonghuzengzhangqushi" class="section-card-header__mark" alt="" />
                                <span class="section-card-header__title">{{ t('userGrowthTrend') }}</span>
                                <span class="section-card-header__time">
                                    <el-icon class="section-card-header__clock !text-[#666]"><Clock /></el-icon>
                                    <span class="leading-[1] text-[#666]">{{ basicDataTime }}</span>
                                </span>
                            </div>
                        </template>
                        <div ref="userGrowthChartRef" class="w-full h-[280px]" />
                    </el-card>
                </el-col>
                <el-col :span="12">
                    <el-card class="box-card !border-none h-[380px]" shadow="never">
                        <template #header>
                            <div class="section-card-header">
                                <img :src="homeImgQirifangwenqushi" class="section-card-header__mark" alt="" />
                                <span class="section-card-header__title">{{ t('visitTrend7d') }}</span>
                                <span class="section-card-header__time">
                                    <el-icon class="section-card-header__clock"><Clock /></el-icon>
                                    <span>{{ basicDataTime }}</span>
                                </span>
                            </div>
                        </template>
                        <div ref="visitTrendChartRef" class="w-full h-[280px]" />
                    </el-card>
                </el-col>
            </el-row>

            <!-- 1. 系统资源 -->
            <el-row :gutter="20" class="mb-[20px]">
                <el-col v-for="(item, index) in resourceCards" :key="index" :span="6" class="!rounded-[6px] overflow-hidden">
                    <div
                        class="resource-metric-card"
                        :class="
                            item.variant === 'primary'
                                ? 'resource-metric-card--primary'
                                : 'resource-metric-card--plain'
                        "
                    >
                        <div class="resource-metric-card__text">
                            <div
                                class="resource-metric-card__title"
                                :class="
                                    item.variant === 'primary'
                                        ? 'resource-load__label'
                                        : 'text-[#333]'
                                "
                            >
                                {{ item.label }}
                            </div>
                            <div
                                class="resource-metric-card__value"
                                :class="
                                    item.variant === 'primary'
                                        ? 'resource-load__value'
                                        : 'text-[#111]'
                                "
                            >
                                {{ item.percentText }}
                            </div>
                            <div
                                v-if="item.variant === 'primary'"
                                class="resource-metric-card__sub resource-metric-card__sub--trend"
                            >
                                <span class="resource-load__trend-label">{{ t('sinceLastWeek') }}</span>
                                <img
                                    :src="homeImgTrendArrow"
                                    class="resource-load__trend-icon"
                                    alt=""
                                    width="14"
                                    height="14"
                                />
                                <span class="resource-load__trend-pct">32%</span>
                            </div>
                            <div v-else class="resource-metric-card__sub text-[#666]">
                                {{ item.sub }}
                            </div>
                        </div>
                        <div class="resource-metric-card__chart">
                            <template v-if="item.chart === 'circle'">
                                <el-progress
                                    type="circle"
                                    :percentage="animatedRingPercent(item.percent)"
                                    :width="item.ringWidth ?? 88"
                                    :stroke-width="item.strokeWidth ?? 5"
                                    :color="item.progressColor"
                                    :class="['resource-ring', item.progressClass]"
                                />
                            </template>
                            <div
                                v-else-if="item.chart === 'liquid'"
                                class="resource-liquid-wrap"
                            >
                                <canvas
                                    :ref="(el) => setLiquidRef(el, item)"
                                    class="resource-liquid-canvas"
                                />
                            </div>
                            <div
                                v-else-if="item.chart === 'spark'"
                                :ref="(el) => setMemorySparkRef(el)"
                                class="resource-spark"
                            />
                        </div>
                    </div>
                </el-col>
            </el-row>

            <!-- 5. 服务器信息 -->
            <el-card class="box-card !border-none mb-[20px]" shadow="never">
                <template #header>
                    <div class="section-card-header">
                        <img :src="homeImgFuwuqixinxi" class="section-card-header__mark" alt="" />
                        <span class="section-card-header__title">{{ t('serverInfo') }}</span>
                        <span class="section-card-header__time">
                            <el-icon class="section-card-header__clock !text-[#666]"><Clock /></el-icon>
                            <span class="leading-[1] text-[#666]">{{ basicDataTime }}</span>
                        </span>
                    </div>
                </template>
                <el-table :data="serverTable" border stripe class="w-full">
                    <el-table-column prop="name" :label="t('envCol')" min-width="160" />
                    <el-table-column prop="server" :label="t('versionCol')" min-width="200" />
                </el-table>
            </el-card>

            <!-- 6. 系统环境要求 -->
            <el-card class="box-card !border-none" shadow="never">
                <template #header>
                    <div class="section-card-header">
                        <img :src="homeImgXitonghuanjingyaoqiu" class="section-card-header__mark" alt="" />
                        <span class="section-card-header__title">{{ t('systemEnvRequirement') }}</span>
                        <span class="section-card-header__time">
                            <el-icon class="section-card-header__clock !text-[#666]"><Clock /></el-icon>
                            <span class="leading-[1] text-[#666]">{{ basicDataTime }}</span>
                        </span>
                    </div>
                </template>
                <el-table :data="envRequirementTable" border stripe class="w-full">
                    <el-table-column prop="name" :label="t('envCol')" min-width="140" />
                    <el-table-column prop="demand" :label="t('requirementCol')" min-width="160" />
                    <el-table-column prop="server" :label="t('versionCol')" min-width="160" />
                </el-table>
            </el-card>
        </div>
    </div>
</template>

<script lang="ts" setup>
import {
    ref,
    watch,
    onMounted,
    onUnmounted,
    computed,
    nextTick,
    type Component,
    type ComponentPublicInstance
} from 'vue'
import { useTransition } from '@vueuse/core'
import { useRouter } from 'vue-router'
import { t } from '@/lang'
import * as echarts from 'echarts'
import { getSystem } from '@/api/tools'
import homeImgTrendArrow from '@/assets/images/HomeImg/上.png'
import homeImgGuanliyuan from '@/assets/images/HomeImg/guanliyuan.png'
import homeImgJueseguanli from '@/assets/images/HomeImg/jueseguanli.png'
import homeImgZidianguanli from '@/assets/images/HomeImg/zidianguanli.png'
import homeImgDaimashengcheng from '@/assets/images/HomeImg/daimashengcheng.png'
import homeImgSuucaizhongxin from '@/assets/images/HomeImg/suucaizhongxin.png'
import homeImgCaidanquanxian from '@/assets/images/HomeImg/caidanquanxian.png'
import homeImgWangzhanxinxi from '@/assets/images/HomeImg/wangzhanxinxi.png'
import homeImgJibenshuju from '@/assets/images/HomeImg/jibenshuju.png'
import homeImgChangyonggongneng from '@/assets/images/HomeImg/changyonggongneng.png'
import homeImgYonghuzengzhangqushi from '@/assets/images/HomeImg/yonghuzengzhangqushi.png'
import homeImgQirifangwenqushi from '@/assets/images/HomeImg/qirifangwenqushi.png'
import homeImgFuwuqixinxi from '@/assets/images/HomeImg/fuwuqixinxi.png'
import homeImgXitonghuanjingyaoqiu from '@/assets/images/HomeImg/xitonghuanjingyaoqiu.png'
import { Clock, OfficeBuilding, MagicStick, Document, Download, Cloudy } from '@element-plus/icons-vue'
import useUserStore from '@/stores/modules/user'

const router = useRouter()
const userStore = useUserStore()

/** 折线 / 圆环 / 水球 / 基本数据 数字共用动效时长（短于 0.5s，刷新后立刻有动效、又不拖沓） */
const DASH_ANIM_DURATION = 400

const userGrowthChartRef = ref<HTMLElement>()
const visitTrendChartRef = ref<HTMLElement>()

let userGrowthChart: echarts.ECharts | null = null
let visitTrendChart: echarts.ECharts | null = null
let memorySparkChart: echarts.ECharts | null = null
let liquidBall: { stop: () => void; resize: () => void } | null = null

function resolveDom (el: Element | ComponentPublicInstance | null): HTMLElement | null {
    if (!el) return null
    if (el instanceof HTMLElement) return el
    const root = (el as ComponentPublicInstance).$el
    return root instanceof HTMLElement ? root : null
}

const resourceCards = ref([
    {
        label: t('load'),
        percent: 84.6,
        percentText: '84.6%',
        sub: '',
        chart: 'circle' as const,
        variant: 'primary' as const,
        progressColor: '#ffffff',
        progressClass: 'resource-ring--load',
        ringWidth: 100,
        strokeWidth: 5
    },
    {
        label: t('cpuUsage'),
        percent: 34.6,
        percentText: '34.6%',
        sub: t('cpuCores'),
        chart: 'liquid' as const,
        variant: 'plain' as const,
        progressColor: '#1677ff',
        progressClass: ''
    },
    {
        label: t('memoryUsage'),
        percent: 84.6,
        percentText: '84.6%',
        sub: '3526 / 7585(MB)',
        chart: 'spark' as const,
        variant: 'plain' as const,
        progressColor: '',
        progressClass: ''
    },
    {
        label: t('diskUsage'),
        percent: 84.6,
        percentText: '84.6%',
        sub: '12.65G / 100G',
        chart: 'circle' as const,
        variant: 'plain' as const,
        progressColor: '#f56c6c',
        progressClass: 'resource-ring--disk',
        ringWidth: 100,
        strokeWidth: 10
    }
])

/** 内存使用率右侧迷你折线（演示数据，可对接监控） */
const memorySparkValues = [38, 45, 40, 52, 48, 55, 62]

/** 基本数据：展示文案 + 动画目标值（可后续改为接口数据） */
const basicStatColumns = [
    { label: t('newUsers'), sub: `${t('totalUsers')} 123,25`, target: 36, precision: 0, suffix: '' },
    { label: t('todayVisits'), sub: `${t('totalVisits')} 256,25`, target: 329, precision: 0, suffix: '' },
    { label: t('todayAiCalls'), sub: `${t('totalAiCalls')} 874,25`, target: 365, precision: 0, suffix: '' },
    { label: t('apiSuccess7d'), sub: `${t('totalApiSuccess')} 98.4%`, target: 99.8, precision: 1, suffix: '%' }
]

const basicStatAnimations = Array.from({ length: basicStatColumns.length }, () => {
    const source = ref(0)
    const output = useTransition(source, { duration: DASH_ANIM_DURATION })
    return { source, output }
})

/** 供模板绑定，避免 `arr[i]!.x` 触发 vue 解析问题 */
const basicStatRows = basicStatColumns.map((col, i) => ({
    ...col,
    output: basicStatAnimations[i]!.output
}))

function startBasicStatAnimation () {
    basicStatColumns.forEach((col, i) => {
        basicStatAnimations[i]!.source.value = col.target
    })
}

const basicDataTime = computed(() => {
    const d = new Date()
    const pad = (n: number) => n.toString().padStart(2, '0')
    return `${d.getFullYear()}-${pad(d.getMonth() + 1)}-${pad(d.getDate())} ${pad(d.getHours())}:${pad(d.getMinutes())}`
})

type QuickFnItem = {
    label: string
    path: string
    bg: string
    fg: string
    img?: string
    icon?: Component
}

/** HomeImg 拼音资源图；部门管理暂无 buminguanli.png 时用 OfficeBuilding */
const quickFunctions: QuickFnItem[] = [
    { label: t('qfAdmin'), path: '/auth/user', img: homeImgGuanliyuan, bg: '#e6f4ff', fg: '#1677ff' },
    { label: t('qfRole'), path: '/auth/user', img: homeImgJueseguanli, bg: '#fff1f0', fg: '#f5222d' },
    { label: t('qfDept'), path: '/sys/dept', icon: OfficeBuilding, bg: '#f6ffed', fg: '#52c41a' },
    { label: t('qfDict'), path: '/dict/list', img: homeImgZidianguanli, bg: '#fff7e6', fg: '#fa8c16' },
    { label: t('qfGenerator'), path: '/tools/code/index', img: homeImgDaimashengcheng, bg: '#f9f0ff', fg: '#722ed1' },
    { label: t('qfAttachment'), path: '/tools/attachment', img: homeImgSuucaizhongxin, bg: '#e6fffb', fg: '#13c2c2' },
    { label: t('qfMenu'), path: '/auth/menu', img: homeImgCaidanquanxian, bg: '#fff0f6', fg: '#eb2f96' },
    { label: t('qfSite'), path: '/setting/system', img: homeImgWangzhanxinxi, bg: '#f0f5ff', fg: '#2f54eb' }
]

const serverTable = ref<{ name: string; server: string }[]>([])
const envRequirementTable = ref<{ name: string; demand: string; server: string }[]>([])

const chartDates = ['10/05', '10/06', '10/07', '10/08', '10/09', '10/10', t('today')]
const userGrowthSeries = [120, 132, 101, 134, 90, 230, 210]
const visitTrendSeries = [220, 182, 191, 234, 290, 330, 310]

/** 与 el-statistic 一致：0→1 再映射到各序列，驱动 ECharts 数据动效 */
const chartRevealSource = ref(0)
const chartRevealProgress = useTransition(chartRevealSource, { duration: DASH_ANIM_DURATION })

function animatedRingPercent (target: number) {
    const t = chartRevealProgress.value
    return Math.min(100, Math.round(target * t * 10) / 10)
}

function lerpSeriesData (series: number[], t: number) {
    return series.map((v) => Math.round(v * t))
}

function buildMemorySparkSeriesOption (data: number[], n: number) {
    return [
        {
            type: 'line' as const,
            data,
            smooth: true,
            showSymbol: true,
            symbol: (_v: number, p: { dataIndex: number }) =>
                p.dataIndex === n - 1 ? 'emptyCircle' : 'none',
            symbolSize: (_v: number, p: { dataIndex: number }) =>
                p.dataIndex === n - 1 ? 7 : 0,
            lineStyle: {
                color: '#52c41a',
                width: 2.5,
                cap: 'round' as const,
                join: 'round' as const
            },
            itemStyle: {
                color: '#52c41a',
                borderColor: '#52c41a',
                borderWidth: 2
            }
        }
    ]
}

function toLink(link: string) {
    window.open(link, '_blank')
}

function updateEchartsFromRevealProgress () {
    const t = chartRevealProgress.value
    const growth = lerpSeriesData(userGrowthSeries, t)
    const visit = lerpSeriesData(visitTrendSeries, t)
    const mem = lerpSeriesData(memorySparkValues, t)
    const n = mem.length

    if (userGrowthChart) {
        userGrowthChart.setOption(
            { animation: false, series: [{ data: growth }] },
            { lazyUpdate: true }
        )
    }
    if (visitTrendChart) {
        visitTrendChart.setOption(
            { animation: false, series: [{ data: visit }] },
            { lazyUpdate: true }
        )
    }
    if (memorySparkChart) {
        memorySparkChart.setOption(
            {
                animation: false,
                series: buildMemorySparkSeriesOption(mem, n)
            },
            { lazyUpdate: true }
        )
    }
}

watch(chartRevealProgress, () => {
    updateEchartsFromRevealProgress()
})

const goQuick = (path: string) => {
    router.push(path).catch(() => {})
}

const setLiquidRef = (
    el: Element | ComponentPublicInstance | null,
    item: { percent: number; percentText: string }
) => {
    const node = resolveDom(el)
    if (!node || !(node instanceof HTMLCanvasElement)) {
        liquidBall?.stop()
        liquidBall = null
        return
    }
    liquidBall?.stop()

    const canvas = node
    const ctx = canvas.getContext('2d')
    if (!ctx) return

    /* 内切圆 = 105 - 2*padding，与 .resource-liquid-wrap / canvas 一致 */
    const cssSize = 101
    const targetFill = Math.min(1, Math.max(0, item.percent / 100))
    const label = item.percentText
    let phase = 0
    let raf = 0

    const layout = () => {
        const dpr = Math.min(window.devicePixelRatio || 1, 2)
        canvas.width = cssSize * dpr
        canvas.height = cssSize * dpr
        canvas.style.width = `${cssSize}px`
        canvas.style.height = `${cssSize}px`
        ctx.setTransform(dpr, 0, 0, dpr, 0, 0)
    }

    const frame = () => {
        const w = cssSize
        const cx = w / 2
        const cy = w / 2
        const r = w / 2 - 1.5
        const bottom = cy + r
        const fillRatio = Math.min(1, Math.max(0, targetFill * chartRevealProgress.value))
        const staticLevel = bottom - 2 * r * fillRatio

        /* 参考图2：同主频、反相；浅色整体上移、深色整体下移，拉开层次 */
        const freq = 0.069
        const waveBackLift = 2.4
        const waveFrontDrop = 2.4
        const waveBackY = (x: number) => {
            const amp = 2.48
            const ph = phase + Math.PI * 0.92
            const y =
                staticLevel -
                waveBackLift +
                amp * Math.sin(x * freq + ph) +
                amp * 0.42 * Math.sin(x * freq * 1.92 + ph * 1.08)
            return Math.min(Math.max(y, cy - r), bottom)
        }
        const waveFrontY = (x: number) => {
            const amp = 2.58
            const ph = phase
            const y =
                staticLevel +
                waveFrontDrop +
                amp * Math.sin(x * freq + ph) +
                amp * 0.38 * Math.sin(x * freq * 1.95 + ph * 1.15)
            return Math.min(Math.max(y, cy - r), bottom)
        }

        const waveMinFor = (getY: (x: number) => number) => {
            let m = bottom
            for (let x = 0; x <= w; x += 1) {
                m = Math.min(m, getY(x))
            }
            return m
        }

        const fillWaveLayer = (getY: (x: number) => number, grad: CanvasGradient) => {
            ctx.beginPath()
            ctx.moveTo(0, bottom)
            for (let x = 0; x <= w; x += 1) {
                ctx.lineTo(x, getY(x))
            }
            ctx.lineTo(w, bottom)
            ctx.closePath()
            ctx.fillStyle = grad
            ctx.fill()
        }

        ctx.clearRect(0, 0, w, w)
        ctx.save()
        ctx.beginPath()
        ctx.arc(cx, cy, r, 0, Math.PI * 2)
        ctx.clip()
        ctx.fillStyle = '#ffffff'
        ctx.fillRect(0, 0, w, w)

        /* 后波：浅于前层，但加不透明度与振幅，保证在白底上也能看出浪形 */
        const backMin = waveMinFor(waveBackY)
        const gBackTop = Math.max(cy - r + 0.5, backMin - 12)
        const gBack = ctx.createLinearGradient(0, gBackTop, 0, bottom)
        gBack.addColorStop(0, 'rgba(185, 220, 255, 0.98)')
        gBack.addColorStop(0.38, 'rgba(155, 205, 255, 0.96)')
        gBack.addColorStop(0.78, 'rgba(135, 195, 255, 0.94)')
        gBack.addColorStop(1, 'rgba(120, 188, 255, 0.92)')
        fillWaveLayer(waveBackY, gBack)

        /* 前波：深色主浪，略透明 + 略强副波，与浅色浪形都可见 */
        const frontMin = waveMinFor(waveFrontY)
        const gFrontTop = Math.max(cy - r + 0.5, frontMin - 10)
        const gFront = ctx.createLinearGradient(0, gFrontTop, 0, bottom)
        gFront.addColorStop(0, 'rgba(118, 188, 255, 0.95)')
        gFront.addColorStop(0.4, 'rgba(102, 177, 255, 0.98)')
        gFront.addColorStop(1, '#66B1FF')
        ctx.globalAlpha = 0.84
        fillWaveLayer(waveFrontY, gFront)
        ctx.globalAlpha = 1

        ctx.restore()

        /* 蓝色外轮廓；灰色外环在 CSS 里弱化 */
        ctx.beginPath()
        ctx.arc(cx, cy, r, 0, Math.PI * 2)
        ctx.strokeStyle = '#8AC4FF'
        ctx.lineWidth = 2.5
        ctx.lineCap = 'round'
        ctx.shadowColor = 'rgba(138, 196, 255, 0.5)'
        ctx.shadowBlur = 5
        ctx.stroke()
        ctx.shadowBlur = 0
        ctx.shadowColor = 'transparent'

        ctx.font = '600 14px system-ui, -apple-system, "DIN Alternate", sans-serif'
        ctx.textAlign = 'center'
        ctx.textBaseline = 'middle'
        ctx.fillStyle = '#1a1a1a'
        ctx.fillText(label, cx, cy)

        phase += 0.042
        raf = requestAnimationFrame(frame)
    }

    layout()
    raf = requestAnimationFrame(frame)

    liquidBall = {
        stop: () => {
            cancelAnimationFrame(raf)
        },
        resize: () => {
            layout()
        }
    }
}

const setMemorySparkRef = (el: Element | ComponentPublicInstance | null) => {
    const node = resolveDom(el)
    if (!node) {
        memorySparkChart?.dispose()
        memorySparkChart = null
        return
    }
    memorySparkChart?.dispose()
    memorySparkChart = null

    const n = memorySparkValues.length
    const xData = memorySparkValues.map((_, i) => String(i))

    let layoutTries = 0
    const renderSpark = () => {
        if (!node.isConnected) return
        const w = node.offsetWidth
        const h = node.offsetHeight
        if ((w < 8 || h < 8) && layoutTries++ < 40) {
            requestAnimationFrame(renderSpark)
            return
        }
        if (w < 8 || h < 8) return
        const sparkData = lerpSeriesData(memorySparkValues, chartRevealProgress.value)
        memorySparkChart = echarts.init(node, undefined, { renderer: 'canvas' })
        memorySparkChart.setOption({
            animation: false,
            backgroundColor: 'transparent',
            tooltip: { show: false },
            grid: {
                left: 2,
                right: 8,
                top: 4,
                bottom: 4,
                containLabel: false
            },
            xAxis: {
                type: 'category',
                boundaryGap: false,
                show: false,
                data: xData
            },
            yAxis: {
                type: 'value',
                show: false,
                scale: true,
                splitLine: { show: false }
            },
            series: buildMemorySparkSeriesOption(sparkData, n)
        })
        memorySparkChart.resize()
    }

    nextTick(() => {
        requestAnimationFrame(renderSpark)
    })
}

const loadSystemInfo = async () => {
    try {
        const res: any = await getSystem()
        const data = res.data
        if (data?.server?.length) {
            serverTable.value = data.server.map((row: { name: string; server: string }) => ({
                name: row.name,
                server: row.server
            }))
        }
        if (data?.server_version?.length) {
            envRequirementTable.value = data.server_version.map(
                (row: { name: string; demand: string; server: string }) => ({
                    name: row.name,
                    demand: row.demand,
                    server: row.server
                })
            )
        }
    } catch {
        serverTable.value = [
            { name: t('serverOs'), server: 'Linux' },
            { name: t('serverWeb'), server: 'fpm-fcgi' },
            { name: t('phpVersion'), server: '8.0.26' }
        ]
        envRequirementTable.value = [
            { name: t('phpVersion'), demand: t('phpRequirement'), server: '8.0.26' },
            { name: t('mysqlVersion'), demand: t('mysqlRequirement'), server: '8.0.36' }
        ]
    }
}

const initCharts = () => {
    const t0 = chartRevealProgress.value
    if (userGrowthChartRef.value) {
        userGrowthChart = echarts.init(userGrowthChartRef.value)
        userGrowthChart.setOption({
            animation: false,
            tooltip: { trigger: 'axis' },
            grid: { left: '3%', right: '4%', bottom: '3%', containLabel: true },
            xAxis: { type: 'category', boundaryGap: false, data: chartDates },
            yAxis: { type: 'value' },
            series: [
                {
                    data: lerpSeriesData(userGrowthSeries, t0),
                    type: 'line',
                    smooth: true,
                    symbol: 'circle',
                    symbolSize: 8,
                    lineStyle: { color: '#1677ff', width: 2 },
                    itemStyle: { color: '#1677ff', borderColor: '#fff', borderWidth: 2 }
                }
            ]
        })
    }

    if (visitTrendChartRef.value) {
        visitTrendChart = echarts.init(visitTrendChartRef.value)
        visitTrendChart.setOption({
            animation: false,
            tooltip: { trigger: 'axis' },
            grid: { left: '3%', right: '4%', bottom: '3%', containLabel: true },
            xAxis: { type: 'category', boundaryGap: false, data: chartDates },
            yAxis: { type: 'value' },
            series: [
                {
                    data: lerpSeriesData(visitTrendSeries, t0),
                    type: 'line',
                    smooth: true,
                    symbol: 'circle',
                    symbolSize: 6,
                    areaStyle: {
                        color: new echarts.graphic.LinearGradient(0, 0, 0, 1, [
                            { offset: 0, color: 'rgba(22, 119, 255, 0.45)' },
                            { offset: 1, color: 'rgba(22, 119, 255, 0.05)' }
                        ])
                    },
                    lineStyle: { color: '#1677ff', width: 2 },
                    itemStyle: { color: '#1677ff' }
                }
            ]
        })
    }
}

const handleResize = () => {
    userGrowthChart?.resize()
    visitTrendChart?.resize()
    memorySparkChart?.resize()
    liquidBall?.resize()
}

onMounted(() => {
    loadSystemInfo().catch(() => {})
    initCharts()
    chartRevealSource.value = 1
    startBasicStatAnimation()
    window.addEventListener('resize', handleResize)
})

onUnmounted(() => {
    window.removeEventListener('resize', handleResize)
    userGrowthChart?.dispose()
    visitTrendChart?.dispose()
    memorySparkChart?.dispose()
    liquidBall?.stop()
})
</script>

<style lang="scss" scoped>
.main-container {
    background: #f6f6f6;
    min-height: calc(100vh - 64px);
}
.welcome-banner {
    background: #F8F8FF;
    border: 1px solid #DCDFE6;
}

.quick-start-item {
    display: flex;
    align-items: center;
}

.video-container {
    position: relative;
    
    .play-button {
        transition: all 0.3s ease;
        
        &:hover {
            transform: scale(1.1);
        }
    }
}


.section-card-header {
    display: flex;
    align-items: center;
    flex-wrap: wrap;
    column-gap: 10px;
    row-gap: 4px;
    height: 25px;
}

.section-card-header__mark {
    width: 16px;
    height: 16px;
    object-fit: contain;
    flex-shrink: 0;
}

.section-card-header__title {
    font-size: 18px;
    font-weight: 500;
    color: #333;
    line-height: 1;
}

.section-card-header__time {
    display: inline-flex;
    align-items: center;
    gap: 4px;
    font-size: 14px;
    color: #666;
}

.section-card-header__clock {
    font-size: 14px;
    color: #b3b3b3;
}

.basic-data-overview-card {
    border: 1px solid #DCDFE6 !important;
    border-radius: 6px !important;
}

.basic-statistic-col {
}

.basic-statistic-col--divide {
    border-right: 1px solid #f0f0f0;
}

.basic-statistic {
    :deep(.el-statistic__head) {
        color: #333;
        font-size: 14px;
        font-weight: 400;
        margin-bottom: 13px;
    }

    :deep(.el-statistic__content) {
        color: #111;
        font-size: 25px;
        font-weight: 500;
        line-height: 1.2;
        margin-bottom: 20px;
    }

    :deep(.el-statistic__number) {
        font-variant-numeric: tabular-nums;
    }
}

.basic-statistic__sub {
    font-size: 14px;
    color: #666;
    line-height: 1.4;
}

@media (max-width: 992px) {
    .basic-statistic-col--divide {
        border-right: none;
    }
}

.quick-fn__icon-box {
    width: 48px;
    height: 48px;
    border-radius: 8px;
    border: 1px dashed rgba(0, 0, 0, 0.12);
    display: flex;
    align-items: center;
    justify-content: center;
    box-sizing: border-box;
}

.quick-fn__icon-img {
    width: 26px;
    height: 26px;
    object-fit: contain;
}

.quick-fn__icon-el {
    display: flex;
}

.resource-metric-card__text {
    flex: 1;
    min-width: 0;
}

.resource-metric-card {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 16px;
    min-height: 148px;
    padding: 20px 20px 20px 22px;
    border-radius: 8px;
    box-sizing: border-box;
    transition: box-shadow 0.2s ease;

    /* 负载卡：设计稿尺寸与横向渐变 */
    &--primary {
        width: 407px;
        max-width: 100%;
        height: 148px;
        min-height: 148px;
        padding: 16px 18px 16px 20px;
        background: linear-gradient(90deg, #90b4f6 0%, #4f88f3 100%);
        box-shadow: 0 2px 10px rgba(79, 136, 243, 0.28);
    }

    &--plain {
        background: #fff;
        border: 1px solid #eef0f3;
        box-shadow: 0 1px 2px rgba(0, 0, 0, 0.04);
    }

    &:hover {
        box-shadow: 0 4px 14px rgba(0, 0, 0, 0.08);
    }
}

.resource-metric-card__title {
    font-size: 14px;
    margin-bottom: 14px;
    line-height: 1.3;
}

.resource-metric-card__value {
    font-size: 24px;
    font-weight: 500;
    line-height: 1.15;
    margin-bottom: 20px;
    letter-spacing: -0.02em;
}

.resource-metric-card__sub {
    font-size: 14px;
    line-height: 1.4;
}

.resource-metric-card__sub--trend {
    display: flex;
    align-items: center;
    flex-wrap: wrap;
    gap: 2px;
}

/* 负载主卡文案（覆盖通用 title/value 的 margin / 字号） */
.resource-metric-card--plain{
    border-color: #DCDFE6 !important;
}
.resource-metric-card--primary {
    background: linear-gradient(90deg, var(--el-color-primary-light-3) 0%, var(--el-color-primary-light-5) 100%);
    .resource-metric-card__title.resource-load__label {
        color: #ffffff;
        font-size: 14px;
        font-style: normal;
        font-weight: 400;
        line-height: normal;
        /* 负载 与 84.6% 间距 */
        margin-bottom: 14px;
    }

    .resource-metric-card__value.resource-load__value {
        color: #ffffff;
        font-size: 24px;
        font-style: normal;
        font-weight: 500;
        line-height: normal;
        /* 84.6% 与 自上周以来 间距 */
        margin-bottom: 20px;
    }

    .resource-load__trend-label {
        color: #ffffff;
        font-size: 14px;
        font-style: normal;
        font-weight: 400;
        line-height: normal;
    }

    .resource-load__trend-pct {
        color: #ffffff;
        font-size: 14px;
        font-style: normal;
        font-weight: 500;
        line-height: normal;
    }

    .resource-load__trend-icon {
        display: block;
        width: 14px;
        height: 14px;
        object-fit: contain;
        flex-shrink: 0;
        margin: 0 2px;
    }
}

.resource-metric-card__chart {
    flex-shrink: 0;
    display: flex;
    align-items: center;
    justify-content: center;
}

.resource-liquid-wrap {
    width: 105px;
    height: 105px;
    aspect-ratio: 1 / 1;
    border-radius: 105px;
    /* 外环灰尽量弱，仅作轻微衬底 */
    background: #ededed;
    padding: 2px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    box-sizing: border-box;
}

.resource-liquid-canvas {
    display: block;
    width: 101px;
    height: 101px;
}

/* 固定尺寸，避免 flex 内 ECharts 初始化为 0 宽高导致空白 */
.resource-spark {
    width: 120px;
    height: 76px;
    min-width: 120px;
    min-height: 76px;
    flex-shrink: 0;
    box-sizing: border-box;
}
.box-card{
    border: 1px solid #DCDFE6 !important;
    border-radius: 6px !important;
    .el-card__header{
        border-color: #DCDFE6 !important;
    }
}

:deep(.resource-ring--load .el-progress__text) {
    color: #ffffff !important;
    font-family: 'DINPro', 'DIN Alternate', 'DIN Condensed', 'Helvetica Neue', Arial, sans-serif !important;
    font-size: 24px !important;
    font-style: normal !important;
    font-weight: 500 !important;
    line-height: normal !important;
}

:deep(.resource-ring--load .el-progress-circle__track) {
    stroke: rgba(255, 255, 255, 0.28) !important;
}

:deep(.resource-ring--disk .el-progress__text) {
    color: #1a1a1a !important;
    font-size: 14px !important;
    font-weight: 600 !important;
}

:deep(.resource-ring--disk .el-progress-circle__track) {
    stroke: #ffe4e4 !important;
}

@media (max-width: 1200px) {
    .basic-stat {
        border-right: none !important;
        margin-bottom: 12px;
    }
}
:deep(.project-data-overview-card .el-card__body){
    padding-bottom: 0 !important;
}
</style>
