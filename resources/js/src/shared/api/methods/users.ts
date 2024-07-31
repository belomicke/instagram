import axios, { AxiosResponse } from "axios"

export const users = {
    getViewer: async (): Promise<AxiosResponse> => {
        return await axios.get("/api/auth/viewer")
    },
}
