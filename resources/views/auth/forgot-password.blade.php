@extends('layouts.guest')
@section('content')
<div class="max-w-md mx-auto mt-12 bg-white p-8 rounded shadow">
    <h2 class="text-xl font-bold mb-6">Forgot Password</h2>
    <form method="POST" action="{{ route('forgot-password.verify') }}">
        @csrf
        <div class="mb-4">
            <input type="email" name="email" class="w-full px-4 py-2 border rounded" placeholder="Enter your email" value="{{ old('email') }}" required>
            @error('email') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
        </div>
        <button type="submit" class="w-full bg-blue-600 text-white px-4 py-2 rounded">Verify Email</button>
    </form>
</div>
@endsection
{{-- TAK GUNA KOT --}}