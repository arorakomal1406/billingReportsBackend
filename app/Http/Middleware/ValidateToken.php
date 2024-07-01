<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ValidateToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $authorization = $request->header('Authorization');

        if (empty($authorization) || !starts_with($authorization, 'Bearer ')) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        list($bearer, $token) = explode(' ', $authorization, 2);  // Split token parts

        // Token structure validation
        $expectedParts = 2;  // Encoded payload . Signature
        if (count(explode('.', $token)) !== $expectedParts) {
            return response()->json(['error' => 'Invalid token format'], 401);
        }

        // Generate signature based on received encoded payload
        $encodedPayload = $token;  // Assuming first part is encoded payload

        // Retrieve secret key from secure environment variable
        $secretKey = env('APP_KEY');  

        $expectedSignature = hash_hmac('sha256', $encodedPayload, $secretKey, true);  // Raw binary output
        $expectedSignature = base64url_encode($expectedSignature);  // Encode for comparison

        // Compare generated signature with received signature
        if ($expectedSignature !== $token) {
            return response()->json(['error' => 'Invalid token signature'], 401);
        }

        // Access user data or permissions from $encodedPayload (replace with your logic)

        return $next($request);
    }
}