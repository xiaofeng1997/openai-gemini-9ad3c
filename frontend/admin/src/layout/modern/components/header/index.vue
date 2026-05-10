<template>
    <el-container class="h-full layout-header" :class="{ 'dark': dark }">
        <div class="flex items-center justify-between w-full h-full pl-[16px] pr-[14px]">
            <!-- 左侧区域 -->
            <div class="flex items-center h-full left-panel">
                <!-- 面包屑导航 -->
                <div class="flex items-center h-full">
                    <el-breadcrumb separator="/">
                        <el-breadcrumb-item 
                            v-for="(route, index) in breadcrumb" 
                            :to="route.path" 
                            :key="index"
                            class="breadcrumb-item"
                        >
                            {{ route.meta.title }}
                        </el-breadcrumb-item>
                    </el-breadcrumb>
                </div>
            </div>
            
            <!-- 右侧区域 -->
            <div class="flex items-center h-full right-panel">
                <!-- 搜索 -->
                <el-tooltip content="菜单搜索" placement="bottom">
                    <div class="action-item" @click="isMenuSearch = true">
                        <el-icon class="text-[16px]"><Search /></el-icon>
                    </div>
                </el-tooltip>
                
                <!-- 全屏 -->
                <el-tooltip content="全屏" placement="bottom">
                    <div class="action-item" @click="toggleFullscreen">
                        <el-icon class="text-[16px]"><FullScreen /></el-icon>
                    </div>
                </el-tooltip>
                
                <!-- 刷新 -->
                <el-tooltip content="刷新页面" placement="bottom">
                    <div class="action-item" @click="refreshRouter">
                        <el-icon class="text-[16px]"><Refresh /></el-icon>
                    </div>
                </el-tooltip>
                
                <!-- 预览 -->
                <el-tooltip content="访问前台" placement="bottom">
                    <div class="action-item" @click="toPreview">
                        <el-icon class="text-[16px]"><Promotion /></el-icon>
                    </div>
                </el-tooltip>
                
                <!-- 布局设置 -->
                <el-tooltip content="布局设置" placement="bottom">
                    <div class="action-item">
                        <layout-setting />
                    </div>
                </el-tooltip>
                
                <!-- 用户信息 -->
                <user-info />
            </div>
        </div>

        <!-- 菜单搜索对话框 -->
        <el-dialog v-model="isMenuSearch" title="菜单搜索" width="500px" :show-close="false" class="menu-search-dialog">
            <el-select 
                v-model="selectedRoute" 
                filterable 
                class="w-full menu-select" 
                placeholder="请输入菜单名称"
                :teleported="false"
                clearable
                @change="handleRouteSelect"
                ref="searchSelectRef"
            >
                <el-option 
                    v-for="item in flatRoutes" 
                    :key="item.name" 
                    :label="item.full_title" 
                    :value="item.name"
                >
                    <div class="flex items-center py-[4px]">
                        <el-icon class="mr-[8px] text-[14px] text-[#909399]"><Document /></el-icon>
                        <span class="text-[13px]">{{ item.full_title }}</span>
                    </div>
                </el-option>
            </el-select>
            <template #footer>
                <el-button @click="isMenuSearch = false">取消</el-button>
            </template>
        </el-dialog>

        <input type="hidden" v-model="comparisonToken">

        <el-dialog 
            v-model="detectionLoginDialog" 
            :title="t('layout.detectionLoginTip')" 
            width="30%" 
            :close-on-click-modal="false" 
            :close-on-press-escape="false" 
            :show-close="false"
        >
            <span>{{ t('layout.detectionLoginContent') }}</span>
            <template #footer>
                <span class="dialog-footer">
                    <el-button @click="detectionLoginFn">{{ t('layout.detectionLoginOperation') }}</el-button>
                </span>
            </template>
        </el-dialog>
    </el-container>
</template>

<script lang="ts" setup>
import { computed, ref, onMounted, nextTick, watch } from 'vue'
import layoutSetting from './layout-setting.vue'
import userInfo from './user-info.vue'
import { useFullscreen } from '@vueuse/core'
import useSystemStore from '@/stores/modules/system'
import useUserStore from '@/stores/modules/user'
import useAppStore from '@/stores/modules/app'
import { useRoute, useRouter } from 'vue-router'
import { t } from '@/lang'
import storage from '@/utils/storage'
import { Search, FullScreen, Refresh, Promotion, Document } from '@element-plus/icons-vue'

