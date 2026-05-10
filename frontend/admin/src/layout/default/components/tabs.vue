<template>
    <div class="tab-wrap w-full px-[16px]">
        <!-- 左侧滚动按钮 -->
        <div class="nav-btn" @click="scrollLeft">
            <el-icon><ArrowLeft /></el-icon>
        </div>

        <!-- Tab标签区域 -->
        <el-tabs :closable="tabbarStore.tabLength > 1" :model-value="route.path" @tab-click="tabClick" @tab-remove="removeTab" class="flex-1">
            <el-tab-pane v-for="(tab, key, index) in tabbarStore.tabs" :name="tab.path" :key="index">
                <template #label>
                    <el-dropdown trigger="contextmenu" placement="bottom-start">
                        <span :class="{ 'text-primary': route.path == tab.path }" class="tab-name">{{ tab.title }}</span>
                        <template #dropdown>
                            <el-dropdown-menu>
                                <el-dropdown-item icon="Back" :disabled="index == 0" @click="closeLeft(tab.path)">{{t('tabs.closeLeft') }}</el-dropdown-item>
                                <el-dropdown-item icon="Right" :disabled="index == (tabbarStore.tabLength - 1)" @click="closeRight(tab.path)">{{t('tabs.closeRight') }}</el-dropdown-item>
                                <el-dropdown-item icon="Close" :disabled="tabbarStore.tabLength == 1" @click="closeOther(tab.path)">{{t('tabs.closeOther') }}</el-dropdown-item>
                            </el-dropdown-menu>
                        </template>
                    </el-dropdown>
                </template>
            </el-tab-pane>
        </el-tabs>

        <!-- 右侧滚动按钮 -->
        <div class="nav-btn" @click="scrollRight">
            <el-icon><ArrowRight /></el-icon>
        </div>

        <!-- 刷新按钮 -->
        <div class="nav-btn refresh-btn" @click="refreshCurrentTab">
            <el-icon><Refresh /></el-icon>
        </div>

        <!-- 操作下拉菜单 -->
        <el-dropdown class="nav-btn" trigger="click" @command="handleCommand">
            <el-icon><ArrowDown /></el-icon>
            <template #dropdown>
                <el-dropdown-menu>
                    <el-dropdown-item command="closeCurrent">
                        <el-icon class="mr-[6px]"><Close /></el-icon>
                        关闭当前
                    </el-dropdown-item>
                    <el-dropdown-item command="closeOther">
                        <el-icon class="mr-[6px]"><CircleClose /></el-icon>
                        关闭其他
                    </el-dropdown-item>
                    <el-dropdown-item command="closeAll">
                        <el-icon class="mr-[6px]"><Minus /></el-icon>
                        关闭全部
                    </el-dropdown-item>
                </el-dropdown-menu>
            </template>
        </el-dropdown>
    </div>
</template>

<script lang="ts" setup>
import { watch, onMounted } from 'vue'
import useTabbarStore from '@/stores/modules/tabbar'
import useAppStore from '@/stores/modules/app'
import { useRoute, useRouter } from 'vue-router'
import { t } from '@/lang'
import {
    ArrowLeft,
    ArrowRight,
    ArrowDown,
    Close,
    Minus,
    CircleClose,
    Refresh
} from '@element-plus/icons-vue'

const tabbarStore = useTabbarStore()
const appStore = useAppStore()
const route = useRoute()
const router = useRouter()

onMounted(() => {
    tabbarStore.addTab(route)
})

watch(route, (nval: any) => {
    tabbarStore.addTab(nval)
})

const tabClick = (content: any) => {
    const tabRoute = tabbarStore.tabs[content.props.name]
    router.push({ path: tabRoute.path, query: tabRoute.query })
}

const removeTab = (content: any) => {
    if (route.path == content) {
        const tabs = Object.keys(tabbarStore.tabs)
        router.push({ path: tabs[tabs.indexOf(content) - 1] })
    }
    tabbarStore.removeTab(content)
}

const closeLeft = (path: string) => {
    const tabs = Object.keys(tabbarStore.tabs)
    for (let i = tabs.indexOf(path) - 1; i >= 0; i--) {
        delete tabbarStore.tabs[tabs[i]]
    }
    router.push({ path })
}

const closeRight = (path: string) => {
    const tabs = Object.keys(tabbarStore.tabs)
    for (let i = tabs.indexOf(path) + 1; i < tabs.length; i++) {
        delete tabbarStore.tabs[tabs[i]]
    }
    router.push({ path })
}

const closeOther = (path: string) => {
    const tabs = Object.keys(tabbarStore.tabs)
    tabs.forEach((key: string) => { key != path && delete tabbarStore.tabs[key] })
    router.push({ path })
}

const closeCurrentTab = () => {
    removeTab(route.path)
}

const closeAllTabs = () => {
    const tabs = Object.keys(tabbarStore.tabs)
    const homeTab = tabs[0]
    tabs.forEach((key: string) => {
        if (key != homeTab) {
            delete tabbarStore.tabs[key]
        }
    })
    router.push({ path: homeTab })
}

const refreshCurrentTab = () => {
    if (!appStore.routeRefreshTag) return
    appStore.refreshRouterView()
}

const scrollLeft = () => {
    const wrap = document.querySelector('.el-tabs__nav-wrap')
    if (wrap) {
        wrap.scrollLeft -= 200
    }
}

const scrollRight = () => {
    const wrap = document.querySelector('.el-tabs__nav-wrap')
    if (wrap) {
        wrap.scrollLeft += 200
    }
}

const handleCommand = (command: string) => {
    switch (command) {
        case 'closeCurrent':
            closeCurrentTab()
            break
        case 'closeOther':
            closeOther(route.path)
            break
        case 'closeAll':
            closeAllTabs()
            break
    }
}
</script>

<style lang="scss" scoped>
.tab-wrap {
    display: flex;
    align-items: center;
    height: 40px;
    background-color: var(--el-bg-color);
    border-bottom: 1px solid var(--el-border-color-light);
    padding: 0 8px;
}

.nav-btn {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 28px;
    height: 28px;
    border-radius: var(--el-border-radius-base);
    cursor: pointer;
    transition: all 0.2s;
    color: var(--el-text-color-regular);
    flex-shrink: 0;

    &:hover {
        background-color: var(--el-fill-color-light);
        color: var(--el-color-primary);
    }

    &.refresh-btn:hover {
        color: var(--el-color-primary);
    }
}

:deep(.el-tabs) {
    flex: 1;

    .el-tabs--border-card {
        border: none;
    }

    .el-tabs__header {
        margin: 0;
    }

    .el-tabs__nav-wrap {
        margin-bottom: 0;

        &::after {
            display: none;
        }
    }

    .el-tabs__content {
        display: none;
    }

    .el-tabs__item {
        display: inline-flex !important;
        padding: 0 20px !important;
        align-items: center;
        height: 32px;
        border: 1px solid var(--el-border-color);
        border-radius: var(--el-border-radius-base);
        margin: 0 4px;
        font-size: 13px;
        color: var(--el-text-color-regular);
        transition: all 0.2s ease;

        .tab-name:focus {
            outline: none !important;
        }

        &:hover {
            color: var(--el-color-primary);
            border-color: var(--el-color-primary-light-7);
        }
    }

    .el-tabs__active-bar {
        display: none;
    }

    .el-tabs__item.is-active {
        background-color: var(--el-color-primary-light-9);
        color: var(--el-color-primary);
        border-color: var(--el-color-primary);
    }

    .is-close {
        &:hover {
            background-color: var(--el-fill-color-light);
        }
    }
}
</style>
