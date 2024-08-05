import { ApiResponse } from "@/shared/api/types/response/response"
import User from "@/shared/api/models/User"

export type ApiUserResponse = ApiResponse<{
    user: User
}>
