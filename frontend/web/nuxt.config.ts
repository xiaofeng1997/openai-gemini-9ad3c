// https://nuxt.com/docs/api/configuration/nuxt-config
import { loadEnv } from 'vite'
import topLevelAwait from 'vite-plugin-top-level-await'

const envName = (process.env as any).npm_lifecycle_event == 'dev' ? 'dev' : 'product'
const envData = loadEnv(envName, 'env')

export default defineNuxtConfig({
    app: {
        baseURL: '/web/',
        head: {
            link: [
                { rel: 'preconnect', href: 'https://fonts.googleapis.com' },
                { rel: 'preconnect', href: 'https://fonts.gstatic.com', crossorigin: '' },
            ]
        }
    },
    modules: [
        '@element-plus/nuxt',
        'nuxt-windicss'
    ],
    runtimeConfig: {
        public: envData
    },
    vite: {
        envDir: '~/env',
        plugins: [
            topLevelAwait({
                promiseExportName: '__tla',
                promiseImportName: i => `__tla_${i}`
            }),
        ],
        build: {
            rollupOptions: {
                output: {
                    manualChunks: {
                        'element-plus': ['element-plus'],
                        'vue-core': ['vue', 'vue-router', 'pinia'],
                        'swiper': ['swiper'],
                    }
                }
            }
        },
        optimizeDeps: {
            include: ['element-plus', 'vue', 'vue-router', 'pinia']
        }
    },
    ssr: false,
    nitro: {
        compressPublicAssets: true,
        minify: true
    },
    experimental: {
        payloadExtraction: true,
        renderJsonPayloads: true
    },
    routeRules: {
        '/web/**': {
            headers: {
                'Cache-Control': 'public, max-age=3600'
            }
        }
    }
})
