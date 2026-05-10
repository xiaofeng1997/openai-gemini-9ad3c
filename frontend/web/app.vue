<template>
	<el-config-provider :locale="locale">
		<NuxtLayout>
			<NuxtLoadingIndicator />
			<NuxtPage />
		</NuxtLayout>
	</el-config-provider>
</template>

<script lang="ts" setup>
import { reactive, ref, computed, watch } from 'vue'
import useConfigStore from '@/stores/config'
import zhCn from 'element-plus/dist/locale/zh-cn.mjs'
import en from 'element-plus/dist/locale/en.mjs'
import useSystemStore from '@/stores/system'
import useAppStore from '@/stores/app'
import useMemberStore from '@/stores/member'
import '@/assets/styles/index.scss'

const systemStore = useSystemStore()
const lang = computed(() => {
    const langVal = systemStore.lang
    return typeof langVal === 'string' ? langVal : langVal?.code || 'zh-cn'
})
const locale = computed(() => (lang.value === 'zh-cn' ? zhCn : en))

const configStore = useConfigStore()
const appStore = useAppStore()
const memberStore = useMemberStore()

let initialized = false
const init = () => {
    if (initialized) return
    initialized = true

    configStore.getLoginConfig()

    if (getToken()) {
        memberStore.setToken(getToken())
    }
}

const route = useRoute()
watch(route, (nval) => {
    appStore.$patch(state => {
        state.route = route.path
    })
}, { immediate: true })

useHead(() => {
    let path = route.path === '/' ? '/index' : route.path
    if (path.slice(-1) === '/') path = path.slice(0, -1)
    path = !path.lastIndexOf('/') ? `${path}/index` : path
    const key = path.replace('/', '').replaceAll('/', '.')
    const pageTitle = t(`pages.${key}`)

    const siteTitle = systemStore.site?.front_end_name || systemStore.site?.site_name
    let finalTitle = pageTitle
    if (siteTitle) {
        finalTitle = pageTitle ? `${pageTitle} - ${siteTitle}` : siteTitle
    }

    return {
        title: finalTitle
    }
})

onMounted(() => {
    init()
})
</script>
