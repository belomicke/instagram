import axios, { AxiosResponse } from "axios"

interface LoginDTO {
    login: string
    password: string
}

interface CreateUserDTO {
    email: string
    username: string
    name: string
    password: string
}

export const auth = {
    logout: async () => {
        return await axios.delete("/api/auth/logout")
    },
    login: async (data: LoginDTO) => {
        return await axios.post("/api/auth/sign_in", {
            login: data.login,
            password: data.password,
        })
    },
    signup: async (data: CreateUserDTO): Promise<AxiosResponse> => {
        return await axios.post("/api/auth/sign_up", {
            email: data.email,
            username: data.username,
            name: data.name,
            password: data.password,
        })
    },
}
