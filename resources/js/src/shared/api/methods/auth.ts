import axios from "axios"
import { StatusResponse } from "@/shared/api/types/response/StatusResponse"
import CreateUserDTO from "@/shared/api/types/dto/users/CreateUserDTO"
import LoginDTO from "@/shared/api/types/dto/auth/LoginDTO"

export const auth = {
    logout: async (): Promise<StatusResponse> => {
        return await axios.delete("/api/auth/logout")
    },
    login: async (data: LoginDTO): Promise<StatusResponse> => {
        return await axios.post("/api/auth/sign_in", {
            login: data.login,
            password: data.password,
        })
    },
    signup: async (data: CreateUserDTO): Promise<StatusResponse> => {
        return await axios.post("/api/auth/sign_up", {
            email: data.email,
            username: data.username,
            name: data.name,
            password: data.password,
        })
    },
}
