import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";
import react from "@vitejs/plugin-react";
import vue from '@vitejs/plugin-vue';
import path from 'path';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                "resources/css/app.css",
                "resources/js/app.ts",
                "resources/js/entrypoints/tweet.ts",
                "resources/js/entrypoints/chat.ts",
                "resources/js/entrypoints/chat-echo.ts",
                "resources/js/entrypoints/development/javascript-test.ts",
                "resources/js/entrypoints/development/websocket-test.ts",
            ],
            refresh: true,
        }),
        react(),
        vue(),
    ],
    resolve: {
        alias: {
            '@': path.resolve(__dirname, 'resources/js'),
        },
    },
});
