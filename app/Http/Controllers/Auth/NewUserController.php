<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Models\User;
use Illuminate\Support\Str;

class NewUserController extends Controller
{
    public function showForm() {
        return view('auth.new-user');
    }

    public function sendTemporaryPassword(Request $request) {
        Log::info('New user request received', ['email' => $request->email]);

        $request->validate([
        'email' => 'required|email',
    ]);

    $user = User::where('email', $request->email)->first();

    if (!$user) {
        return back()->with('status', 'Email not found.');
    }

    $temporaryPassword = Str::random(10);

    $user->password = Hash::make($temporaryPassword);
    $user->force_password_change = true;
    $user->save();

    // Optionally email the password (only for demo, not secure for production)
    Mail::raw("Your temporary password is: $temporaryPassword", function ($message) use ($user) {
        $message->to($user->email)
                ->subject('Your Temporary Password');
    });

    dd('form submitted');
    
    return redirect()->route('login')->with('status', 'Temporary password sent to your email.');
    }
}
