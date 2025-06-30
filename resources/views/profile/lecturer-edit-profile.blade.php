<x-app-layout>
    
        <!-- Close Button -->
            <a href="{{ route('lecturer.profile.view') }}"
                class="absolute top-4 right-4 text-gray-600 bg-gray-200 hover:bg-gray-400 hover:text-white px-4 py-2 rounded-lg shadow transition duration-150 z-50">
                &times;
            </a>

        <!-- Main Content -->
        <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-200 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.lecturer-update-profile')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
        </div>
    
</x-app-layout>
