<script setup lang="ts">
import { computed, ref } from "vue"
import { getUsernameIsValidStatus } from "@/entities/users/helpers/getUsernameIsValidStatus"
import { getEmailIsValidStatus } from "@/entities/users/helpers/getEmailIsValidStatus"
import AuthFormContainer from "@/shared/ui/AuthFormContainer.vue"
import AuthFormButton from "@/shared/ui/AuthFormButton.vue"
import AuthFormInput from "@/shared/ui/AuthFormInput.vue"
import { api } from "@/shared/api/methods"
import ILink from "@/shared/ui/ILink.vue"

const login = ref<string>("")
const password = ref<string>("")

const isLoading = ref<boolean>(false)

const error = ref<string>("")

const formIsValid = computed(() => {
    let loginIsValid: boolean

    if (login.value.indexOf("@") !== -1) {
        loginIsValid = getEmailIsValidStatus(login.value)
    } else {
        loginIsValid = getUsernameIsValidStatus(login.value) === ""
    }

    return loginIsValid &&
        password.value.length >= 8 &&
        password.value.length <= 72
})

const buttonIsDisabled = computed(() => {
    return !formIsValid.value || isLoading.value
})

const submit = async () => {
    isLoading.value = true

    const res = await api.auth.login({
        login: login.value,
        password: password.value,
    })
    const data = res.data

    if (data.success) {
        window.location.reload()
    } else {
        error.value = "неверный логин или пароль"
    }

    isLoading.value = false
}

const loginInputBlurHandler = () => {
    if (login.value.indexOf("@") !== -1) {
        if (!getEmailIsValidStatus(login.value)) {
            error.value = "некорректный эл. адрес"
        } else {
            error.value = ""
        }
    } else {
        error.value = getUsernameIsValidStatus(login.value)
    }
}

const passwordInputBlurHandler = () => {
    if (password.value.length > 72) {
        error.value = "пароль должен содержать менее 72 символов"
    } else if (password.value.length < 8) {
        error.value = "пароль должен содержать не менее 8 символов"
    } else {
        error.value = ""
    }
}
</script>

<template>
    <auth-form-container :error="error">
        <auth-form-input
            placeholder="Эл. почта или имя пользователя"
            @blur="loginInputBlurHandler"
            v-model="login"
        />
        <auth-form-input
            placeholder="Пароль"
            v-model="password"
            @blur="passwordInputBlurHandler"
            type="password"
        />
        <auth-form-button
            :disabled="buttonIsDisabled"
            @click="submit"
        >
            Войти
        </auth-form-button>
        <template #footer>
            Ещё нет аккаунта?
            <i-link
                href="/auth/sign_up"
                text="Зарегистрируйтесь"
            />
        </template>
    </auth-form-container>
</template>
