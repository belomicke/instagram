import axios, { AxiosResponse } from "axios"
import { ApiUserResponse } from "@/shared/api/types/response/users/ApiUserResponse"

export const users = {
    getViewer: async (): Promise<AxiosResponse<ApiUserResponse>> => {
        return await axios.get("/api/auth/viewer")
    },
}
