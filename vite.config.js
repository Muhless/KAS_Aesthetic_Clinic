import tailwindcss from "@tailwindcss/vite";
import laravel from "laravel-vite-plugin";
import { defineConfig } from "vite";

export default defineConfig({
    server: {
        host: "localhost",
        watch: {
            usePolling: false,
            ignored: ["**/node_modules/**", "**/public/**", "**/storage/**"],
        },
        hmr: {
            host: "localhost",
        },
    },
    plugins: [
        laravel({
            input: ["resources/css/app.css", "resources/js/app.js"],
            refresh: true,
        }),
        tailwindcss(),
    ],
});
