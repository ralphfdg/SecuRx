<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Reset Password - SecuRx</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased bg-slate-50 text-gray-800 min-h-screen flex items-center justify-center relative selection:bg-securx-cyan selection:text-white">

    <div class="absolute top-[5%] left-[10%] w-96 h-96 bg-securx-cyan/20 rounded-full blur-[100px] pointer-events-none"></div>

    <div class="glass-panel p-8 md:p-10 z-10 mx-4 w-full max-w-md">
        
        <div class="flex flex-col items-center mb-8 text-center">
            <h1 class="text-2xl font-extrabold text-securx-navy mb-2">Create New Password</h1>
            <p class="text-gray-500 font-medium text-sm">
                Your identity has been verified. Please enter a strong new password below.
            </p>
        </div>

        <form method="POST" action="{{ route('password.store') }}" class="space-y-5">
            @csrf

            <input type="hidden" name="token" value="{{ $request->route('token') }}">

            <div>
                <label for="email" class="block text-sm font-bold text-securx-navy mb-1.5">Email Address</label>
                <input type="email" id="email" name="email" value="{{ old('email', $request->email) }}" class="glass-input w-full py-2.5 px-4 bg-gray-100 text-gray-500 cursor-not-allowed" readonly required>
            </div>

            <div>
                <label for="password" class="block text-sm font-bold text-securx-navy mb-1.5">New Password</label>
                <input type="password" id="password" name="password" class="glass-input w-full py-2.5 px-4" required autofocus>
                @error('password') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
            </div>

            <div>
                <label for="password_confirmation" class="block text-sm font-bold text-securx-navy mb-1.5">Confirm New Password</label>
                <input type="password" id="password_confirmation" name="password_confirmation" class="glass-input w-full py-2.5 px-4" required>
            </div>

            <button type="submit" class="glass-btn-primary w-full text-base py-3 mt-4">
                Reset Password
            </button>
        </form>
    </div>

</body>
</html>