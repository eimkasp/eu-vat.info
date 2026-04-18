<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class GenerateBotAuthKeys extends Command
{
    protected $signature = 'bot-auth:generate-keys {--force : Overwrite existing keys}';

    protected $description = 'Generate EC key pair for Web Bot Auth (/.well-known/http-message-signatures-directory)';

    public function handle(): int
    {
        $publicPath = 'bot-auth/public-key.json';

        if (Storage::disk('local')->exists($publicPath) && ! $this->option('force')) {
            $this->warn('Bot auth keys already exist. Use --force to regenerate.');

            return self::SUCCESS;
        }

        // Generate an EC P-256 key pair (recommended for HTTP Message Signatures)
        $privateKey = openssl_pkey_new([
            'curve_name' => 'prime256v1',
            'private_key_type' => OPENSSL_KEYTYPE_EC,
        ]);

        if (! $privateKey) {
            $this->error('Failed to generate EC key pair. Ensure OpenSSL extension is available.');

            return self::FAILURE;
        }

        $details = openssl_pkey_get_details($privateKey);

        // Build JWK from the EC key components
        $jwk = [
            'kty' => 'EC',
            'crv' => 'P-256',
            'x' => rtrim(strtr(base64_encode($details['ec']['x']), '+/', '-_'), '='),
            'y' => rtrim(strtr(base64_encode($details['ec']['y']), '+/', '-_'), '='),
            'kid' => 'eu-vat-info-bot-' . date('Y'),
            'use' => 'sig',
            'alg' => 'ES256',
        ];

        // Store public key as JWKS
        $jwks = ['keys' => [$jwk]];
        Storage::disk('local')->put($publicPath, json_encode($jwks, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));

        // Store private key (PEM) for signing outbound requests
        openssl_pkey_export($privateKey, $privatePem);
        Storage::disk('local')->put('bot-auth/private-key.pem', $privatePem);

        // Store private JWK (includes 'd' parameter)
        $privateJwk = array_merge($jwk, [
            'd' => rtrim(strtr(base64_encode($details['ec']['d']), '+/', '-_'), '='),
        ]);
        Storage::disk('local')->put(
            'bot-auth/private-key.json',
            json_encode($privateJwk, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES)
        );

        $this->info('Bot auth keys generated successfully.');
        $this->line("  Public JWKS: storage/app/bot-auth/public-key.json");
        $this->line("  Private key: storage/app/bot-auth/private-key.pem");
        $this->line("  Kid: {$jwk['kid']}");

        return self::SUCCESS;
    }
}
