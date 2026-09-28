import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';
import { readFileSync, mkdirSync, cpSync, existsSync } from 'node:fs';
import { resolve, dirname } from 'node:path';

/**
 * Renders resources/images/og-default.svg to public/images/og-default.png on every
 * production build so the social preview image never drifts from its source.
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
                await sharp(readFileSync(svgPath)).png({ compressionLevel: 6 }).toFile(outPath);
            } catch (error) {
                console.warn('  ⚠ OG image generation skipped:', error.message);
            }
        },
    };
}

/**
 * Copies resources/images to public/images so static images (flags, backgrounds,
 * badges) ship with the build output.
 */
function copyImagesPlugin() {
    return {
        name: 'copy-images',
        apply: 'build',
        closeBundle() {
            const source = resolve(process.cwd(), 'resources/images');
            const destination = resolve(process.cwd(), 'public/images');

            if (existsSync(source)) {
                mkdirSync(destination, { recursive: true });
                cpSync(source, destination, { recursive: true });
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
        tailwindcss(),
        ogImagePlugin(),
        copyImagesPlugin(),
    ],
});
