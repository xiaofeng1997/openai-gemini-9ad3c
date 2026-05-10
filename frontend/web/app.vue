<template>
	<el-config-provider :locale="locale">
		<NuxtLayout>
			<NuxtLoadingIndicator />
			<NuxtPage />
		</NuxtLayout>
	</el-config-provider>
</template>

<script lang="ts" setup>
import { reactive, ref,computed,watch } from 'vue'
import useConfigStore from '@/stores/config'
import zhCn from 'element-plus/dist/locale/zh-cn.mjs'
import en from 'element-plus/dist/locale/en.mjs'
import useSystemStore from '@/stores/system'
import useAppStore from '@/stores/app'
import useMemberStore from '@/stores/member'
// 引入全局样式
import '@/assets/styles/index.scss'
import { useRoute, useRouter } from 'vue-router'

const router = useRouter()
// 初始化设置语言
const systemStore = useSystemStore()
const lang = typeof systemStore.lang === 'string' ? systemStore.lang : systemStore.lang.code
const locale = computed(() => (lang === 'zh-cn' ? zhCn : en))

// 初始化查询一些配置
const configStore = useConfigStore()
configStore.getLoginConfig(router)

// 如果已登录
getToken() && useMemberStore().setToken(getToken())

const route = useRoute()
watch(route, (nval, oval) => {
	useAppStore().$patch(state => {
		state.route = route.path
	})
}, { immediate: true })

useHead(() => {
    // 计算当前页面的标题
    let path = route.path == '/' ? '/index' : route.path
    if (path.slice(-1) == '/') path = path.slice(0, -1)
    path = !path.lastIndexOf('/') ? `${path}/index` : path
    let key = path.replace('/', '').replaceAll('/', '.')
    const pageTitle = t(`pages.${key}`)

    // 计算完整的标题模板
    const siteTitle = systemStore.site.front_end_name || systemStore.site.site_name
    let finalTitle = pageTitle
    if (siteTitle) {
        finalTitle = pageTitle ? `${pageTitle} - ${siteTitle}` : siteTitle
    }

    return {
        title: finalTitle
    }
})
</script>
