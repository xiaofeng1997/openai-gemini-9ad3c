import { defineStore } from 'pinia'
import storage from '@/utils/storage'
import { getSiteInfo } from '@/api/system'

interface System {
    lang: string,
    site: Record<string, any>

}

const useSystemStore = defineStore('system', {
    state: (): System => {
        return {
            lang: storage.get('lang') ?? 'zh-cn',
            site: {
                front_end_name: '',
                site_name: ''
            }
        }
    },
    actions: {
        async getSiteInfoFn() {
            await getSiteInfo().then((res: any) => {
                this.site = res.data

            }).catch((err) => {

            })
        }
    }
})

export default useSystemStore
