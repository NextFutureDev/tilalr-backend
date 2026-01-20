<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Client\PendingRequest;

/**
 * Taqnyat SMS Service
 * 
 * Integrates with Taqnyat.sa SMS API for sending OTP and other SMS messages.
 * 
 * API Documentation: https://api.taqnyat.sa/
 * 
 * Configuration required in .env:
 * - TAQNYAT_BEARER_TOKEN: Your API bearer token from Taqnyat dashboard
 * - TAQNYAT_SENDER: Your approved sender name
 */
class TaqnyatSmsService
{
    protected string $baseUrl = 'https://api.taqnyat.sa';
    protected ?string $bearerToken;
    protected ?string $sender;

    public function __construct()
    {
        $this->bearerToken = config('services.taqnyat.bearer_token');
        $this->sender = config('services.taqnyat.sender');
    }

    /**
     * Create HTTP client with proper headers and SSL config
     */
    protected function httpClient(bool $withAuth = true): PendingRequest
    {
        $headers = ['Accept' => 'application/json'];
        
        if ($withAuth && $this->bearerToken) {
            $headers['Authorization'] = 'Bearer ' . $this->bearerToken;
            $headers['Content-Type'] = 'application/json';
        }
        
        $http = Http::withHeaders($headers);
        
        // Disable SSL verification in local development (XAMPP has SSL issues)
        if (app()->environment('local')) {
            $http = $http->withoutVerifying();
        }
        
        return $http;
    }

    /**
     * Send SMS message to one or more recipients
     *
     * @param string|array $recipients Phone number(s) in international format without 00 or +
     * @param string $message The message content
     * @param string|null $scheduledDatetime Optional scheduled time (format: 2020-09-30T14:26)
     * @return array Response with success status and details
     */
    public function send(string|array $recipients, string $message, ?string $scheduledDatetime = null): array
    {
        if (!$this->bearerToken || !$this->sender) {
            Log::error('Taqnyat SMS: Missing configuration', [
                'has_token' => !empty($this->bearerToken),
                'has_sender' => !empty($this->sender),
            ]);
            return [
                'success' => false,
                'message' => 'SMS service not configured properly.',
                'error' => 'Missing TAQNYAT_BEARER_TOKEN or TAQNYAT_SENDER',
            ];
        }

        // Normalize recipients to array
        if (is_string($recipients)) {
            $recipients = [$recipients];
        }

        // Format phone numbers (remove + and 00 prefix if present)
        $formattedRecipients = array_map(function ($phone) {
            return $this->formatPhoneNumber($phone);
        }, $recipients);

        try {
            $payload = [
                'recipients' => $formattedRecipients,
                'body' => $message,
                'sender' => $this->sender,
            ];

            if ($scheduledDatetime) {
                $payload['scheduledDatetime'] = $scheduledDatetime;
            }

            $response = $this->httpClient()->post($this->baseUrl . '/v1/messages', $payload);

            $data = $response->json();
            $statusCode = $response->status();

            Log::info('Taqnyat SMS Response', [
                'status_code' => $statusCode,
                'response' => $data,
                'recipients' => $formattedRecipients,
            ]);

            if ($statusCode === 201) {
                return [
                    'success' => true,
                    'message' => 'SMS sent successfully',
                    'message_id' => $data['messageId'] ?? null,
                    'cost' => $data['cost'] ?? null,
                    'currency' => $data['currency'] ?? 'SAR',
                    'total_count' => $data['totalCount'] ?? count($formattedRecipients),
                    'accepted' => $data['accepted'] ?? [],
                    'rejected' => $data['rejected'] ?? [],
                ];
            }

            // Handle specific error codes
            return $this->handleError($statusCode, $data);

        } catch (\Throwable $e) {
            Log::error('Taqnyat SMS Exception', [
                'error' => $e->getMessage(),
                'recipients' => $formattedRecipients,
            ]);

            return [
                'success' => false,
                'message' => 'Failed to send SMS: ' . $e->getMessage(),
                'error' => $e->getMessage(),
            ];
        }
    }

    /**
     * Check account balance
     *
     * @return array Account balance information
     */
    public function getBalance(): array
    {
        if (!$this->bearerToken) {
            return [
                'success' => false,
                'message' => 'Bearer token not configured',
            ];
        }

        try {
            $response = $this->httpClient()->get($this->baseUrl . '/account/balance');

            $data = $response->json();

            if ($response->status() === 200) {
                return [
                    'success' => true,
                    'status' => $data['accountStatus'] ?? 'unknown',
                    'balance' => $data['balance'] ?? '0',
                    'currency' => $data['currency'] ?? 'SAR',
                    'expiry_date' => $data['accountExpiryDate'] ?? null,
                ];
            }

            return [
                'success' => false,
                'message' => $data['message'] ?? 'Failed to get balance',
            ];

        } catch (\Throwable $e) {
            Log::error('Taqnyat Balance Check Exception', ['error' => $e->getMessage()]);
            return [
                'success' => false,
                'message' => 'Failed to check balance: ' . $e->getMessage(),
            ];
        }
    }

