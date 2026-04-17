import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";

export default defineConfig({
    plugins: [
        laravel({
            input: [
                "resources/css/app.css",
                "resources/js/app.js",
                'resources/js/appointments.js',
                'resources/js/medical-profile.js',
                'resources/js/admin.js',
                'resources/js/secretary-calendar.js',
                'resources/js/secretary-triage.js',
                'resources/js/secretary-patients.js',
                'resources/js/prescriptions.js',
                'resources/js/doctor-dashboard.js',
                'resources/js/doctor-prescribe.js',
                'resources/js/doctor-templates.js',
                'resources/js/doctor-staff-manager.js',
                'resources/js/doctor-directory.js',
                'resources/js/doctor-calendar.js',
                'resources/js/dataset-management.js',
                'resources/js/specializations.js',
                'resources/js/doctor-history.js',
            ],
            refresh: true,
        }),
    ],
});
