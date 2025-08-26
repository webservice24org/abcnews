<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class GenerateLicense extends Command
{
    protected $signature = 'license:generate {domain} {--days=365}';
    protected $description = 'Generate a signed license file for a client domain';

    // 🔐 Keep this secret safe in YOUR project only
    private $secretKey = 'b5e74505dd32272c8a65ff60fd6e7c8c2db43c7f279b305071fdc498277d4d49';
   

    public function handle()
    {
        $domain = $this->argument('domain');
        $days   = (int) $this->option('days');

        // 🛠 Normalize domain: remove protocol + trailing slash
        $domain = preg_replace('#^https?://#', '', $domain);
        $domain = rtrim($domain, '/');

        $issuedAt  = now()->toDateString();
        $expiresAt = now()->addDays($days)->toDateString();

        $data = [
            'domain'     => $domain,
            'issued_at'  => $issuedAt,
            'expires_at' => $expiresAt,
        ];

        // 🔏 Sort keys before signing
        ksort($data);

        // 🔏 Create signature with stable encoding
        $signature = hash_hmac(
            'sha256',
            json_encode($data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE),
            $this->secretKey
        );

        $data['signature'] = $signature;

        $filename = "license_{$domain}.json";
        $path     = public_path($filename);

        // Save with pretty print (for humans), but stable format for validator
        file_put_contents(
            $path,
            json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE)
        );

        $this->info("✅ License file generated: public/{$filename}");
    }
}
