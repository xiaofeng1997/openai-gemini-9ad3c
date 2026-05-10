<template>
    <el-container class="h-screen layout-aside flex flex-col" :class="{ 'collapsed': systemStore.menuIsCollapse }" :style="{ width: systemStore.menuIsCollapse ? '64px' : '200px' }">
        <!-- Logo区域 -->
        <el-header class="logo-wrap flex items-center justify-center h-[50px]">
            <div class="logo flex items-center justify-center m-auto w-full h-[50px]" v-if="!systemStore.menuIsCollapse">
                <template v-if="webSite">
                    <img class="max-h-[30px] max-w-[70%]" v-if="webSite.logo" :src="img(webSite.logo)" alt="">
                    <img class="max-h-[30px] max-w-[70%]" src="@/assets/images/logo_default.png" alt="" v-else>
                </template>
                <img class="max-h-[30px] max-w-[70%]" src="@/assets/images/logo_default.png" alt="" v-else>
            </div>
            <div class="logo flex items-center justify-center h-[50px]" v-else>
                <!-- <i class="text-xl text-white iconfont iconyunkongjian"></i> -->
                <img class="h-[20px] w-[20px]" src="@/assets/images/square_logo_default.png" alt="">
            </div>
        </el-header>

        <!-- 菜单区域 -->
        <el-main class="menu-wrap">
            <el-scrollbar>
                <el-menu
                    :default-active="route.name"
                    :router="false"
                    class="aside-menu h-full"
                    :unique-opened="true"
                    :collapse="systemStore.menuIsCollapse"
                    @select="handleMenuSelect"
                    :collapse-transition="false"
                >
                    <menu-item v-for="(route, index) in menuData" :routes="route" :key="index" />
                </el-menu>
                <div class="h-[48px]"></div>
            </el-scrollbar>
        </el-main>

        <!-- 底部折叠按钮 -->
        <div class="collapse-btn" @click="toggleCollapse">
            <el-icon class="text-[#b8c5d6]">
                <Fold v-if="!systemStore.menuIsCollapse" />
                <Expand v-else />
            </el-icon>
        </div>
    </el-container>
</template>

<script lang="ts" setup>
import { ref, onMounted } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import useSystemStore from '@/stores/modules/system'
import useUserStore from '@/stores/modules/user'
import menuItem from './menu-item.vue'
import { img } from '@/utils/common'
import { findFirstValidRoute } from '@/router/routers'
import { getWebConfig } from "@/api/sys"
import { Fold, Expand } from '@element-plus/icons-vue'

const systemStore = useSystemStore()
const userStore = useUserStore()
const route = useRoute()
const router = useRouter()
const webSite = ref(null)
const routers = userStore.routers
const menuData = ref<Record<string, any>[]>([])

onMounted(() => {
    getWebConfig().then(({ data }) => {
        webSite.value = data
    });
})

routers.forEach(item => {
    item.original_name = item.name
    if (item.meta.attr == '' && item.name != 'sign' && item.name != 'verify') {
        if (item.children && item.children.length) {
            item.name = findFirstValidRoute(item.children)
        }
    }
    menuData.value.push(item)
})

const handleMenuSelect = (index: string) => {
    const query = route.name === index
      ? { refresh: Date.now() }
      : {};
    router.push({ name: index, query });
}

const toggleCollapse = () => {
    systemStore.toggleMenuCollapse(!systemStore.menuIsCollapse)
}
</script>

<style lang="scss" scoped>
.layout-aside {
    transition: width 0.28s ease;
    box-shadow: 2px 0 8px rgba(0, 0, 0, 0.15);
    z-index: 100;
    background-color: #ffffff;
}

.menu-wrap {
    padding: 0 !important;
    flex: 1;
    overflow: hidden;
    background-color: #ffffff;
    border-right: 1px solid #e4e7ed;

    .el-menu {
        border-right: 0 !important;
        transition: all 0.28s ease;
        background-color: #ffffff;

        :deep(.el-menu-item),
        :deep(.el-sub-menu__title) {
            height: 44px;
            line-height: 44px;
            margin: 4px 8px;
            border-radius: var(--el-border-radius-base);
            transition: all 0.2s ease;
            color: #666666;

            &:hover {
                background-color: transparent !important;
                color: var(--el-color-primary) !important;
            }
        }

        :deep(.el-sub-menu .el-menu) {
            background-color: #f5f7fa !important;
        }

        :deep(.el-sub-menu .el-menu-item) {
            height: 38px;
            line-height: 38px;
            margin: 2px 8px 2px 24px;
            background-color: transparent !important;

            &:hover {
                background-color: transparent !important;
                color: var(--el-color-primary) !important;
            }
        }

        :deep(.el-menu-item.is-active) {
            color: var(--el-color-primary) !important;
        }

        :deep(.el-sub-menu.is-active > .el-sub-menu__title) {
            color: var(--el-color-primary) !important;
        }
    }

    .el-scrollbar {
        height: 100%;
    }
}

.collapsed .menu-wrap .el-menu :deep(.el-menu-item),
.collapsed .menu-wrap .el-menu :deep(.el-sub-menu__title){
    padding-left: 14px !important;
    padding-right: 0 !important;
}

.logo-wrap {
    padding: 0;
    transition: all 0.28s ease;
    border-bottom: 1px solid #e4e7ed;
    background-color: #ffffff;
}

.logo {
    transition: all 0.28s ease;
}

.collapse-btn {
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.3s;
    background-color: #ffffff;
    border-top: 1px solid #e4e7ed;

    &:hover {

        .el-icon {
            color: var(--el-color-primary) !important;
        }
    }
}
</style>
