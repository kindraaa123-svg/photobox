<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Photobox Studio - Authentication</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Instrument+Sans:wght@400;500;600;700&family=Outfit:wght@500;600;700;800;900&display=swap" rel="stylesheet">

    <!-- CSS -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Instrument Sans', sans-serif;
            background: radial-gradient(circle at 50% 50%, #fff5f7 0%, #f3e8ff 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow-x: hidden;
            position: relative;
        }

        /* Cute bubbly glowing blobs */
        .glowing-blob {
            position: absolute;
            border-radius: 50%;
            filter: blur(80px);
            opacity: 0.5;
            z-index: 1;
            pointer-events: none;
            animation: pulse 12s infinite alternate;
        }
        .blob-1 {
            width: 350px;
            height: 350px;
            background: #ffd3e8;
            top: -5%;
            left: -5%;
        }
        .blob-2 {
            width: 450px;
            height: 450px;
            background: #d8f3dc;
            bottom: -5%;
            right: -5%;
        }

        @keyframes pulse {
            0% { transform: scale(1) translate(0, 0); }
            100% { transform: scale(1.1) translate(20px, 20px); }
        }

        .auth-container {
            z-index: 10;
            backdrop-filter: blur(20px);
            background: rgba(255, 255, 255, 0.75);
            border: 3px solid rgba(255, 255, 255, 0.9);
            box-shadow: 0 25px 50px -12px rgba(214, 180, 230, 0.4);
        }

        .glow-button {
            background: linear-gradient(135deg, #ffb7b2 0%, #ffc6ff 100%);
            color: #5d4b68;
            box-shadow: 0 8px 20px rgba(255, 183, 178, 0.35);
            transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }
        .glow-button:hover {
            box-shadow: 0 10px 25px rgba(255, 183, 178, 0.5);
            transform: translateY(-2px) scale(1.02);
        }

        .form-input {
            background: #ffffff;
            border: 2px solid #ecdff6;
            color: #4a3856;
            transition: all 0.25s ease-in-out;
        }
        .form-input:focus {
            border-color: #ffb7b2;
            background: #ffffff;
            outline: none;
            box-shadow: 0 0 0 4px rgba(255, 183, 178, 0.25);
        }

        .tab-btn {
            position: relative;
            transition: all 0.3s ease;
            color: #8c7a98;
        }
        .tab-btn.active {
            color: #5d4b68;
        }
        .tab-btn.active::after {
            content: '';
            position: absolute;
            bottom: -4px;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, #ffb7b2, #ffc6ff);
            border-radius: 4px;
        }
    </style>
</head>
<body class="text-slate-700 antialiased p-4">
    <!-- Background elements -->
    <div class="glowing-blob blob-1"></div>
    <div class="glowing-blob blob-2"></div>

    <div class="w-full max-w-md auth-container rounded-[2.5rem] p-8 md:p-10">
        <!-- Logo and Header -->
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-16 h-16 rounded-[1.5rem] bg-gradient-to-tr from-pink-300 to-purple-300 shadow-md shadow-pink-200/40 mb-4 animate-bounce">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-8 h-8 text-white">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.827 6.175A2.31 2.31 0 0 1 5.186 7.23c-.38.054-.757.112-1.134.175C2.999 7.58 2.25 8.507 2.25 9.574V18a2.25 2.25 0 0 0 2.25 2.25h15A2.25 2.25 0 0 0 21.75 18V9.574c0-1.067-.75-1.994-1.802-2.169a47.865 47.865 0 0 0-1.134-.175 2.31 2.31 0 0 1-1.64-1.055l-.822-1.316a2.192 2.192 0 0 0-1.736-1.039 48.774 48.774 0 0 0-5.232 0 2.192 2.192 0 0 0-1.736 1.039l-.821 1.316Z" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 12.75a4.5 4.5 0 1 1-9 0 4.5 4.5 0 0 1 9 0ZM18.75 10.5h.008v.008h-.008V10.5Z" />
                </svg>
            </div>
            <h1 class="text-3xl font-black tracking-tight text-purple-950 font-outfit bg-gradient-to-r from-purple-800 to-pink-600 bg-clip-text text-transparent">Photobox Studio</h1>
            <p class="text-sm text-purple-400/80 mt-1 font-medium">Capture sweet & happy memories! ✨</p>
        </div>

        <!-- Session Status & Errors -->
        @if ($errors->any())
            <div class="mb-6 p-4 rounded-2xl bg-red-50 border border-red-200 text-red-700 text-xs font-semibold">
                <ul class="list-disc list-inside space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Form Tab Switcher -->
        <div class="flex border-b border-purple-100 mb-6 text-sm">
            <button id="loginTabBtn" onclick="switchForm('login')" class="flex-1 pb-3 font-bold tab-btn active">Login</button>
            <button id="registerTabBtn" onclick="switchForm('register')" class="flex-1 pb-3 font-bold tab-btn">Register</button>
        </div>

        <!-- Login Form -->
        <form id="loginForm" action="{{ route('login') }}" method="POST" class="space-y-5">
            @csrf
            <div>
                <label for="login_email" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Email Address</label>
                <input id="login_email" name="email" type="email" required value="{{ old('email') }}"
                       class="w-full px-4 py-3 rounded-2xl form-input text-sm" placeholder="you@example.com">
            </div>

            <div>
                <label for="login_password" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Password</label>
                <input id="login_password" name="password" type="password" required
                       class="w-full px-4 py-3 rounded-2xl form-input text-sm" placeholder="••••••••">
            </div>

            <div class="flex items-center justify-between text-xs text-slate-500">
                <label class="flex items-center space-x-2 cursor-pointer font-semibold">
                    <input type="checkbox" name="remember" class="rounded border-purple-200 bg-white text-purple-400 focus:ring-0">
                    <span>Remember me</span>
                </label>
            </div>

            <button type="submit" class="w-full py-3.5 rounded-2xl text-sm font-extrabold shadow-lg glow-button mt-2">
                Sign In 💖
            </button>
        </form>

        <!-- Register Form -->
        <form id="registerForm" action="{{ route('register') }}" method="POST" class="space-y-5 hidden">
            @csrf
            <div>
                <label for="reg_name" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Full Name</label>
                <input id="reg_name" name="name" type="text" required value="{{ old('name') }}"
                       class="w-full px-4 py-3 rounded-2xl form-input text-sm" placeholder="John Doe">
            </div>

            <div>
                <label for="reg_email" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Email Address</label>
                <input id="reg_email" name="email" type="email" required value="{{ old('email') }}"
                       class="w-full px-4 py-3 rounded-2xl form-input text-sm" placeholder="you@example.com">
            </div>

            <div>
                <label for="reg_password" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Password</label>
                <input id="reg_password" name="password" type="password" required
                       class="w-full px-4 py-3 rounded-2xl form-input text-sm" placeholder="•••••••• (Min. 8 chars)">
            </div>

            <div>
                <label for="reg_password_confirmation" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Confirm Password</label>
                <input id="reg_password_confirmation" name="password_confirmation" type="password" required
                       class="w-full px-4 py-3 rounded-2xl form-input text-sm" placeholder="••••••••">
            </div>

            <button type="submit" class="w-full py-3.5 rounded-2xl text-sm font-extrabold shadow-lg glow-button mt-2">
                Create Account 🧁
            </button>
        </form>
    </div>

    <!-- Toggle Scripts -->
    <script>
        function switchForm(form) {
            const loginForm = document.getElementById('loginForm');
            const registerForm = document.getElementById('registerForm');
            const loginTabBtn = document.getElementById('loginTabBtn');
            const registerTabBtn = document.getElementById('registerTabBtn');

            if (form === 'login') {
                loginForm.classList.remove('hidden');
                registerForm.classList.add('hidden');
                loginTabBtn.classList.add('active');
                registerTabBtn.classList.remove('active');
            } else {
                loginForm.classList.add('hidden');
                registerForm.classList.remove('hidden');
                loginTabBtn.classList.remove('active');
                registerTabBtn.classList.add('active');
            }
        }

        // Auto activate register tab if validation failed for registration
        @if ($errors->has('name') || $errors->has('password_confirmation') || old('name'))
            switchForm('register');
        @endif
    </script>
</body>
</html>
