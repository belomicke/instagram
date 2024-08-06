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
import UsernameInput from "@/entities/auth/ui/UsernameInput/UsernameInput.vue"
import EmailInput from "@/entities/auth/ui/EmailInput/EmailInput.vue"

const router = useRouter()

const email = ref<string>("")
const emailIsTaken = ref<boolean | undefined>(undefined)

const username = ref<string>("")
const usernameIsTaken = ref<boolean | undefined>(undefined)

const name = ref<string>("")
const password = ref<string>("")

const isLoading = ref<boolean>(false)

const formIsValid = computed(() => {
    return getEmailIsValidStatus(email.value) &&
        getUsernameIsValidStatus(username.value) === "" &&
        getNameIsValidStatus(name.value) &&
        password.value.length >= 8 &&
        usernameIsTaken.value === false &&
        emailIsTaken.value === false
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

const updateUsername = (value: string) => {
    username.value = value
}

const updateUsernameIsTaken = (value: boolean) => {
    usernameIsTaken.value = value
}

const updateEmail = (value: string) => {
    email.value = value
}

const updateEmailIsTaken = (value: boolean) => {
    emailIsTaken.value = value
}
</script>

<template>
    <auth-form-container>
        <email-input
            :value="email"
            :exists="emailIsTaken"
            @update:value="updateEmail"
            @update:exists="updateEmailIsTaken"
        />
        <username-input
            :value="username"
            :exists="usernameIsTaken"
            @update:value="updateUsername"
            @update:exists="updateUsernameIsTaken"
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
