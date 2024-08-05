import { AxiosResponse } from "axios"

export type StatusResponse = AxiosResponse<{
    success: boolean
}>
