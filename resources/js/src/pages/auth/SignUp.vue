<script setup lang="ts">
import { computed, ref } from "vue"
import { useRouter } from "vue-router"
import { getUsernameIsValidStatus } from "@/entities/users/helpers/getUsernameIsValidStatus"
import { getEmailIsValidStatus } from "@/entities/users/helpers/getEmailIsValidStatus"
import { getNameIsValidStatus } from "@/entities/users/helpers/getNameIsValidStatus"
import AuthFormContainer from "@/shared/ui/AuthFormContainer.vue"
import AuthFormButton from "@/shared/ui/AuthFormButton.vue"
import AuthFormInput from "@/shared/ui/AuthFormInput.vue"
import { api } from "@/shared/api/methods"
import ILink from "@/shared/ui/ILink.vue"

const router = useRouter()

const email = ref<string>("")
const username = ref<string>("")
const name = ref<string>("")
const password = ref<string>("")

const isLoading = ref<boolean>(false)

const formIsValid = computed(() => {
    return getEmailIsValidStatus(email.value) &&
        getUsernameIsValidStatus(username.value) &&
        getNameIsValidStatus(name.value) &&
        password.value.length >= 8
})

const buttonIsDisabled = computed(() => {
    return !formIsValid.value || isLoading.value
})

const submit = async () => {
    isLoading.value = true

    const res = await api.auth.signup({
        email: email.value,
        password: password.value,
        name: name.value,
        username: username.value,
    })
    const data = res.data

    if (data.success) {
        await router.push("/auth/sign_in")
    }

    isLoading.value = false
}
</script>

<template>
    <auth-form-container>
        <auth-form-input
            placeholder="Эл. почта"
            v-model="email"
        />
        <auth-form-input
            placeholder="Имя пользователя"
            v-model="username"
        />
        <auth-form-input
            placeholder="Имя"
            v-model="name"
        />
        <auth-form-input
            placeholder="Пароль"
            v-model="password"
            type="password"
        />
        <auth-form-button
            :disabled="buttonIsDisabled"
            @click="submit"
        >
            Зарегистрироваться
        </auth-form-button>
        <template #footer>
            Уже есть аккаунт?
            <i-link
                href="/auth/sign_in"
                text="Войти"
            />
        </template>
    </auth-form-container>
</template>
