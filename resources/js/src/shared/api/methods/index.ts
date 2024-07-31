import { auth } from "@/shared/api/methods/auth"
import { users } from "@/shared/api/methods/users"
import { session } from "@/shared/api/methods/session"

export const api = {
    session: session,
    auth: auth,
    users: users,
}