    /**
     * Get list of active sender names
     *
     * @return array List of sender names
     */
    public function getSenders(): array
    {
        if (!$this->bearerToken) {
            return [
                'success' => false,
                'message' => 'Bearer token not configured',
            ];
        }

        try {
            $response = $this->httpClient()->get($this->baseUrl . '/v1/messages/senders');

            $data = $response->json();

            if ($response->status() === 201 || $response->status() === 200) {
                return [
                    'success' => true,
                    'senders' => $data['senders'] ?? [],
                ];
            }

            return [
                'success' => false,
                'message' => $data['message'] ?? 'Failed to get senders',
            ];

        } catch (\Throwable $e) {
            Log::error('Taqnyat Get Senders Exception', ['error' => $e->getMessage()]);
            return [
                'success' => false,
                'message' => 'Failed to get senders: ' . $e->getMessage(),
            ];
        }
    }

    /**
     * Check system status
     *
     * @return array System status
     */
    public function getSystemStatus(): array
    {
        try {
            $response = $this->httpClient(false)->get($this->baseUrl . '/system/status');

            $data = $response->json();

            if ($response->status() === 200) {
                return [
                    'success' => true,
                    'status' => $data['status'] ?? [],
                ];
            }

            return [
                'success' => false,
                'message' => $data['message'] ?? 'System status check failed',
            ];

        } catch (\Throwable $e) {
            return [
                'success' => false,
                'message' => 'Failed to check system status: ' . $e->getMessage(),
            ];
        }
    }

    /**
     * Delete a scheduled message
     *
     * @param string $deleteId The message ID to delete
     * @return array Result
     */
    public function deleteScheduledMessage(string $deleteId): array
    {
        if (!$this->bearerToken) {
            return [
                'success' => false,
                'message' => 'Bearer token not configured',
            ];
        }

        try {
            $response = $this->httpClient()->delete($this->baseUrl . '/v1/messages/delete', [
                'deleteId' => $deleteId,
            ]);

            $data = $response->json();

            if ($response->status() === 201) {
                return [
                    'success' => true,
                    'message' => 'Message deleted successfully',
                ];
            }

            return [
                'success' => false,
                'message' => $data['message'] ?? 'Failed to delete message',
            ];

        } catch (\Throwable $e) {
            return [
                'success' => false,
                'message' => 'Failed to delete message: ' . $e->getMessage(),
            ];
        }
    }

    /**
     * Format phone number to international format without + or 00
     * Taqnyat requires format: 966500000000
     *
     * @param string $phone Phone number in any format
     * @return string Formatted phone number
     */
    protected function formatPhoneNumber(string $phone): string
    {
        // Remove all non-digit characters
        $digits = preg_replace('/\D/', '', $phone);

        // Remove leading zeros
        $digits = ltrim($digits, '0');

        // If starts with 5 and is 9 digits (Saudi local), add 966
        if (preg_match('/^5\d{8}$/', $digits)) {
            return '966' . $digits;
        }

        // If already has country code, return as-is
        return $digits;
    }

    /**
     * Handle API error responses
     *
     * @param int $statusCode HTTP status code
     * @param array $data Response data
     * @return array Error response
     */
    protected function handleError(int $statusCode, array $data): array
    {
        $message = $data['message'] ?? 'Unknown error';

        $errorMessages = [
            401 => 'Invalid credentials. Please check your bearer token.',
            405 => 'Method not allowed.',
            400 => $this->translateErrorMessage($message),
        ];

        return [
            'success' => false,
            'message' => $errorMessages[$statusCode] ?? $message,
            'status_code' => $statusCode,
            'error' => $message,
        ];
    }

    /**
     * Translate common Taqnyat error messages to user-friendly messages
     *
     * @param string $error Error message from API
     * @return string Translated error message
     */
    protected function translateErrorMessage(string $error): string
    {
        $translations = [
            'Your balance is 0' => 'SMS service temporarily unavailable. Please try again later.',
            'Your balance is not enough' => 'SMS service temporarily unavailable. Please try again later.',
            'Sender Name is not accepted' => 'SMS configuration error. Please contact support.',
            'Sender Name not active' => 'SMS configuration error. Please contact support.',
            'Sender Name is expierd' => 'SMS configuration error. Please contact support.',
            'sending by API is disabled' => 'SMS service is disabled. Please contact support.',
        ];

        return $translations[$error] ?? $error;
    }

    /**
     * Test the SMS configuration by checking balance
     *
     * @return array Test result
     */
    public function test(): array
    {
        $status = $this->getSystemStatus();
        $balance = $this->getBalance();
        $senders = $this->getSenders();

        return [
            'configured' => !empty($this->bearerToken) && !empty($this->sender),
            'bearer_token_set' => !empty($this->bearerToken),
            'sender_set' => !empty($this->sender),
            'sender_name' => $this->sender,
            'system_status' => $status,
            'account_balance' => $balance,
            'available_senders' => $senders,
        ];
    }
}
