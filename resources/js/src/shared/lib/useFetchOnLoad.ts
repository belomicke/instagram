import { onMounted, ref } from "vue"

export const useFetchOnLoad = (callback: () => Promise<void>) => {
    const isLoading = ref<boolean>(true)

    const fetch = async () => {
        try {
            callback().then(() => {
                isLoading.value = false
            })
        } catch (e) {
            isLoading.value = false
        }
    }

    onMounted(async () => {
        await fetch()
    })

    return {
        isLoading
    }
}
