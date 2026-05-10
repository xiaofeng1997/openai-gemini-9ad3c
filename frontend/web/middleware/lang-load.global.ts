import useSystemStore from '~/stores/system'
import Language from '~~/utils/language'

export default defineNuxtRouteMiddleware((to, from) => {
    const language = new Language(useNuxtApp().$getI18n())
    const lang = typeof useSystemStore().lang === 'string' ? useSystemStore().lang : useSystemStore().lang.code
    language.loadLocaleMessages(to.path, lang)
})
