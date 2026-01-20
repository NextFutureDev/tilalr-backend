<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;

/**
 * SMS Service - Unified SMS sending service
 * 
 * Supports multiple providers:
 * - taqnyat: Taqnyat.sa Saudi SMS provider (recommended for Saudi Arabia)
 * - twilio: Twilio (international)
 * - log: Development mode (just logs messages)
 * 
 * Set SMS_PROVIDER in .env to switch providers
 */
class SmsService
{
    protected string $provider;
    protected ?TaqnyatSmsService $taqnyatService = null;

    public function __construct()
    {
        $this->provider = config('services.sms.provider', 'log');
    }

    /**
     * Send SMS message
     *
     * @param string $phone Phone number
     * @param string $message Message content
     * @return bool Success status
     */
    public function send(string $phone, string $message): bool
    {
        Log::info("SMS send request", [
            'provider' => $this->provider,
            'phone' => $phone,
            'message_length' => strlen($message),
        ]);

        return match ($this->provider) {
            'taqnyat' => $this->sendViaTaqnyat($phone, $message),
            'twilio' => $this->sendViaTwilio($phone, $message),
            default => $this->logOnly($phone, $message),
        };
    }

    /**
     * Send via Taqnyat.sa
     */
    protected function sendViaTaqnyat(string $phone, string $message): bool
    {
        if (!$this->taqnyatService) {
            $this->taqnyatService = app(TaqnyatSmsService::class);
        }

        $result = $this->taqnyatService->send($phone, $message);

        if ($result['success']) {
            Log::info('Taqnyat SMS sent successfully', [
                'phone' => $phone,
                'message_id' => $result['message_id'] ?? null,
                'cost' => $result['cost'] ?? null,
            ]);
            return true;
        }

        Log::error('Taqnyat SMS failed', [
            'phone' => $phone,
            'error' => $result['message'] ?? 'Unknown error',
        ]);

        // Fallback to log mode on failure so OTP can still be seen
        $this->logOnly($phone, $message);
        return false;
    }

    /**
     * Send via Twilio
     */
    protected function sendViaTwilio(string $phone, string $message): bool
    {
        $sid = config('services.twilio.sid');
        $token = config('services.twilio.token');
        $from = config('services.twilio.from');

        if ($sid && $token && $from) {
            try {
                $client = new \Twilio\Rest\Client($sid, $token);
                $client->messages->create($phone, [
                    'from' => $from,
                    'body' => $message,
                ]);
                Log::info('Twilio SMS sent successfully', ['phone' => $phone]);
                return true;
            } catch (\Throwable $e) {
                Log::warning('Twilio send failed: ' . $e->getMessage());
            }
        }

        // Fallback to log mode
        return $this->logOnly($phone, $message);
    }

    /**
     * Log only mode (development)
     */
    protected function logOnly(string $phone, string $message): bool
    {
        Log::info("📱 SMS [DEV MODE] To: {$phone}", [
            'message' => $message,
            'provider' => 'log',
        ]);
        return true;
    }

    /**
     * Get the current SMS provider
     */
    public function getProvider(): string
    {
        return $this->provider;
    }

    /**
     * Check if real SMS is enabled (not log mode)
     */
    public function isRealSmsEnabled(): bool
    {
        return $this->provider !== 'log';
    }

    /**
     * Get Taqnyat service for direct access (balance check, etc.)
     */
    public function getTaqnyatService(): TaqnyatSmsService
    {
        if (!$this->taqnyatService) {
            $this->taqnyatService = app(TaqnyatSmsService::class);
        }
        return $this->taqnyatService;
    }
}
