<section >

    <header>
        <h2 class="text-lg font-semibold text-white tracking-wide">
            {{ __('Profile Information') }}
        </h2>
        <p class="mt-1 text-sm text-blue-200">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    {{-- Success Message (above form)
    @if (session('status') === 'profile-updated')
        <div 
            x-data="{ show: true }" 
            x-show="show" 
            x-transition 
            x-init="setTimeout(() => show = false, 2500)" 
            class="mb-6 px-4 py-2 rounded-lg bg-emerald-600 text-white text-sm font-medium shadow"
        >
            {{ __('Profile updated successfully!') }}
        </div>
    @endif --}}

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-8 space-y-7">
        @csrf
        @method('patch')

        {{-- Name --}}
        <div>
            <x-input-label class="text-blue-200" for="name" :value="__('Name')" />
            <x-text-input id="name" name="name" type="text" 
                class="mt-1 block w-full bg-[#1c2535] text-white border-blue-500 focus:ring-blue-400 rounded-lg"
                :value="old('name', $user->name)" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        {{-- Staff ID --}}
        @if (auth()->user()->role === 'lecturer')
        <div>
            <x-input-label class="text-blue-200" for="staff_number" :value="__('Staff ID')" />
            <x-text-input id="staff_number" name="staff_number" type="text"
                class="mt-1 block w-full bg-[#1c2535] text-white border-blue-500 rounded-lg"
                :value="old('staff_number', $user->staff_number)" readonly  autocomplete="off" />
            <x-input-error class="mt-2" :messages="$errors->get('staff_number')" />
        </div>
        @endif

        {{-- Phone Number --}}
        <div>
            <x-input-label class="text-blue-200" for="phone_number" :value="__('Phone Number')" />
            <x-text-input id="phone_number" name="phone_number" type="text"
                class="mt-1 block w-full bg-[#1c2535] text-white border-blue-500 rounded-lg"
                :value="old('phone_number', $user->phone_number)" autocomplete="tel" />
            <x-input-error class="mt-2" :messages="$errors->get('phone_number')" />
        </div>

        {{-- Position --}}
        @if (auth()->user()->role === 'lecturer')
        <div>
            <x-input-label class="text-blue-200" for="position" :value="__('Position')" />
            <x-text-input id="position" name="position" type="text"
                class="mt-1 block w-full bg-[#1c2535] text-white border-blue-500 rounded-lg"
                :value="old('position', $user->position)" readonly />
            <x-input-error class="mt-2" :messages="$errors->get('position')"   />
        </div>
        
        {{-- Room Number --}}
        <div>
            <x-input-label class="text-blue-200" for="room_number" :value="__('Room Number')" />
            <x-text-input id="room_number" name="room_number" type="text"
                class="mt-1 block w-full bg-[#1c2535] text-white border-blue-500 rounded-lg"
                :value="old('room_number', $user->room_number)" />
            <x-input-error class="mt-2" :messages="$errors->get('room_number')" />
        </div>
        @endif

        {{-- Email --}}
        <div>
            <x-input-label class="text-blue-200" for="email" :value="__('Email')" />
            <x-text-input id="email" name="email" type="email"
                class="mt-1 block w-full bg-[#1c2535] text-white border-blue-500 rounded-lg"
                :value="old('email', $user->email)" required autocomplete="email" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 text-blue-200">
                        {{ __('Your email address is unverified.') }}
                        <button form="send-verification"
                            class="underline text-sm text-cyan-300 hover:text-cyan-500 rounded-md focus:outline-none focus:ring-2 focus:ring-cyan-500">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>
                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-emerald-400">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        {{-- Role (read-only) --}}
        <div>
            <x-input-label class="text-blue-200" for="role" :value="__('Role')" />
            <x-text-input id="role" name="role" type="text"
                class="mt-1 block w-full bg-[#232d43] text-white border-blue-500 rounded-lg"
                :value="$user->role" readonly />
        </div>

        
        {{-- Submit --}}
        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p x-data="{ show: true }" x-show="show" x-transition
                   x-init="setTimeout(() => show = false, 2000)"
                   class="text-sm text-white">
                    {{ __('Saved.') }}
                </p>
            @endif
        </div>
    </form>
</section>

<style>
    .bg-forced-dark {
    background: #050e1a !important;
}
<section class="bg-forced-dark">

</style>