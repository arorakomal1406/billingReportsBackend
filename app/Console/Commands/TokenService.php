<?php

namespace App\Services;

class TokenService
{
    public function generateToken($userId)
    {

        print_r($userId);
        die();

        // Payload preparation (replace with your actual data)
        $payload = [
            'user_id' => $userId,
            // Add other user data as needed
        ];

        // Encode payload (base64url)
        $encodedPayload = $this->base64url_encode(json_encode($payload));

        // Generate random secret key (replace with secure key storage)
        $secretKey = env('APP_KEY');

        // Generate signature (SHA-256)
        $signature = hash_hmac('sha256', $encodedPayload, $secretKey);

        // Base64url encode signature for compatibility with bearer tokens
        $encodedSignature = $this->base64url_encode($signature);

        // Combine token parts
        $token = 'Bearer ' . $encodedPayload . '.' . $encodedSignature;

        // Optional Encryption (not implemented here for brevity)

        return $token;
    }

    // Helper function for base64url encoding
    private function base64url_encode($data)
    {
        return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
    }
}
