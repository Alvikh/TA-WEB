<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    // Get user profile
    public function show(Request $request)
    {
        $user = $request->user();
        
        return response()->json([
            'success' => true,
            'user' => $user
        ]);
    }

    // Update profile information
    public function update(Request $request)
    {
        $user = $request->user();

        $validator = Validator::make($request->all(), [
            'name' => 'sometimes|required|string|max:255',
            'phone' => 'sometimes|required|string|max:20',
            'address' => 'sometimes|required|string',
            'email' => 'sometimes|required|email|unique:users,email,'.$user->id,
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first(),
            ], 400);
        }

        $user->update($request->only(['name', 'phone', 'address', 'email']));

        return response()->json([
            'success' => true,
            'message' => 'Profile updated successfully',
            'user' => $user
        ]);
    }

    // Update password
    public function updatePassword(Request $request)
    {
        $user = $request->user();
        $validator = Validator::make($request->all(), [
            'current_password' => 'required',
            'new_password' => 'required|min:8|confirmed'
        ]);

    if ($validator->fails()) {
        return response()->json([
            'success' => false,
            'message' => $validator->errors()->first()
        ], 400);
    }
        if (!Hash::check($request->current_password, $user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Current password is incorrect',
            ], 401);
        }

        $user->update([
            'password' => Hash::make($request->new_password)
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Password updated successfully',
        ]);
    }

    // Update profile photo
    public function updatePhoto(Request $request)
{
    $user = $request->user();

     $validator = Validator::make($request->all(), [
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);


    if ($validator->fails()) {
        return response()->json([
            'success' => false,
            'message' => $validator->errors()->first(),
        ], 422);
    }

    try {
        DB::beginTransaction();

        // Delete old photo if exists
        if ($user->profile_photo_path) {
            try {
                Storage::delete($user->profile_photo_path);
            } catch (\Exception $e) {
                Log::error("Failed to delete old profile photo: " . $e->getMessage());
                // Continue with new photo upload even if old deletion fails
            }
        }

        // Store new photo with unique filename
        $file = $request->file('photo');
        $filename = 'profile-' . $user->id . '-' . time() . '.' . $file->extension();
        $path = $file->storeAs('profile-photos', $filename, 'public');

        // Update user record
        $user->update([
            'profile_photo_path' => $path
        ]);

        DB::commit();

        return response()->json([
            'success' => true,
            'message' => 'Profile photo updated successfully',
            'photo_url' => Storage::disk('public')->url($path),
            'photo_path' => $path
        ]);

    } catch (\Exception $e) {
        DB::rollBack();
        Log::error("Profile photo update failed: " . $e->getMessage());
        
        return response()->json([
            'success' => false,
            'message' => 'Failed to update profile photo. Please try again.',
        ], 500);
    }
}

    // Delete profile photo
    public function deletePhoto(Request $request)
    {
        $user = $request->user();

        if ($user->profile_photo_path) {
            Storage::delete($user->profile_photo_path);
            $user->update(['profile_photo_path' => null]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Profile photo removed successfully',
        ]);
    }
}