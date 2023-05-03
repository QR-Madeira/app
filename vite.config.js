import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

import { networkInterfaces } from "node:os";

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
    ],
    server: {
        host: ip(),
        cors: true,
    },
});

/**
 * Tries to find your local IP address and fallbacks to localhost (127.0.0.1).
 *
 * @summary Return your IP address.
 *
 * @function ip
 *
 * @return {string} A possible IP address that can be used.
 *
 * @package
 * @ignore
 */
function ip() {
    const ifaces = networkInterfaces();

    for (const iface in ifaces) {
        /*
         * Normaly interface's name starts with "e" or "w" depending if it is;
         * ethernet or wireless.
         */
        if (iface.startsWith("e") || iface.startsWith("w")) {
            for (const i of ifaces[iface]) {
                if (i.family === "IPv4") {
                    return i.address;
                }
            }
        }
    }

    return "127.0.0.1";
}
