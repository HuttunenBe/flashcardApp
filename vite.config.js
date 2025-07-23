import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";
import react from "@vitejs/plugin-react";

export default defineConfig({
    plugins: [
        laravel({
          input: ['resources/css/style.css', 'resources/js/app.jsx'],
            refresh: true,
        }),
        react(),
    ],
server: {
    host: "localhost",
    port: 3000,
    strictPort: true,
    hmr: {
        host: "localhost",
        protocol: "http",
        port: 3000,
    },
},

});
