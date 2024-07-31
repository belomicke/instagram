import axios from "axios"

export const session = {
    startSession: async () => {
        await axios.get("/sanctum/csrf-cookie")
    },
}
