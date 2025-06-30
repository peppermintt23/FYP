<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


class PasswordChangeController extends Controller
{
    public function showForm() {
        return view('auth.change-password');
    }

    public function change(Request $request) {
        $request->validate([
            'password' => 'required|string|min:8|confirmed'
        ]);

        $user = auth()->user();
        $user->password = Hash::make($request->password);
        $user->force_password_change = false;
        

        return redirect('/dashboard')->with('status', 'Password changed successfully.');
    }
}
