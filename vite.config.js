import { defineConfig } from "vite"
import laravel from "laravel-vite-plugin"
import vue from "@vitejs/plugin-vue"
import { fileURLToPath } from "node:url"

export default defineConfig({
    plugins: [
        vue(),
        laravel({
            input: ["resources/js/app.ts"],
            refresh: true,
        }),
    ],
    resolve: {
        alias: [
            {
                find: "@",
                replacement: fileURLToPath(new URL("./resources/js/src/", import.meta.url))
            }
        ]
    }
})
