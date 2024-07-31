<script setup lang="ts">
import InstagramLogotype from "@/pages/auth/ui/InstagramLogotype.vue"

defineProps({
    error: {
        type: String,
        required: false,
        default: "",
    },
})
</script>

<template>
    <div class="auth-form-container">
        <instagram-logotype/>
        <form class="form">
            <slot name="default"></slot>
        </form>
        <div class="errors">{{ error }}</div>
        <div class="form-footer">
            <slot name="footer"></slot>
        </div>
    </div>
</template>

<style lang="scss" scoped>
.auth-form-container {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 40px;
}

.form {
    display: flex;
    flex-direction: column;
    gap: 24px;
    min-width: 320px;
}

.form-footer {
    user-select: none;
}

.errors {
    display: flex;
    justify-content: center;
    align-items: center;
    color: #ff595a;
    height: 65px;
    width: 100%;
}
</style>
