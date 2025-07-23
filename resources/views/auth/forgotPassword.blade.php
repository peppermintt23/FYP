<x-app-layout>
    {{-- this is UI only --}}
    <div class="min-h-screen flex items-center justify-center" style="background: url('/images/bg.png') no-repeat center center; background-size: cover;">
        <div class="w-full max-w-md bg-white bg-opacity-40 rounded-2xl shadow-xl p-8 backdrop-blur-sm">
            <!-- Step 1: Identifier Form -->
            <div id="step1">
                <h2 class="text-2xl font-semibold text-gray-800 mb-6 text-center">Forgot Password</h2>
                <form onsubmit="event.preventDefault(); showStep2();">
                    <div class="mb-4">
                        <label for="identifier" class="block text-gray-700 mb-2">Student Number / Staff ID</label>
                        <input type="text" id="identifier" required placeholder="Enter your ID"
                            class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-400" />
                    </div>
                    <button type="submit"
                        class="w-full py-2 mt-4 bg-indigo-600 text-white font-medium rounded-lg hover:bg-indigo-700 transition">Verify</button>
                </form>
            </div>

            <!-- Step 2: Reset Password Form -->
            <div id="step2" class="hidden">
                <h2 class="text-2xl font-semibold text-gray-800 mb-6 text-center">Reset Password</h2>
                <form onsubmit="event.preventDefault(); resetPassword();">
                    <div class="mb-4">
                        <label for="new_password" class="block text-gray-700 mb-2">New Password</label>
                        <input type="password" id="new_password" required placeholder="New Password"
                            class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-400" />
                    </div>
                    <div class="mb-4">
                        <label for="confirm_password" class="block text-gray-700 mb-2">Confirm Password</label>
                        <input type="password" id="confirm_password" required placeholder="Confirm Password"
                            class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-400" />
                    </div>
                    <button type="submit"
                        class="w-full py-2 mt-4 bg-green-600 text-white font-medium rounded-lg hover:bg-green-700 transition">Reset Password</button>
                </form>
            </div>
        </div>
    </div>

    <!-- JavaScript to toggle forms -->
    <script>
        function showStep2() {
            document.getElementById('step1').classList.add('hidden');
            document.getElementById('step2').classList.remove('hidden');
        }

        function resetPassword() {
            // Placeholder for actual reset logic
            alert('Your password has been reset successfully!');
        }
    </script>
</x-app-layout>
