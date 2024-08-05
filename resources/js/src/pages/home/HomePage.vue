<script setup lang="ts">
import { api } from "@/shared/api/methods"

const logout = () => {
    api.auth.logout()
    window.location.reload()
}
</script>

<template>
    <div>
        <button @click="logout">logout</button>
    </div>
</template>

<style scoped>

</style>
