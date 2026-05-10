import type { RouterConfig } from '@nuxt/schema'
import routes from '@/pages/routes'
export default <RouterConfig>{
    routes: (_routes) => routes,
    strict: false
}
