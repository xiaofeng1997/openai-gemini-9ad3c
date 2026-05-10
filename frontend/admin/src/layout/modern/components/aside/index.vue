<template>
    <el-aside class="layout-aside" :width="systemStore.menuIsCollapse ? '64px' : '200px'">
        <side class="hidden-xs-only" />
    </el-aside>

    <el-drawer 
        v-model="systemStore.menuDrawer" 
        direction="ltr" 
        :with-header="false" 
        custom-class="aside-drawer" 
        size="200px"
    >
        <template #default>
            <side />
        </template>
    </el-drawer>
</template>

<script lang="ts" setup>
import { watch } from 'vue'
import { useRoute } from 'vue-router'
import side from './side.vue'
import useSystemStore from '@/stores/modules/system'

const systemStore = useSystemStore()
const route = useRoute()

watch(route, () => {
    systemStore.$patch(state => {
        state.menuDrawer = false
    })
})
</script>

<style lang="scss" scoped>
.layout-aside {
    position: relative;
    transition: width 0.28s ease;
    flex-shrink: 0;
    z-index: 100;
}

:deep(.aside-drawer) {
    .el-drawer__body {
        padding: 0 !important;
    }
}
</style>
