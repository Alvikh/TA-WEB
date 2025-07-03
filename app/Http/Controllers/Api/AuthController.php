<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Support\Str;
use App\Models\RefreshToken;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    protected function createRefreshToken(User $user)
    {
        // Delete old refresh tokens
        $user->refreshTokens()->delete();

        // Create new refresh token
        return $user->refreshTokens()->create([
            'token' => Str::random(60),
            'expires_at' => now()->addDays(7)
        ]);
    }
    // Tahap 1: Register dengan email dan password
    public function register(Request $request)
    {
        Log::info('Request', [

    'all' => $request]);
        $validator = Validator::make($request->all(), [
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:6',
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
            'user'=>$user
        ]);
    }

    // Tahap 2: Lengkapi informasi akun
    public function completeProfile(Request $request)
    {
        Log::info('Request', [
    'all' => $request]);
        $user = $request->user(); // pengguna saat ini dari token

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
            'user'=>$user
        ]);
    }

    // Login
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

        $token = $user->createToken('auth_token', ['*'], now()->addDay(7))->plainTextToken;
        $this->createRefreshToken($user);
$user->update([
            'last_login_at' => now(),
        ]);
        return response()->json([
            'success' => true,
            'message' => 'Login berhasil',
            'token'   => $token,
            'user'=>$user
        ]);
    }

    // Logout
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'success' => true,
            'message' => 'Logout berhasil',
        ]);
    }

    // Get user info
    public function user(Request $request)
    {
        return response()->json([
            'success' => true,
            'user'    => $request->user(),
        ]);
    }
    

    public function refreshToken(Request $request)
    {
        $request->validate([
            'refresh_token' => 'required'
        ]);

        $refreshToken = RefreshToken::where('token', $request->refresh_token)
            ->where('expires_at', '>', now())
            ->first();

        if (!$refreshToken) {
            return response()->json([
                'success' => false,
                'message' => 'Refresh token tidak valid atau sudah kadaluarsa'
            ], 401);
        }

        $user = $refreshToken->user;

        // Revoke all old access tokens
        $user->tokens()->delete();

        // Create new access token
        $token = $user->createToken('auth_token', ['*'], now()->addDay(7))->plainTextToken;

        // Create new refresh token (optional: rotate refresh token)
        $newRefreshToken = $this->createRefreshToken($user);

        return response()->json([
            'success' => true,
            'token' => $token,
            'refresh_token' => $newRefreshToken->token
        ]);
    }
}
