<template>
    <template v-if="meta.show">
        <el-sub-menu v-if="hasVisibleChild" :index="String(routes.name)">
            <template #title>
                <div class="w-[16px] h-[16px] relative flex items-center justify-center" v-if="props.level == 1">
                    <icon v-if="meta.icon" :name="meta.icon" class="!w-auto !h-auto text-[16px]" />
                    <el-icon v-else class="text-[16px]"><Folder /></el-icon>
                </div>
                <span class="ml-[10px] text-[13px]">{{ meta.title }}</span>
            </template>
            <menu-item v-for="(route, index) in routes.children" :routes="route" :key="index" :level="props.level + 1" />
        </el-sub-menu>
        <template v-else>
            <el-menu-item :index="String(routes.name)">
                <template #default>
                    <div class="w-[16px] h-[16px] relative flex items-center justify-center" v-if="props.level == 1">
                        <icon v-if="meta.icon" :name="meta.icon" class="!w-auto !h-auto text-[16px]" />
                        <el-icon v-else class="text-[16px]"><Document /></el-icon>
                    </div>
                    <span class="ml-[10px] text-[13px]">{{ meta.title }}</span>
                </template>
            </el-menu-item>
        </template>
        <div v-if="routes.is_border" class="border-t border-[rgba(255,255,255,0.1)] mx-[16px] my-[8px]"></div>
    </template>
</template>

<script lang="ts" setup>
import { useRouter, useRoute } from 'vue-router'
import { ref, computed, watch , onMounted, onUnmounted} from 'vue'
import useSystemStore from '@/stores/modules/system'
import useUserStore from '@/stores/modules/user'
import { Folder, Document } from '@element-plus/icons-vue'

const router = useRouter()
const route = useRoute()
const routers = useUserStore().routers
const props = defineProps({
    routes: {
        type: Object,
        required: true
    },
    level: {
        type: Number,
        default: 1
    }
})
const systemStore = useSystemStore()
const meta = computed(() => props.routes.meta)

const hasVisibleChild = computed(() => {
  if (!props.routes.children || !Array.isArray(props.routes.children)) {
    return false
  }
  return props.routes.children.some(child => child.meta?.show === 1)
})
</script>

<style lang="scss" scoped>
:deep(.el-sub-menu) {
    .el-icon {
        width: auto;
        color: #b8c5d6;
    }

    .el-sub-menu__title {
        transition: all 0.2s ease;

        &:hover {
            background-color: var(--el-color-primary) !important;
            color: #ffffff !important;

            .el-icon {
                color: #ffffff;
            }
        }
    }

    &.is-active > .el-sub-menu__title {
        color: #ffffff !important;

        .el-icon {
            color: #ffffff;
        }
    }
}

:deep(.el-menu-item) {
    transition: all 0.2s ease;
    position: relative;

    &:hover {
        background-color: var(--el-color-primary) !important;
        color: #ffffff !important;
    }

    .el-icon {
        color: #b8c5d6;
    }

    &:hover .el-icon {
        color: #ffffff;
    }
}

:deep(.el-sub-menu .el-menu) {
    background-color: #202020 !important;
}

:deep(.el-sub-menu .el-menu-item) {
    background-color: transparent !important;

    &:hover {
        background-color: var(--el-color-primary) !important;
    }
}
</style>
