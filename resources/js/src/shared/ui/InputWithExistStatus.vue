<script setup lang="ts">
import { computed, ref, watch } from "vue"
import AuthFormInput from "@/shared/ui/AuthFormInput.vue"

interface TakenStatus {
    value: string
    taken: boolean
}

const props = defineProps({
    placeholder: {
        type: String,
        required: false,
    },
    value: {
        type: String,
        required: true,
    },
    isValid: {
        type: Boolean,
        required: false,
        default: false,
    },
    isLoading: {
        type: Boolean,
        required: false,
        default: false,
    },
})

defineExpose({
    addToList,
    getIsTakenStatus,
})

const emit = defineEmits(["update:value", "update:exists"])

const value = ref<string>("")
const statusList = ref<TakenStatus[]>([])

watch(value, (newValue) => {
    emit("update:value", newValue)
})

const exists = computed(() => {
    if (props.isValid === false) {
        emit("update:exists", undefined)
        return undefined
    }

    const entity = statusList.value.find(item => item.value === value.value)

    if (!entity) {
        emit("update:exists", undefined)
        return undefined
    }

    emit("update:exists", entity.taken)
    return entity.taken
})

const icon = computed(() => {
    if (exists.value === true) {
        return "close"
    } else if (exists.value === false) {
        return "check"
    } else {
        return ""
    }
})

function getIsTakenStatus(value: string) {
    const entity = statusList.value.find(item => item.value === value)

    if (!entity) return undefined

    return entity.taken
}

function addToList(value: string, status: boolean) {
    statusList.value.push({
        value: value,
        taken: status,
    })
}
</script>

<template>
    <auth-form-input
        :placeholder="placeholder"
        v-model="value"
    >
        <template #right-icon>
            <span class="material-symbols-outlined loader" v-if="isLoading">progress_activity</span>
            <span class="material-symbols-outlined" v-else>{{ icon }}</span>
        </template>
    </auth-form-input>
</template>

<style scoped lang="scss">
.material-symbols-outlined {
    font-family: 'Material Symbols Outlined';
    font-weight: normal;
    font-style: normal;
    font-size: 27px;
    line-height: 1;
    letter-spacing: normal;
    text-transform: none;
    display: inline-block;
    white-space: nowrap;
    word-wrap: normal;
    direction: ltr;
    -webkit-font-smoothing: antialiased;

    color: rgb(180, 180, 180);

    &.loader {
        animation: rotation 1s infinite linear;
    }
}

@keyframes rotation {
    from {
        transform: rotate(0deg);
    }
    to {
        transform: rotate(360deg);
    }
}
</style>
