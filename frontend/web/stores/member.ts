import { defineStore } from 'pinia'

interface Member {
    token: string | null
    info: Record<string, any> | null,
    loginPopup: boolean
}

const useMemberStore = defineStore('member', {
    state: (): Member => {
        return {
            token: useCookie('token').value,
            info: null,
            loginPopup: false
        }
    },
    getters: {
        isLogin: (state) => !!state.token && !!state.info,
        memberId: (state) => state.info?.member_id || 0,
        nickname: (state) => state.info?.nickname || '',
        point: (state) => state.info?.point || 0,
    },
    actions: {
        async setToken(token: string) {
            this.token = token
            useCookie('token', { maxAge: 60 * 60 * 24 * 7 }).value = token
            await this.getMemberInfo()
        },
        async getMemberInfo() {
            if (!this.token) return
            try {
                const { getMemberInfo } = await import('@/api/member')
                const res: any = await getMemberInfo()
                this.info = res.data
            } catch {
                this.logout()
            }
        },
        logout() {
            this.token = ''
            this.info = null
            useCookie('token').value = null
            import('@/api/auth').then(({ logout }) => {
                logout().catch(() => { })
            })
        },
        logOpen() {
            this.loginPopup = true
        },
        logClose() {
            this.loginPopup = false
        },
        updateInfo(data: Record<string, any>) {
            this.info = { ...this.info, ...data }
        }
    }
})

export default useMemberStore
