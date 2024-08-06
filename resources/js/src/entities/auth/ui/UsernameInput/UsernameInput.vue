<script setup lang="ts">
import { computed, ref, watch } from "vue"
import axios from "axios"
import _ from "lodash"
import { getUsernameIsValidStatus } from "@/entities/users/helpers/getUsernameIsValidStatus"
import InputWithExistStatus from "@/shared/ui/InputWithExistStatus.vue"

defineProps({
    value: {
        type: String,
        required: true,
    },
    exists: {
        type: Boolean,
        required: false,
    },
})

const emit = defineEmits(["update:value", "update:exists"])

const username = ref<string>("")

const isLoading = ref<boolean>(false)
const exists = ref<boolean | undefined>(undefined)

const inputRef = ref<InstanceType<typeof InputWithExistStatus> | null>(null)

const isValid = computed(() => {
    return getUsernameIsValidStatus(username.value) === ""
})

watch(username, async (newUsername) => {
    emit("update:value", newUsername)

    if (isValid.value === false) {
        return
    }

    if (inputRef.value.getIsTakenStatus(newUsername)) {
        return
    }

    await checkUsernameIsTaken(newUsername)
})

const checkUsernameIsTaken = _.debounce(async (value: string): Promise<boolean> => {
    isLoading.value = true

    const res = await axios.get(`/api/users/username/exists`, {
        params: {
            username: value,
        },
    })
    const data = res.data

    if (data.success) {
        inputRef.value.addToList(value, data.data.exists)
        isLoading.value = false
        return
    }

    inputRef.value.addToList(value, false)

    isLoading.value = false
}, 500)
</script>

<template>
    <input-with-exist-status
        placeholder="Имя пользователя"
        :is-loading="isLoading"
        :is-valid="isValid"
        @update:exists="exists = $event"
        @update:value="username = $event"
        ref="inputRef"
        :value="username"
    />
</template>
