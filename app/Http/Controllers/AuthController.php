<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;
use App\Models\User;
use App\Services\TokenService;

class AuthController extends Controller
{
    //
    protected $tokenService;
 
    function __construct() {
        parent::__construct();
    }

    public function login(Request $request){
        $this->validator = Validator::make($request->all(), [
            'email' => 'required|email|max:255|exists:users',
            'password' => ['required',Password::min(8)->letters()->mixedCase()->numbers()],
        ]);
        $this->res['data'] = null;
        if($this->checkAndGetErrors()) {

            $user = User::where('email',$request->email)->first();
            $current_user=$user->attributesToArray();
        
            if (!empty($user) && Hash::check($request->password,$user->getAuthPassword())) {
                $token = $this->tokenService->generateToken($current_user['id']);
                $user->authorization_token = compact('token');
                $this->res['status'] = true;
                $this->res['message'] = "You're logged in successfully.";
                $this->res['data'] = new UserResource($current_user);
            }else{
                $this->res["message"] = "Invalid credentials";
                $this->res['status_code']=401;
            }
        }
        return response()->json($this->res, $this->res['status_code']);
    }

    public function register(Request $request){
        $this->validator = Validator::make($request->all(), [
            'name' => 'required|string|min:2|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => ['required',Password::min(8)->letters()->mixedCase()->numbers()],
            'password_confirmation' => 'required|same:password',
        ]);

        if($this->checkAndGetErrors()) {
            $characters ="0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz";
            $emailtoken = substr(str_shuffle($characters), 0, 64);
            $user = User::create([
                "name" => $request->name,
                "email" => $request->email,
                "password" => Hash::make($request->password),
            ]);
            
            $this->res['status'] = true;
            $this->res['message'] = "Your account has been created successfully.You can login Now !";
        }
        return response()->json($this->res,$this->res['status_code']);

    }

    public function emailVerify(){

    }

    public function resetPass(){

    }

    public function forgotPass(){

    }

    public function logout(){

    }

    public function refreshToken(){

    }

    public function VerifyEmail($token){

    }

    public function ResendEmail($user_id){

    }

    // function generateToken($userId) {
    //     // Payload preparation (replace with your actual data)
    //     $payload = [
    //       'user_id' => $userId,
    //       // Add other user data as needed
    //     ];
      
    //     // Encode payload (base64url)
    //     $encodedPayload = base64url_encode(json_encode($payload));
      
    //     // Generate random secret key (replace with secure key storage)
    //     $secretKey = env('APP_KEY');
      
    //     // Generate signature (SHA-256)
    //     $signature = hash_hmac('sha256', $encodedPayload, $secretKey);

    //     // Base64url encode signature for compatibility with bearer tokens
    //     $encodedSignature = base64url_encode($signature);

    //     // Combine token parts
    //     $token = 'Bearer ' . $encodedPayload . '.' . $encodedSignature;
      
    //     // Optional Encryption (not implemented here for brevity)
    //     return $token;
    // }
}