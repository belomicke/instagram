<script setup lang="ts">
defineProps({
    disabled: {
        type: Boolean,
        required: false,
        default: false,
    },
})

const emit = defineEmits(["click"])

const clickHandler = (e: MouseEvent) => {
    emit("click", e)
}
</script>

<template>
    <button
        class="button"
        @click="clickHandler"
        :disabled="disabled"
    >
        <slot></slot>
    </button>
</template>

<style scoped lang="scss">
.button {
    display: flex;
    justify-content: center;
    align-items: center;
    width: 100%;
    color: #fff;
    background-color: rgb(75, 150, 255);
    user-select: none;
    border-radius: 10px;
    border: 0;
    height: 54px;
    cursor: pointer;
    font-size: 16px;
    font-weight: 500;
    transition: .15s;

    margin-top: 20px;

    &:hover {
        background-color: rgb(85, 160, 255);
    }

    &:disabled {
        opacity: .7;
        cursor: not-allowed;

        &:hover {
            background-color: rgb(75, 150, 255);
        }
    }
}
</style>
