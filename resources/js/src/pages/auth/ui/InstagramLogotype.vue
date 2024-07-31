<script setup lang="ts">
import { ref } from "vue"

const theme = ref<string>(localStorage.getItem("theme") ?? "white")
</script>

<template>
    <div
        class="instagram-logotype"
        :class="{
            'dark': theme === 'dark'
        }"
    />
</template>

<style lang="scss" scoped>
.instagram-logotype {
    background-image: url(http://localhost/8n91YnfPq0s.png);
    background-position: 0 -52px;
    background-size: auto;
    width: 175px;
    height: 51px;
    background-repeat: no-repeat;
    display: inline-block;

    &.dark {
        background-position: 0 0;
    }
}
</style>
