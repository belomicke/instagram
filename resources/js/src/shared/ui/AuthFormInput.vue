<script setup lang="ts">
import { computed, ref } from "vue"

defineProps({
    placeholder: {
        type: String,
        required: false,
        default: "",
    },
    type: {
        type: String,
        required: false,
        default: "text",
    },
})

const model = defineModel()

const emit = defineEmits(["blur"])

const inputRef = ref<HTMLInputElement | null>(null)

const compact = computed(() => {
    return model.value.length
})

const blurHandler = () => {
    emit("blur")
}
</script>

<template>
    <div
        class="auth-form-input"
        @click="inputRef.focus()"
    >
        <input
            class="auth-form-input__input"
            :class="{
                'is-empty': !compact
            }"
            v-model="model"
            placeholder=""
            :autocomplete="type === 'password' ? 'new-password' : 'off'"
            :type="type"
            @blur="blurHandler"
            ref="inputRef"
        />
        <div class="auth-form-input__right-icon">
            <slot name="right-icon"></slot>
        </div>
        <label>
            <span
                class="auth-form-input__placeholder"
            >
                {{ placeholder }}
            </span>
        </label>
    </div>
</template>

<style lang="scss" scoped>
body.white .auth-form-input {
    --primary-color: rgb(75, 150, 255);

    --text-color: #000;
    --background-color: #fff;

    --border-color: rgb(220, 220, 220);
}

body.dark .auth-form-input {
    --primary-color: rgb(75, 150, 255);

    --text-color: #fff;
    --background-color: var(--body-background-color);

    --border-color: #2f2f2f;
}

.auth-form-input {
    --height: 54px;
    --border-radius: 10px;
    --padding: 1rem;
    --padding-horizontal: 1rem;
    --border-width: 1px;

    position: relative;
    height: 54px;
    border: var(--border-width) solid var(--border-color);
    border-radius: var(--border-radius);
    padding: 15px;
    cursor: text;
    transition: .15s;

    &:hover, &:focus-within {
        border-color: var(--primary-color);
    }

    &:focus-within {
        box-shadow: 0 0 0 1px var(--primary-color);
    }

    &__input:focus ~ label,
    &__input:not(.is-empty) ~ label,
    &__input:disabled ~ label {
        transform: translate(calc(-.1875rem + 1rem - var(--padding-horizontal)), calc(var(--height) / -2 + .0625rem)) scale(.75);
        padding: 0 .3125rem;
    }

    &__input {
        height: 100%;
        width: 100%;
        font-size: 16px;
        font-weight: 400;
        border: 0;
        color: var(--text-color);
        background-color: transparent;

        &:focus {
            outline: 0;
        }
    }

    &__right-icon {
        position: absolute;
        right: 10px;
        top: 50%;
        width: 27px;
        height: 27px;
        transform: translateY(-50%);
    }
}

label {
    position: absolute;
    color: #9e9e9e;
    top: 0;
    inset-inline: var(--padding-horizontal) auto;
    z-index: 2;
    height: 1.5rem;
    transform: translate(0);
    background-color: var(--background-color);
    transform-origin: left center;
    pointer-events: none;
    margin-top: calc((var(--height) - 1.5rem) / 2);
    -webkit-user-select: none;
    -moz-user-select: none;
    user-select: none;
    white-space: nowrap;
    transition: .2s transform, .2s padding, .1s opacity, font-weight 0s, color .2s;
}

.auth-form-input:focus-within > label {
    color: var(--primary-color);
    font-weight: 500;
}

.auth-form-input:hover > label {
    color: var(--primary-color);
}
</style>
