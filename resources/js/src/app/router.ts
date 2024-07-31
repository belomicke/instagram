import { computed } from "vue"
import { createRouter, createWebHistory, RouteRecordRaw } from "vue-router"
import { storeToRefs } from "pinia"
import SignIn from "@/pages/auth/SignIn.vue"
import SignUp from "@/pages/auth/SignUp.vue"
import Auth from "@/pages/auth/auth.vue"
import HomePage from "@/pages/home/HomePage.vue"
import { useAuthStore } from "@/entities/auth/store"

const routes: RouteRecordRaw[] = [
    {
        path: "/",
        component: HomePage,
    },
    {
        path: "/auth",
        component: Auth,
        children: [
            { path: "sign_in", component: SignIn },
            { path: "sign_up", component: SignUp },
        ],
    },
]

export const router = createRouter({
    history: createWebHistory(),
    routes,
})

router.beforeEach(async (to, from, next) => {
    const { getIsAuth } = storeToRefs(useAuthStore())

    const isAuth = computed(() => {
        return getIsAuth.value
    })

    const authRoutes: string[] = [
        "/auth/sign_in",
        "/auth/sign_up",
    ]

    if (isAuth.value === false && authRoutes.indexOf(to.path) === -1) {
        return next({
            path: authRoutes[0],
        })
    }

    if (isAuth.value && authRoutes.indexOf(to.path) !== -1) {
        return next({
            path: "/",
        })
    }

    next()
})
