<x-app-layout>
    <div class="min-h-screen bg-white text-gray-900">
        <!-- Top Header -->
        <!-- ... your top header and sidebar remain unchanged ... -->

        <!-- Main Content Wrapper: push content to the right of sidebar -->
        <div class="ml-64 flex justify-center items-start pt-12">
            <div class="w-full max-w-3xl bg-white p-8 shadow rounded">

                <h2 class="text-2xl font-bold mb-6 text-center">Students in Group {{ $groupCourse }}</h2>

                <table class="min-w-full border border-gray-300">
                    <thead class="bg-gray-200">
                        <tr>
                            <th class="py-2 px-4 border-b text-left">Name</th>
                            <th class="py-2 px-4 border-b text-left">Student ID</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($enrollments as $enrollment)
                            @if($enrollment->student)
                                <tr class="hover:bg-gray-50">
                                    <td class="py-2 px-4 border-b">{{ $enrollment->student->name }}</td>
                                    <td class="py-2 px-4 border-b">{{ $enrollment->student->student_id }}</td>
                                </tr>
                            @endif
                        @empty
                            <tr>
                                <td colspan="2" class="py-4 px-4 text-center text-gray-500">
                                    No students found in this group.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <div class="mt-6 text-center">
                    <a href="{{ route('lecturer.profile.view') }}" class="text-blue-600 hover:underline">
                        ⬅ Back to Profile
                    </a>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
