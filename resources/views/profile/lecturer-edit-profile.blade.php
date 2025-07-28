<x-app-layout>
    <!-- Close Button -->
    <a href="{{ route('lecturer.profile.view') }}"
        class="absolute top-4 right-4 text-[#15f7fc] bg-[#08192f] hover:bg-[#0e2a44] hover:text-white px-4 py-2 rounded-xl shadow-md border border-[#15f7fc]/40 transition duration-150 z-50 text-2xl font-extrabold flex items-center justify-center neon-glow"
        style="min-width: 44px; min-height: 44px; text-align: center;">
        &times;
    </a>

    <!-- Main Content -->
    <div class="py-12 bg-[#050e1a] min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">

            <!-- Update Profile Card -->
            <div class="p-6 sm:p-10 bg-[#0c1b2b] neon-frame">
                <div class="max-w-xl mx-auto text-[#15f7fc]">
                    @include('profile.partials.lecturer-update-profile')
                </div>
            </div>

            <!-- Update Password Card -->
            <div class="p-6 sm:p-10 bg-[#0c1b2b] neon-frame">
                <div class="max-w-xl mx-auto text-[#15f7fc]">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            {{-- <!-- Delete Account Card -->
            <div class="p-6 sm:p-10 bg-[#0c1b2b] neon-frame border border-red-500/60">
                <div class="max-w-xl mx-auto text-red-500">
                    @include('profile.partials.delete-user-form')
                </div>
            </div> --}}
        </div>
    </div>

    <style>
        html, body {
            background: #050e1a !important;
            min-height: 100vh;
            width: 100vw;
        }

        .neon-frame {
            background: rgba(10, 20, 40, 0.95);
            border: 2px solid #15f7fc;
            border-radius: 1rem;
            box-shadow:
                0 0 10px #15f7fc,
                0 0 20px #15f7fc,
                0 0 30px #15f7fc33,
                0 0 0 5px #061928 inset;
            transition: 0.3s ease-in-out;
        }

        .neon-glow:hover {
            box-shadow:
                0 0 8px #15f7fc,
                0 0 15px #15f7fc,
                0 0 25px #15f7fc;
        }

        input,
        textarea,
        select {
            background-color: #0b1522 !important;
            color: #15f7fc !important;
            border: 1px solid #15f7fc88 !important;
        }

        input:focus,
        textarea:focus,
        select:focus {
            box-shadow: 0 0 8px #15f7fc88;
            border-color: #15f7fc;
        }

        label {
            color: #15f7fc !important;
        }
    </style>
</x-app-layout>
