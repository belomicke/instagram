<script setup lang="ts">
import { computed, ref, watch } from "vue"
import axios from "axios"
import _ from "lodash"
import { getEmailIsValidStatus } from "@/entities/users/helpers/getEmailIsValidStatus"
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

const email = ref<string>("")

const isLoading = ref<boolean>(false)
const exists = ref<boolean | undefined>(undefined)

const inputRef = ref<InstanceType<typeof InputWithExistStatus> | null>(null)

const isValid = computed(() => {
    return getEmailIsValidStatus(email.value)
})

watch(email, async (newEmail) => {
    emit("update:value", newEmail)

    if (isValid.value === false) {
        return
    }

    if (inputRef.value.getIsTakenStatus(newEmail)) {
        return
    }

    await checkUsernameIsTaken(newEmail)
})

const checkUsernameIsTaken = _.debounce(async (value: string): Promise<boolean> => {
    isLoading.value = true

    const res = await axios.get(`/api/users/email/exists`, {
        params: {
            email: value,
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
        placeholder="Эл. адрес"
        :is-loading="isLoading"
        :is-valid="isValid"
        @update:exists="exists = $event"
        @update:value="email = $event"
        ref="inputRef"
        :value="email"
    />
</template>
