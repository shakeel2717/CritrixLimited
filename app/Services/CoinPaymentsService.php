<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class CoinPaymentsService
{
    protected $apiUrl = 'https://www.coinpayments.net/api.php';
    protected $apiKey;
    protected $apiSecret;

    public function __construct()
    {
        $this->apiKey = env('COINPAYMENTS_API_KEY');
        $this->apiSecret = env('COINPAYMENTS_API_SECRET');
    }

    public function securityAtt($userId)
    {
        // Limit user to a maximum of 5 deposit transactions within a 24-hour period
        $depositLimitKey = "user_{$userId}_deposit_count";
        $depositCooldownKey = "user_{$userId}_deposit_cooldown";

        // Check if user has already exceeded the 5 deposits per day
        $depositCount = Cache::get($depositLimitKey, 0);

        if ($depositCount >= 5) {
            throw new \Exception('You have reached the maximum deposit requests (5) for today.');
        }

        // Check if the user is within the 5-minute cooldown period
        if (Cache::has($depositCooldownKey)) {
            $remainingCooldown = Cache::get($depositCooldownKey) - now()->timestamp;
            throw new \Exception("You must wait {$remainingCooldown} seconds before requesting another deposit.");
        }

        // Increment deposit count for the user
        Cache::increment($depositLimitKey);

        // Set cooldown for 5 minutes
        Cache::put($depositCooldownKey, now()->addMinutes(5)->timestamp);

        // Reset the deposit count after 1 Hour
        Cache::put($depositLimitKey, $depositCount + 1, now()->addHour());
    }

    // Create a transaction for USDT (TRC20)
    public function createTransaction($amount, $buyerEmail)
    {
        info("Creating transaction for $amount USD");

        $payload = [
            'version' => 1,
            'cmd' => 'create_transaction',
            'key' => $this->apiKey,
            'amount' => $amount,
            'currency1' => 'USD',
            'currency2' => 'USDT.TRC20',
            'buyer_email' => $buyerEmail,
            'item_name' => 'Deposit',
            'ipn_url' => route('deposit.webhook'),
        ];

        $hmacSignature = $this->createHmacSignature($payload);
        info("Transaction payload: " . json_encode($payload));
        info("HMAC Signature: $hmacSignature");

        // Send request with HMAC signature in headers
        $response = Http::withHeaders([
            'HMAC' => $hmacSignature, // CoinPayments expects the HMAC signature in the header
        ])->asForm()->post($this->apiUrl, $payload);

        if ($response->successful()) {
            info("Transaction created: " . json_encode($response->json()));
            return $response->json()['result'];
        }

        info("Transaction creation failed: " . $response->body());
        throw new \Exception('Transaction creation failed: ' . $response->body());
    }


    // Generate HMAC signature
    private function createHmacSignature($data)
    {
        info("Creating HMAC signature: " . json_encode($data));
        return hash_hmac('sha512', http_build_query($data), $this->apiSecret);
    }

    // Verify IPN Response
    public function verifyIPN($postData)
    {
        info("Verifying IPN: " . json_encode($postData));
        $hmac = hash_hmac("sha512", file_get_contents('php://input'), env('COINPAYMENTS_IPN_SECRET'));
        if ($hmac != $_SERVER['HTTP_HMAC']) {
            info('Invalid HMAC signature:');
            throw new \Exception('Invalid HMAC signature.');
        }

        if ($postData['status'] < 100) {
            info('Transaction not completed:');
        }

        return $postData;
    }
}
