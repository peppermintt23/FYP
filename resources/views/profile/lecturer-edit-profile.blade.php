<x-app-layout>
    <!-- Close Button -->
    <a href="{{ route('lecturer.profile.view') }}"
        class="absolute top-4 right-4 text-white bg-[#1c2535] hover:bg-blue-700 hover:text-white px-4 py-2 rounded-xl shadow-lg border border-blue-700/40 transition duration-150 z-50 text-2xl font-bold flex items-center justify-center"
        style="min-width: 44px; min-height: 44px; text-align: center;">
        &times;
    </a>

    <!-- Main Content -->
    <div class="py-12 bg-[#050e1a] min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">

            <!-- Update Profile Card -->
            <div class="p-6 sm:p-10 bg-[#111a28] shadow-2xl rounded-2xl border border-blue-700/30">
                <div class="max-w-xl mx-auto text-white">
                    @include('profile.partials.lecturer-update-profile')
                </div>
            </div>

            <!-- Update Password Card -->
            <div class="p-6 sm:p-10 bg-[#111a28] shadow-2xl rounded-2xl border border-blue-700/30">
                <div class="max-w-xl mx-auto text-white">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            {{-- <!-- Delete Account Card -->
            <div class="p-6 sm:p-10 bg-[#111a28] shadow-2xl rounded-2xl border border-red-700/40">
                <div class="max-w-xl mx-auto text-white">
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
        background: rgba(10, 10, 30, 0.95);
        border: 2.5px solid #15f7fc;
        border-radius: 16px;
        box-shadow: 0 0 22px 3px #15f7fc, 0 0 38px 1px #00bfff55 inset, 0 0 0 7px #061928;
        position: relative;
        overflow: hidden;
    }
    </style>
</x-app-layout>
