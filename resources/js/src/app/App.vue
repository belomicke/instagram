<script lang="ts" setup>
import { computed, onMounted, watch } from "vue"
import { useRoute, useRouter } from "vue-router"
import { storeToRefs } from "pinia"
import LoadingPage from "@/pages/loading/LoadingPage.vue"
import { useAuthStore } from "@/entities/auth/store"
import { api } from "@/shared/api/methods"
import "./styles/main.scss"

defineOptions({
    name: "App",
})

const route = useRoute()
const router = useRouter()

const authStore = useAuthStore()
const { getIsAuth } = storeToRefs(authStore)

const isAuth = computed(() => {
    return getIsAuth.value
})

watch(isAuth, () => {
    const routesForGuests = [
        "/auth/sign_in",
        "/auth/sign_up",
    ]

    if (isAuth.value && routesForGuests.indexOf(route.path) !== -1) {
        router.push("/")
    }

    if (isAuth.value === false && routesForGuests.indexOf(route.path) === -1) {
        router.push(routesForGuests[0])
    }
})

onMounted(() => {
    defineTheme()

    api.session.startSession()
    authStore.getViewer()
})

function defineTheme() {
    const theme = localStorage.getItem("theme")

    if (theme === null) {
        localStorage.setItem("theme", "white")

        document.body.classList.add("white")
    } else {
        document.body.classList.add(theme)
    }
}
</script>

<template>
    <loading-page v-if="isAuth === undefined"/>
    <router-view v-else/>
</template>
