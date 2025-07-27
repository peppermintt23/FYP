@extends('layouts.guest')
@section('content')

    <div class="absolute top-4 left-4">
        <a class="underline text-sm text-cyan-300 hover:text-white font-semibold" href="/">
            {{ __('← Back') }}
        </a>
    </div>
    <h2 class="text-2xl text-cyan-300 font-bold mb-8 text-center tracking-widest">Forgot Password</h2>
    <form method="POST" action="{{ route('auth.fPassword.verify') }}">
        @csrf
        <div class="mb-6">
            <input
                type="email"
                name="email"
                class="w-full px-5 py-3 neon-input border-2 border-cyan-400 rounded-xl bg-[#050e1a] text-cyan-100 placeholder-cyan-400 focus:ring-2 focus:ring-cyan-400 focus:outline-none"
                placeholder="Enter your email"
                value="{{ old('email') }}"
                required
                autocomplete="email"
            >
            @error('email')
                <span class="text-red-400 text-xs mt-2 block">{{ $message }}</span>
            @enderror
        </div>
        <button
            type="submit"
            class="w-full bg-gradient-to-r from-cyan-400 to-blue-700 text-[#101b2a] font-bold px-6 py-3 rounded-xl shadow neon-btn hover:from-blue-500 hover:to-cyan-300 hover:text-white transition"
        >
            Verify Email
        </button>
    </form>


<style>
    .neon-frame {
        border: 2.5px solid #15f7fc;
        box-shadow:
            0 0 18px 4px #15f7fc77,
            0 0 40px 2px #00bfff44 inset,
            0 0 0 7px #061928;
        background: rgba(15, 25, 50, 0.96);
    }
    .neon-input {
        background: #071c2d;
        color: #b3f3f8;
        border-radius: 12px;
        box-shadow: 0 0 10px #15f7fc33 inset;
    }
    .neon-btn {
        box-shadow: 0 0 10px #15f7fc44, 0 0 30px #0fffd180 inset;
        letter-spacing: 1px;
    }
</style>
@endsection