const { toggle: toggleFullscreen } = useFullscreen()
const systemStore = useSystemStore()
const appStore = useAppStore()
const route = useRoute()
const router = useRouter()

const dark = computed(() => {
    return systemStore.dark
})

const userStore = useUserStore()
const isMenuSearch = ref(false)
const searchSelectRef = ref()
const routers = userStore.routers

// 监听对话框打开，自动聚焦
watch(isMenuSearch, (val) => {
    if (val) {
        nextTick(() => {
            searchSelectRef.value?.focus()
        })
    }
})

const getParentTitleChain = (meta: any) => {
    let titles = []
    let current = meta?.parent_route

    while (current) {
        if (current.short_title) {
            titles.unshift(current.short_title)
        }
        current = current.parent_route
    }

    return titles.join(' / ')
}

const flattenRoutes = (routes: any, parent = null, parentShow = 1) => {
    let flat = [];

    routes.forEach(route => {
        const { path, name, meta = {}, short_title, children } = route;
        const currentShow = meta.show === undefined ? 1 : meta.show;
        const finalShow = currentShow && parentShow;

        const isLeaf = meta.type === 1 && finalShow === 1;

        if (isLeaf) {
            const title = meta.title || short_title || '';
            const parentTitleChain = getParentTitleChain(meta);
            const fullTitle = parentTitleChain ? `${parentTitleChain} / ${title}` : title;
            const item = {
                path,
                name,
                title,
                parent_title: parentTitleChain,
                full_title: fullTitle
            };
            flat.push(item);
        }

        if (children && children.length > 0) {
            flat = flat.concat(flattenRoutes(children, route, finalShow));
        }
    });

    return flat;
};

const flatRoutes = flattenRoutes(routers)
const selectedRoute = ref('')
const handleRouteSelect = (name: any) => {
    if (name) {
        router.push({ name })
        isMenuSearch.value = false
        selectedRoute.value = ''
    }
}

const detectionLoginDialog = ref(false)
const comparisonToken = ref('')
if (storage.get('comparisonTokenStorage')) {
    comparisonToken.value = storage.get('comparisonTokenStorage')
}
document.addEventListener('visibilitychange', e => {
    if (document.visibilityState === 'visible' && (comparisonToken.value != storage.get('token'))) {
        detectionLoginDialog.value = true
    }
})

const detectionLoginFn = () => {
    detectionLoginDialog.value = false
    location.href = `${location.origin}/`
}

const refreshRouter = () => {
    if (!appStore.routeRefreshTag) return
    appStore.refreshRouterView()
}

const breadcrumb = computed(() => {
    const matched = route.matched.filter(item => { return item.meta.title })
    if (matched[0] && matched[0].path == '/') matched.splice(0, 1)
    return matched
})

const toPreview = () => {
    let path = import.meta.env.VITE_WAP_DOMAIN || `${ location.origin }/wap/`
    window.open(path, '_blank')
}
</script>

<style lang="scss" scoped>
.layout-header {
    background-color: #ffffff;
    border-bottom: 1px solid #e4e7ed;
    box-shadow: 0 1px 4px rgba(0, 21, 41, 0.08);
    
    &.dark {
        background-color: var(--el-bg-color);
        border-bottom-color: var(--el-border-color-light);
    }
}

.left-panel {
    gap: 16px;
}

.right-panel {
    gap: 4px;
}

.action-item {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 36px;
    height: 36px;
    border-radius: var(--el-border-radius-base);
    cursor: pointer;
    transition: all 0.3s;
    color: var(--el-text-color-regular);
    
    &:hover {
        background-color: var(--el-fill-color-light);
        color: var(--el-color-primary);
    }
}

:deep(.el-breadcrumb) {
    font-size: 13px;
}

:deep(.el-breadcrumb__inner) {
    font-weight: 400 !important;
    color: var(--el-text-color-secondary) !important;
    transition: color 0.3s;
    
    &:hover {
        color: var(--el-color-primary) !important;
    }
}

:deep(.el-breadcrumb__item:last-child .el-breadcrumb__inner) {
    color: var(--el-text-color-primary) !important;
    font-weight: 500 !important;
}

:deep(.el-breadcrumb__separator) {
    color: var(--el-text-color-placeholder);
    margin: 0 8px;
}

:deep(.menu-search-dialog) {
    .el-dialog__body {
        padding: 20px;
    }
    
    .el-dialog__footer {
        padding: 10px 20px 20px;
    }
}

.menu-select {
    :deep(.el-input__wrapper) {
        box-shadow: 0 0 0 1px var(--el-border-color) inset;
    }
}
</style>
