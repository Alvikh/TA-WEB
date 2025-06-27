<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\LoginAttempt;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthControllerWEB extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

return redirect()->route('login')->with('success', 'akun berhasil dibuat!');
    }

public function login(Request $request)
{
    $attempt = LoginAttempt::create([
        'email' => $request->email,
        'ip_address' => $request->ip(),
        'successful' => false,
        'user_id' => null
    ]);

    // Validasi
    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    // Cek user
    if (!Auth::attempt($request->only('email', 'password'))) {
        return redirect()->route('login')->with('error', 'password salah!');

    }
 $attempt->update([
            'successful' => true,
            'user_id' => Auth::id()
        ]);
$user = Auth::user();
if ($user instanceof \App\Models\User) {
    $user->last_login_at = now();
    $user->save();
}
    return redirect()->route('admin.dashboard')->with('success', 'login berhasil');
}

    public function user(Request $request)
    {
        return response()->json($request->user());
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json(['message' => 'Logout berhasil']);
    }
}

