import { ElMessage } from 'element-plus'
import useMemberStore from '@/stores/member'
import qs from 'qs'

interface ConfigOption {
    showErrorMessage?: boolean
    showSuccessMessage?: boolean,
    headers?: Headers
}

interface FetchOptions {
    baseURL: string
    headers: Record<string, any>
    onRequest?: (data: any) => void
    onResponse?: (data: any) => void
    onResponseError?: (data: any) => void
    showErrorMessage?: boolean
    showSuccessMessage?: boolean
    watch: boolean
}

let baseURLCache = ''
let baseURLInitPromise: Promise<string> | null = null

const getBaseURL = async (): Promise<string> => {
    if (baseURLCache) return baseURLCache
    if (baseURLInitPromise) return baseURLInitPromise

    baseURLInitPromise = new Promise((resolve) => {
        const runtimeConfig = useRuntimeConfig()
        const url = runtimeConfig.public.VITE_APP_BASE_URL || `${location.origin}/api/`
        baseURLCache = url.endsWith('/') ? url : url + '/'
        resolve(baseURLCache)
    })

    return baseURLInitPromise
}

class Http {
    private options: FetchOptions = {
        baseURL: '',
        headers: {},
        watch: false
    }

    public constructor() {
        this.options.onRequest = (data) => {
            const runtimeConfig = useRuntimeConfig()
            this.options.headers[runtimeConfig.public.VITE_REQUEST_HEADER_CHANNEL_KEY] = 'pc'
            if (getToken()) this.options.headers[runtimeConfig.public.VITE_REQUEST_HEADER_TOKEN_KEY] = getToken()
        }

        this.options.onResponse = ({ response, options }) => {
            const { _data: data } = response
            this.handleNetworkError(response)
            if (data.code != undefined) {
                if (data.code == 1) {
                    if (options.showSuccessMessage) ElMessage({ message: data.msg, type: 'success' })
                } else {
                    if (options.showErrorMessage === false) return
                    if (data.code == 0 || data.code == 400) {
                        ElMessage({ message: data.msg, type: 'error' })
                    } else {
                        this.handleAuthError(data.code)
                    }
                }
            }
        }
    }

    public get(url: string, query = {}, config: ConfigOption = {}) {
        url += '?' + qs.stringify(query)
        return this.request(url, 'GET', {}, config)
    }

    public post(url: string, body = {}, config: ConfigOption = {}) {
        return this.request(url, 'POST', { body }, config)
    }

    public put(url: string, body = {}, config: ConfigOption = {}) {
        return this.request(url, 'PUT', { body }, config)
    }

    public delete(url: string, config: ConfigOption = {}) {
        return this.request(url, 'DELETE', {}, config)
    }

    private request(url: string, method: string, param: AnyObject = {}, config: ConfigOption = {}) {
        return new Promise(async (resolve, reject) => {
            const baseURL = await getBaseURL()

            if (!this.options.baseURL) {
                this.options.baseURL = baseURL
            }

            for (const key in param.query) {
                if (param.query[key] instanceof Array) {
                    param.query[key].forEach((item: any, index: number) => {
                        param.query[`${key}[${index}]`] = item
                    })
                    delete param.query[key]
                }
            }

            const fullUrl = this.options.baseURL + url.replace(/^\//, '')

            useFetch(fullUrl, { ...this.options, method, ...config, ...param }).then((response) => {
                const { data: { value }, error } = response
                if (value) {
                    if (value.code && value.code == 1) {
                        resolve(value)
                    } else {
                        if (value.type && value.type == 'application/zip') {
                            resolve(value)
                        } else {
                            reject(value)
                        }
                    }
                } else {
                    reject(error)
                }
            }).catch(err => {
                reject(err)
            })
        })
    }

    private handleAuthError(code: number) {
        switch (code) {
            case 401:
                useMemberStore().logout()
                break
            case 402:
                navigateTo('/site/close', { replace: true })
                break
        }
    }

    private handleNetworkError(err: any) {
        if (err.status && err.status != 200) {
            let errMessage = ''
            switch (err.status) {
                case 400:
                    errMessage = t('request.400')
                    break
                case 401:
                    errMessage = t('request.401')
                    break
                case 403:
                    errMessage = t('request.403')
                    break
                case 404:
                    errMessage = err.url + t('request.404')
                    break
                case 405:
                    errMessage = t('request.405')
                    break
                case 408:
                    errMessage = t('request.408')
                    break
                case 409:
                    errMessage = t('request.409')
                    break
                case 500:
                    errMessage = t('request.500')
                    break
                case 501:
                    errMessage = t('request.501')
                    break
                case 502:
                    errMessage = t('request.502')
                    break
                case 503:
                    errMessage = t('request.503')
                    break
                case 504:
                    errMessage = t('request.504')
                    break
                case 505:
                    errMessage = t('request.505')
                    break
            }
            ElMessage({ message: errMessage, type: 'error' })
        }
    }
}

const request = new Http()
export default request
