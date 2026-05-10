<template>
    <div class="flex w-full h-screen layout-modern">
        <!-- 左侧边栏 -->
        <layout-aside></layout-aside>
        <!-- 左侧边栏 end -->

        <el-container class="main-container">
            <!-- 顶部 -->
            <el-header class="main-header">
                <layout-header></layout-header>
            </el-header>
            <!-- 顶部 end -->

            <!-- 标签页 -->
            <tabs-view></tabs-view>
            
            <!-- 主体 -->
            <el-main class="main-content">
                <el-scrollbar class="content-scrollbar">
                    <div class="content-wrapper">
                        <router-view v-slot="{ Component, route }" v-if="appStore.routeRefreshTag">
                            <keep-alive :include="tabbarStore.tabNames">
                                <component :is="Component" :key="route.fullPath" />
                            </keep-alive>
                        </router-view>
                    </div>
                </el-scrollbar>
            </el-main>
            <!-- 主体 end -->
        </el-container>
    </div>
</template>

<script lang="ts" setup>
import { computed } from 'vue'
import layoutHeader from './components/header/index.vue'
import layoutAside from './components/aside/index.vue'
import tabsView from './components/tabs.vue'
import useAppStore from '@/stores/modules/app'
import useTabbarStore from '@/stores/modules/tabbar'
import useSystemStore from '@/stores/modules/system'

const appStore = useAppStore()
const tabbarStore = useTabbarStore()
const systemStore = useSystemStore()
const dark = computed(() => {
    return systemStore.dark
})
</script>

<style lang="scss" scoped>
.layout-modern {
    background-color: #f0f2f5;
    
    .main-container {
        display: flex;
        flex-direction: column;
        height: 100%;
        flex: 1;
        overflow: hidden;
    }
    
    .main-header {
        padding: 0;
        height: 50px;
        line-height: 50px;
        background-color: #ffffff;
        border-bottom: 1px solid #e4e7ed;
        box-shadow: 0 1px 4px rgba(0, 21, 41, 0.08);
        transition: all 0.3s ease;
        z-index: 9;
        flex-shrink: 0;
    }
    
    .main-content {
        flex: 1;
        padding: 0;
        overflow: hidden;
        background-color: #f0f2f5;
    }
    
    .content-scrollbar {
        height: 100%;
        
        :deep(.el-scrollbar__view) {
            min-height: 100%;
        }
    }
    
    .content-wrapper {
        padding: 2px;
        min-height: calc(100vh - 90px);
    }
}

// 暗黑模式适配
:global(.dark) {
    .layout-modern {
        background-color: var(--el-bg-color-page);
        
        .main-header {
            background-color: var(--el-bg-color);
            border-bottom-color: var(--el-border-color-light);
        }
        
        .main-content {
            background-color: var(--el-bg-color-page);
        }
    }
}
</style>
