import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import { readFileSync, mkdirSync } from 'fs';
import { resolve, dirname } from 'path';

/**
 * Vite plugin — converts resources/images/og-default.svg → public/images/og-default.png
 * during every production build so the OG image stays up-to-date automatically.
 */
function ogImagePlugin() {
    return {
        name: 'og-image',
        apply: 'build',
        async closeBundle() {
            try {
                const sharp = (await import('sharp')).default;
                const svgPath = resolve(process.cwd(), 'resources/images/og-default.svg');
                const outPath = resolve(process.cwd(), 'public/images/og-default.png');

                mkdirSync(dirname(outPath), { recursive: true });

                await sharp(readFileSync(svgPath))
                    .png({ compressionLevel: 6 })
                    .toFile(outPath);

                console.log('  ✓ OG image → public/images/og-default.png');
            } catch (err) {
                console.warn('  ⚠ OG image generation skipped:', err.message);
            }
        },
    };
}

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
        ogImagePlugin(),
    ],
});
