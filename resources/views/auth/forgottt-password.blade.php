<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            background: url('/asset/bg.png') no-repeat center center;
            background-size: cover;
        }
        .neon-text {
            color: #15f7fc;
            font-size: 2.5rem;
            font-weight: bold;
            text-shadow:
              0 0 2px #fff,
              0 0 8px #15f7fc,
              0 0 16px #15f7fc,
              0 0 24px #1344ea;
        }
        .neon-input {
            border: 1.5px solid #15f7fc;
            background: #071c2d;
            color: #c9fbff;
            border-radius: 10px;
            padding: 0.7rem 1.2rem;
            outline: none;
            font-size: 1.07rem;
            transition: border 0.2s, box-shadow 0.22s;
            box-shadow: 0 0 8px #1bf7ff25;
        }
        .neon-input:focus {
            border: 2px solid #14e1ee;
            background: #0a132a;
            color: #00fff3;
            box-shadow: 0 0 14px #15f7fc99;
        }
        .neon-btn {
            background: linear-gradient(90deg, #15f7fc 0%, #1344ea 100%);
            color: #071c2d;
            border: none;
            outline: none;
            border-radius: 8px;
            font-weight: bold;
            letter-spacing: 1px;
            transition: box-shadow 0.22s, background 0.22s;
            box-shadow: 0 0 12px #15f7fc99, 0 0 24px #15f7fc33 inset;
        }
        .neon-btn:hover {
            filter: brightness(1.13) saturate(1.5);
            box-shadow: 0 0 20px #15f7fcdd;
            background: linear-gradient(90deg, #1344ea 0%, #15f7fc 100%);
            color: #fff;
        }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center">
    <div class="w-full max-w-md px-4">
        <div class="p-8 rounded-lg" style="background-color: rgba(10,25,40,0.4);">
            <!-- Step 1: Identifier Form -->
            <div id="step1">
                <h2 class="neon-text text-center mb-6">Forgot Password</h2>
                <form onsubmit="event.preventDefault(); showStep2();">
                    <div class="mb-4">
                        <label for="identifier" class="block text-gray-200 mb-2">Student Number / Staff ID</label>
                        <input type="text" id="identifier" required placeholder="Enter your ID"
                            class="neon-input w-full" />
                    </div>
                    <button type="submit" class="neon-btn w-full py-2 mt-4">Verify</button>
                </form>
            </div>

            <!-- Step 2: Reset Password Form -->
            <div id="step2" class="hidden">
                <h2 class="neon-text text-center mb-6">Reset Password</h2>
                <form onsubmit="event.preventDefault(); resetPassword();">
                    <div class="mb-4">
                        <label for="new_password" class="block text-gray-200 mb-2">New Password</label>
                        <input type="password" id="new_password" required placeholder="New Password"
                            class="neon-input w-full" />
                    </div>
                    <div class="mb-4">
                        <label for="confirm_password" class="block text-gray-200 mb-2">Confirm Password</label>
                        <input type="password" id="confirm_password" required placeholder="Confirm Password"
                            class="neon-input w-full" />
                    </div>
                    <button type="submit" class="neon-btn w-full py-2 mt-4">Reset Password</button>
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
</body>
</html>
