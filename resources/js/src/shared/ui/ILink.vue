<script setup lang="ts">
defineProps({
    text: {
        type: String,
        required: true
    },
    href: {
        type: String,
        required: true
    }
})
</script>

<template>
    <router-link
        class="i-link"
        :to="href"
    >
        {{ text }}
    </router-link>
</template>

<style lang="scss" scoped>
.i-link {
    color: rgb(75, 150, 255);
    text-decoration: none;

    &:hover {
        text-decoration: underline;
    }
}
</style>
