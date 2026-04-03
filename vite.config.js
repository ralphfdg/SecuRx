import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";

export default defineConfig({
    plugins: [
        laravel({
            input: [
                "resources/css/app.css",
                "resources/js/app.js",
                "resources/js/scanner.js",
                "resources/js/calendar.js",
                "resources/js/analytics.js",
                "resources/js/dictation.js",
                'resources/js/appointments.js',
            ],
            refresh: true,
        }),
    ],
});
