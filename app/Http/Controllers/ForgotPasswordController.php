<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class ForgotPasswordController extends Controller
{
    // 1. Show email form



    public function fPassword()
    {
        try {
            return view('auth.fPassword');
        } catch (\Throwable $e) {
            Log::error('View [auth.fPassword] not found: ' . $e->getMessage());
            abort(500, 'View error: ' . $e->getMessage());
        }
    }

    // 2. Process email verification
    public function verifyEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()->withErrors(['email' => 'Email not found.'])->withInput();
        }

        // Go to reset password form, passing user id
        return redirect()->route('auth.reset-password', ['user' => $user->id]);
    }

    // 3. Show reset password form
    public function showResetForm($userId)
    {
        return view('auth.reset-password', ['user_id' => $userId]);
    }

    // 4. Save new password
    public function submitResetPassword(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'password' => 'required|confirmed|min:8',
        ]);

        $user = User::find($request->user_id);
        $user->password = Hash::make($request->password);
        $user->save();

        return redirect()->route('login')->with('success', 'Password reset successfully! Please login.');
    }
}
