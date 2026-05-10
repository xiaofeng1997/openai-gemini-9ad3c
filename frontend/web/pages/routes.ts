export default [
    {
        path: "/",
        component: () => import('~/pages/index.vue')
    },
    {
        path: "/index",
        component: () => import('~/pages/index.vue')
    },
    {
        path: "/auth/login",
        component: () => import('~/pages/auth/login.vue'),
        meta: {
            layout: "container"
        }
    },
    {
        path: "/auth/register",
        component: () => import('~/pages/auth/register.vue'),
        meta: {
            layout: "container"
        }
    },
    {
        path: "/auth/bind",
        component: () => import('~/pages/auth/bind.vue'),
        meta: {
            layout: "container"
        }
    },
    {
        path: "/auth/agreement",
        component: () => import('~/pages/auth/agreement.vue'),
        meta: {
            layout: "member"
        }
    },
    {
        path: "/member/center",
        component: () => import('~/pages/member/center.vue'),
        meta: {
            middleware: ["auth"],
            layout: "member"
        }
    },
    {
        path: "/member/balance",
        component: () => import('~/pages/member/balance.vue'),
        meta: {
            middleware: ["auth"],
            layout: "member"
        }
    },
    {
        path: "/member/point",
        component: () => import('~/pages/member/point.vue'),
        meta: {
            middleware: ["auth"],
            layout: "member"
        }
    },
    {
        path: "/site/close",
        component: () => import('~/pages/site/close.vue'),
        meta: {
            layout: "container"
        }
    }
]
