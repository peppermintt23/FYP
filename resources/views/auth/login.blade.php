<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Login</title>
  @vite(['resources/css/app.css', 'resources/js/app.js'])
  <style>
    .neon-text {
      color: #15f7fc;
      font-size: 2.5rem;              /* adjust as needed */
      font-weight: bold;
      text-shadow:
        0 0 2px #fff,
        0 0 8px #15f7fc,
        0 0 16px #15f7fc,
        0 0 24px #1344ea;
    }
    .neon-input {
      border: 1.5px solid #15f7fc;
      background: #071c2d;
      color: #c9fbff;
      border-radius: 10px;
      padding: 0.7rem 1.2rem;
      outline: none;
      font-size: 1.07rem;
      transition: border 0.2s, box-shadow 0.22s;
      box-shadow: 0 0 8px #1bf7ff25;
    }
    .neon-input:focus {
      border: 2px solid #14e1ee;
      background: #0a132a;
      color: #00fff3;
      box-shadow: 0 0 14px #15f7fc99;
    }
    .neon-btn {
      background: linear-gradient(90deg, #15f7fc 0%, #1344ea 100%);
      color: #071c2d;
      border: none;
      outline: none;
      border-radius: 8px;
      font-weight: bold;
      letter-spacing: 1px;
      transition: box-shadow 0.22s, background 0.22s;
      box-shadow: 0 0 12px #15f7fc99, 0 0 24px #15f7fc33 inset;
    }
    .neon-btn:hover {
      filter: brightness(1.13) saturate(1.5);
      box-shadow: 0 0 20px #15f7fcdd;
      background: linear-gradient(90deg, #1344ea 0%, #15f7fc 100%);
      color: #fff;
    }
    .neon-checkbox {
      accent-color: #15f7fc;
      width: 18px;
      height: 18px;
      border-radius: 6px;
      border: 2px solid #15f7fc;
      background: #0a192f;
      box-shadow: 0 0 6px #15f7fc88;
      transition: box-shadow 0.2s;
    }
    .neon-checkbox:checked {
      box-shadow: 0 0 14px #15f7fc99;
    }
  </style>
</head>
<body
  class="min-h-screen flex items-center justify-center"
  style="background: url('{{ asset('asset/bg.png') }}') center/cover no-repeat; background-size: cover; image-rendering: auto;"
>
  <div class="w-full max-w-md px-4">
    <!-- ONLY this is centered -->
    <h2 class="neon-text text-center mb-6">
      LOGIN
    </h2>

    <!-- semi-transparent form box -->
    <div
      class="p-8 rounded-lg"
      style="background-color: rgba(10, 25, 40, 0.4);"
    >
      {{-- Session Status --}}
      <x-auth-session-status class="mb-4" :status="session('status')" />

      <form method="POST" action="{{ route('login') }}" class="space-y-6">
        @csrf

        {{-- Email Address --}}
        <div>
          <x-input-label for="email" :value="__('Email')" class="text-white font-bold" />
          <x-text-input
            id="email"
            class="neon-input block mt-1 w-full"
            type="email"
            name="email"
            :value="old('email')"
            required
            autofocus
            autocomplete="username"
          />
          <x-input-error :messages="$errors->get('email')" class="mt-2 text-[#ff91b3] text-sm" />
        </div>

        {{-- Password --}}
        <div>
          <x-input-label for="password" :value="__('Password')" class="text-white font-bold" />
          <x-text-input
            id="password"
            class="neon-input block mt-1 w-full"
            type="password"
            name="password"
            required
            autocomplete="current-password"
          />
          <x-input-error :messages="$errors->get('password')" class="mt-2 text-[#ff91b3] text-sm" />
        </div>

        {{-- Remember Me 
        <div class="flex items-center">
          <input
            id="remember_me"
            type="checkbox"
            class="neon-checkbox"
            name="remember"
          />
          <label for="remember_me" class="ml-2 text-sm text-cyan-100">
            {{ __('Remember me') }}
          </label>
        </div>--}}

        {{-- Register Link (now left-aligned) --}}
        <div>
          <a class="underline text-sm text-gray-200 hover:text-white" href="{{ route('register') }}">
            {{ __("Don't have account? Signup here") }}
          </a>
        </div>

        <div>
          <a class="underline text-sm text-gray-200 hover:text-white" href="{{ route('abc') }}">
            {{ __('Forgot password') }}
          </a>
        </div>

        {{-- Submit --}}
        <div class="flex items-center justify-end">
          <button type="submit" class="neon-btn px-8 py-2 font-bold">
            {{ __('Log in') }}
          </button>
        </div>
      </form>
    </div>
  </div>
</body>
</html>
