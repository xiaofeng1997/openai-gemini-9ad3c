import { nextTick } from 'vue'
import { getAppPages, getSubPackagesPages} from "@/utils/pages"

class Language {
    private i18n: any
    private loadLocale: Array<string> = [] //已加载的语言

    public path = ''

    constructor(i18n: any) {
        this.i18n = i18n
    }

    /**
     *
     * @param locale 设置语言
     */
    public setI18nLanguage(locale: string, path: string = '') {
        if (this.i18n.global.locale == locale) return
        this.i18n.global.locale = locale
        path && (this.path = path)
        uni.setLocale(locale)
    }

    public loadAllLocaleMessages(app: string, locale: string) {
        const pages = app == 'app' ? getAppPages() : getSubPackagesPages()
        pages.forEach((path: string) => {
            this.loadLocaleMessages(path, locale)
        })
    }

    /**
     * 加载语言包
     * @param path
     * @param locale
     * @returns
     */
    public async loadLocaleMessages(path: string, locale: string) {
        try {
            const {file, fileKey } = this.getFileKey(path)

            // 是否已加载
            if (this.loadLocale.includes(`${fileKey}.${locale}`)) {
                this.setI18nLanguage(locale, file)
                return nextTick()
            }
            this.loadLocale.push(`${fileKey}.${locale}`)

            // 引入语言包文件

            // #ifdef APP-PLUS
            const appLang = import.meta.glob('../locale/**/*.json', { eager: true })
            const messages = appLang[`../locale/${locale}/${file}.json`] 
            // #endif

            // #ifndef APP-PLUS
            const messages = await import(`../locale/${locale}/${file}.json` )
            // #endif

            let data: Record<string, string> = {}
            Object.keys(messages.default).forEach(key => {
                data[`${fileKey}.${key}`] = messages.default[key]
            })
            this.i18n.global.mergeLocaleMessage(locale, data)
            this.setI18nLanguage(locale, file)

            return nextTick()
        } catch (e) {
            this.setI18nLanguage(locale)
            return nextTick()
        }
    }

    public getFileKey = (path: string) => {
        try {
            let file = path == '/' ? 'pages.index.index' : path.replace('/', '').replace(/\//g, ".")

            let fileKey = file
            return { file, fileKey }
        } catch (e) {
            return { file: 'pages.index.index', fileKey: 'pages.index.index'}
        }
    }
}

export default Language
