<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Models\RefreshToken;
use App\Mail\VerificationEmail;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    protected function createRefreshToken(User $user)
    {
        $user->refreshTokens()->delete();
        return $user->refreshTokens()->create([
            'token' => Str::random(60),
            'expires_at' => now()->addDays(7),
        ]);
    }

    public function register(Request $request)
    {
        Log::info('Register request payload:', $request->all());

        $validator = Validator::make($request->all(), [
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'password_confirmation' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first(),
            ], 400);
        }

        $user = User::create([
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'name'     => null,
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'success' => true,
            'message' => 'Register tahap 1 berhasil',
            'token'   => $token,
            'user'    => $user,
        ]);
    }

    public function completeProfile(Request $request)
    {
        Log::info('Request', ['all' => $request]);

        $user = $request->user();

        $validator = Validator::make($request->all(), [
            'name'    => 'required|string|max:255',
            'phone'   => 'required|string|max:20',
            'address' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first(),
            ], 400);
        }

        $user->update([
            'name'    => $request->name,
            'phone'   => $request->phone,
            'address' => $request->address,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Profil berhasil diperbarui',
            'user'    => $user,
        ]);
    }

    public function refresh(Request $request)
    {
        $user = $request->user();

        $token = $user->createToken('auth_token', ['*'], now()->addDays(7))->plainTextToken;
        $this->createRefreshToken($user);

        $user->update(['last_login_at' => now()]);

        return response()->json([
            'success' => true,
            'message' => 'Login berhasil',
            'token'   => $token,
            'user'    => $user,
        ]);
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first(),
            ], 400);
        }

        $user = User::where('email', $request->email)->with('devices')->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Email atau password salah',
            ], 401);
        }

        $token = $user->createToken('auth_token', ['*'], now()->addDays(7))->plainTextToken;
        $refreshToken = $this->createRefreshToken($user);

        $user->update(['last_login_at' => now()]);

        return response()->json([
            'success' => true,
            'message' => 'Login berhasil',
            'token'   => $token,
            'refresh_token' => $refreshToken->token,
            'user'    => $user,
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'success' => true,
            'message' => 'Logout berhasil',
        ]);
    }

    public function user(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first(),
            ], 400);
        }

        $user = User::with('devices')->find($request->user_id);

        return response()->json([
            'success' => true,
            'user'    => $user,
        ]);
    }

    public function refreshToken(Request $request)
    {
        $request->validate([
            'refresh_token' => 'required',
        ]);

        $refreshToken = RefreshToken::where('token', $request->refresh_token)
            ->where('expires_at', '>', now())
            ->first();

        if (!$refreshToken) {
            return response()->json([
                'success' => false,
                'message' => 'Refresh token tidak valid atau sudah kadaluarsa',
            ], 401);
        }

        $user = $refreshToken->user;

        $user->tokens()->delete();
        $token = $user->createToken('auth_token', ['*'], now()->addDays(7))->plainTextToken;
        $newRefreshToken = $this->createRefreshToken($user);

        return response()->json([
            'success' => true,
            'token'   => $token,
            'refresh_token' => $newRefreshToken->token,
        ]);
    }

    public function sendVerificationCode(Request $request)
    {
        $user = User::where('email', $request->email)->first();

        $code = str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT);
        $expiresAt = now()->addMinutes(15);

        $user->update([
            'verification_code' => $code,
            'verification_code_expires_at' => $expiresAt,
        ]);

        Mail::to($user->email)->send(new VerificationEmail($code));

        return response()->json([
            'success' => true,
            'message' => 'Verification code sent to your email',
            'expires_at' => $expiresAt->toDateTimeString(),
        ]);
    }

    public function verifyEmail(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'code' => 'required|digits:6',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first(),
            ], 400);
        }

        $user = $request->user();

        if ($user->email_verified_at) {
            return response()->json([
                'success' => false,
                'message' => 'Email already verified',
            ], 400);
        }

        if ($user->verification_code !== $request->code) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid verification code',
            ], 400);
        }

        if (now()->gt($user->verification_code_expires_at)) {
            return response()->json([
                'success' => false,
                'message' => 'Verification code expired',
            ], 400);
        }

        $user->update([
            'email_verified_at' => now(),
            'verification_code' => null,
            'verification_code_expires_at' => null,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Email successfully verified',
            'user'    => $user,
        ]);
    }

    public function checkVerificationStatus(Request $request)
    {
        $user = $request->user();

        return response()->json([
            'success' => true,
            'is_verified' => !is_null($user->email_verified_at),
        ]);
    }
}
