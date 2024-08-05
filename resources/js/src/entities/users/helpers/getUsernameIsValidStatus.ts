export const getUsernameIsValidStatus = (username: string) => {
    if (username.length < 5) {
        return "имя пользователя должно содержать не менее 5 символов"
    }

    if (username.length > 32) {
        return "имя пользователя должно содержать не более 32 символов"
    }

    const regex = /^[a-zA-Z0-9_.]$/

    for (let index = 0; index < username.length; index++) {
        const letter = username[index]

        if (!regex.exec(letter)) {
            return "имя пользователя содержит недопустимые символы"
        }
    }

    if (!isNaN(Number(username))) {
        return "имя пользователя не может состоять только из цифр"
    }

    const firstLetter = username[0]

    if (firstLetter === "." || firstLetter === "_") {
        return "имя пользователя не может начинаться со спец. символа"
    }

    const lastLetter = username.at(-1)

    if (lastLetter === "." || lastLetter === "_") {
        return "имя пользователя не может заканчиваться спец. символом"
    }

    for (let index = 0; index < username.length; index++) {
        if (username[index] === "." && username[index - 1] === ".") {
            return "имя пользователя не может содержать две и более точек идущих подряд"
        }
    }

    return ""
}
