<section>
    <header>
        <h2 class="text-lg font-medium text-white">
            {{ __('Profile Information') }}
        </h2>

        <p class="mt-1 text-sm text-white">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        {{-- Name --}}
        <div>
            <x-input-label class="text-white" for="name" :value="__('Name')" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full"
                :value="old('name', $user->name)" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        {{-- Staff ID --}}
        @if (auth()->user()->role === 'lecturer')
        <div>
            <x-input-label class="text-white" for="staff_number" :value="__('Staff ID')" />
            <x-text-input id="staff_number" name="staff_number" type="text" class="mt-1 block w-full"
                :value="old('staff_number', $user->staff_number)" autocomplete="off" readonly />
            <x-input-error class="mt-2" :messages="$errors->get('staff_number')" />
        </div>
        @endif

        @if (auth()->user()->role === 'student')
        {{-- Student ID --}}
        <div>
            <x-input-label class="text-white" for="student_number" :value="__('Student Number')" />
            <x-text-input id="student_number" name="student_number" type="text" class="mt-1 block w-full"
                :value="old('student_number', $user->student_number)" autocomplete="off" readonly/>
            <x-input-error class="mt-2" :messages="$errors->get('student_number')" />
        </div>
        @endif

        {{-- Phone Number --}}
        <div>
            <x-input-label class="text-white" for="phone_number" :value="__('Phone Number')" />
            <x-text-input id="phone_number" name="phone_number" type="text" class="mt-1 block w-full"
                :value="old('phone_number', $user->phone_number)" autocomplete="tel" />
            <x-input-error class="mt-2" :messages="$errors->get('phone_number')" />
        </div>

        {{-- Position --}}
        @if (auth()->user()->role === 'lecturer')
        <div>
            <x-input-label class="text-white" for="position" :value="__('Position')" />
            <x-text-input id="position" name="position" type="text" class="mt-1 block w-full"
                :value="old('position', $user->position)" readonly/>
            <x-input-error class="mt-2" :messages="$errors->get('position')" />
        </div>
        
        {{-- Room Number --}}
        <div>
            <x-input-label class="text-white" for="room_number" :value="__('Room Number')" />
            <x-text-input id="room_number" name="room_number" type="text" class="mt-1 block w-full"
                :value="old('room_number', $user->room_number)" />
            <x-input-error class="mt-2" :messages="$errors->get('room_number')" />
        </div>
        @endif

        {{-- Email --}}
        <div>
            <x-input-label class="text-white" for="email" :value="__('Email')" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full"
                :value="old('email', $user->email)" required autocomplete="email" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 text-white">
                        {{ __('Your email address is unverified.') }}
                        <button form="send-verification"
                            class="underline text-sm text-white hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>
                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-600">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        {{-- Role (read-only) --}}
        <div>
            <x-input-label class="text-white" for="role" :value="__('Role')" />
            <x-text-input id="role" name="role" type="text" class="mt-1 block w-full bg-gray-100" :value="$user->role" readonly />
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
