export const getUsernameIsValidStatus = (username: string) => {
    if (username.length < 5) {
        return false
    }

    if (username.length > 32) {
        return false
    }

    const regex = /^[a-zA-Z0-9_.]$/

    for (let index = 0; index < username.length; index++) {
        const letter = username[index]

        if (!regex.exec(letter)) {
            return false
        }
    }

    if (!isNaN(Number(username))) {
        return false
    }

    const firstLetter = username[0]

    if (firstLetter === "." || firstLetter === "_") {
        return false
    }

    const lastLetter = username.at(-1)

    if (lastLetter === "." || lastLetter === "_") {
        return false
    }

    for (let index = 0; index < username.length; index++) {
        if (username[index] === "." && username[index - 1] === ".") {
            return false
        }
    }

    return true
}
