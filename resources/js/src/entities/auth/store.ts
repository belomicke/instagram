import { computed, ref } from "vue"
import { defineStore } from "pinia"
import { api } from "@/shared/api/methods"
import { AxiosError } from "axios"

export const useAuthStore = defineStore("auth", () => {
    const isAuth = ref<boolean | undefined>(undefined)

    const getIsAuth = computed(() => {
        return isAuth.value
    })

    async function getViewer() {
        try {
            const res = await api.users.getViewer()
            const data = res.data

            isAuth.value = true
        } catch (e: AxiosError) {
            if (e.response.status === 401) {
                isAuth.value = false
            }
        }
    }

    return {
        getIsAuth,

        getViewer,
    }
})
