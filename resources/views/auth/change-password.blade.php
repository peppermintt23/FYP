<x-app-layout>
    <form method="POST" action="{{ route('password.change') }}">
        @csrf

        <div>
            <x-input-label for="password" :value="__('New Password')" />
            <x-text-input id="password" type="password" name="password" required />
        </div>

        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
            <x-text-input id="password_confirmation" type="password" name="password_confirmation" required />
        </div>

        <div class="mt-4">
            <x-primary-button>Change Password</x-primary-button>
        </div>
    </form>
</x-app-layout>
