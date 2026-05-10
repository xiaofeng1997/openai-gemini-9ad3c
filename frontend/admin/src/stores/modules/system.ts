import { defineStore } from 'pinia'
import storage from '@/utils/storage'
import { useCssVar } from '@vueuse/core'
import { useCssVar } from '@vueuse/core'


interface System {
    menuIsCollapse: boolean,
    dark: boolean,
    theme: string,
    lang: string
}

const theme = storage.get('theme') ?? {}

const useSystemStore = defineStore('system', {
    state: (): System => {
        return {
            menuIsCollapse: false,
            dark: theme.dark ?? false,
            theme: theme.theme ?? '#4415EF',
            lang: storage.get('lang') ?? 'zh-cn'
        }
    },
    actions: {
        setTheme(state: string, value: any) {
            this[state] = value
            theme[state] = value
            storage.set({ key: 'theme', data: theme })
        },
        toggleMenuCollapse(value: boolean) {
            this.menuIsCollapse = value
            storage.set({ key: 'menuiscollapse', data: value })
            useCssVar('--aside-width').value = value ? 'calc(var(--el-menu-icon-width) + var(--el-menu-base-level-padding) * 2)' : '210px'
        },
    }
})

export default useSystemStore
