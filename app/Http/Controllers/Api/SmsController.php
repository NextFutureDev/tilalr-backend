<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\SmsService;
use App\Services\TaqnyatSmsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

/**
 * SMS Controller - Testing and debugging SMS integration
 * 
 * Provides endpoints to test SMS configuration and send test messages.
 * These endpoints should be protected in production!
 */
class SmsController extends Controller
{
    protected SmsService $smsService;
    protected TaqnyatSmsService $taqnyatService;

    public function __construct(SmsService $smsService, TaqnyatSmsService $taqnyatService)
    {
        $this->smsService = $smsService;
        $this->taqnyatService = $taqnyatService;
    }

    /**
     * Get SMS configuration status
     * GET /api/sms/status
     */
    public function status()
    {
        $taqnyatTest = $this->taqnyatService->test();
        
        return response()->json([
            'success' => true,
            'sms_provider' => $this->smsService->getProvider(),
            'real_sms_enabled' => $this->smsService->isRealSmsEnabled(),
            'otp_mode' => config('otp.mode'),
            'taqnyat' => [
                'configured' => $taqnyatTest['configured'],
                'bearer_token_set' => $taqnyatTest['bearer_token_set'],
                'sender_set' => $taqnyatTest['sender_set'],
                'sender_name' => $taqnyatTest['sender_name'],
            ],
        ]);
    }

    /**
     * Check Taqnyat system status (no auth required by Taqnyat)
     * GET /api/sms/taqnyat/system
     */
    public function taqnyatSystem()
    {
        $status = $this->taqnyatService->getSystemStatus();
        return response()->json($status);
    }

    /**
     * Check Taqnyat account balance
     * GET /api/sms/taqnyat/balance
     */
    public function taqnyatBalance()
    {
        $balance = $this->taqnyatService->getBalance();
        return response()->json($balance);
    }

    /**
     * Get available sender names from Taqnyat
     * GET /api/sms/taqnyat/senders
     */
    public function taqnyatSenders()
    {
        $senders = $this->taqnyatService->getSenders();
        return response()->json($senders);
    }

    /**
     * Send a test SMS
     * POST /api/sms/test
     * 
     * Body: { "phone": "966500000000", "message": "Test message" }
     */
    public function sendTest(Request $request)
    {
        $request->validate([
            'phone' => 'required|string',
            'message' => 'nullable|string|max:500',
        ]);

        $phone = $request->phone;
        $message = $request->message ?? 'This is a test message from Tilal Rimal. رسالة اختبارية من تلال الرمال';

        Log::info('SMS test send request', [
            'phone' => $phone,
            'provider' => $this->smsService->getProvider(),
        ]);

        // Use the configured SMS provider
        $success = $this->smsService->send($phone, $message);

        return response()->json([
            'success' => $success,
            'message' => $success ? 'Test SMS sent successfully' : 'Failed to send test SMS',
            'provider' => $this->smsService->getProvider(),
            'phone' => $phone,
        ]);
    }

    /**
     * Send a test SMS directly via Taqnyat (bypasses SMS provider config)
     * POST /api/sms/taqnyat/send
     * 
     * Body: { "phone": "966500000000", "message": "Test message" }
     */
    public function taqnyatSend(Request $request)
    {
        $request->validate([
            'phone' => 'required|string',
            'message' => 'nullable|string|max:500',
        ]);

        $phone = $request->phone;
        $message = $request->message ?? 'This is a test message from Tilal Rimal. رسالة اختبارية من تلال الرمال';

        $result = $this->taqnyatService->send($phone, $message);

        return response()->json($result);
    }

    /**
     * Full Taqnyat integration test
     * GET /api/sms/taqnyat/test
     */
    public function taqnyatFullTest()
    {
        return response()->json($this->taqnyatService->test());
    }
}
