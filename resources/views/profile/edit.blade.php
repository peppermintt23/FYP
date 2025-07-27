<x-app-layout>
    <a href="{{ route('student.profile', $user->id) }}"
        class="absolute top-4 right-4 text-cyan-300 bg-[#0a132a] hover:bg-[#13e2be] hover:text-white px-4 py-2 rounded-lg shadow transition duration-150 z-50 border border-[#13e2be]">
        &times;
    </a>
    <!-- Main Content -->
    <div class="py-12 bg-[#050e1a] min-h-screen">
        <div class="max-w-4xl mx-auto px-2 sm:px-6 lg:px-8 space-y-8">
            <div class="p-8 neon-frame shadow rounded-xl">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="p-8 neon-frame shadow rounded-xl">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            {{-- <div class="p-8 neon-frame shadow rounded-xl">
                <div class="max-w-xl">
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
