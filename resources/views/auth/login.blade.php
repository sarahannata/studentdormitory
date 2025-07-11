<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
        }
    </style>
</head>

<body class="bg-gray-100 flex items-center justify-center min-h-screen">
    <div class="bg-white shadow-lg rounded-lg flex w-screen h-screen">
        <div
            class="hidden md:flex md:w-1/2 bg-gradient-to-tr from-[#F7CFD8] via-[#FFFFFF] to-[#FFFFFF] items-center justify-center p-10">
            <div class="flex justify-center mb-6">
                <img src="{{ asset('images/logo.png') }}" alt="Logo" object-contain>
            </div>
        </div>
        <div
            class="w-full md:w-1/2 bg-gradient-to-bl from-[#F7CFD8] via-[#FFFFFF] to-[#FFFFFF] p-10 px-20 flex flex-col justify-center mx-auto">
            <h2 class="text-5xl font-bold mb-2 text-[#A35C7A]" style="text-shadow: 2px 2px 4px rgba(0,0,0,0.2);">
                Welcome
                <span class="wave">👋🏻</span>
            </h2>
            <p class="text-gray-600 mb-6">Please Login!</p>
            <!-- Form -->

            <form action="{{ route('login') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="username" class="block text-gray-700 pb-2">Username</label>
                    <input type="text" id="username" name="username" value="{{ old('username') }}"
                        placeholder="Enter Username"
                        class="w-full px-4 py-2 border rounded-lg border-[#FFA09B] focus:outline-none focus:border-[#FCC6FF]"
                        required>
                </div>
                <div class="mb-4">
                    <label for="password" class="block text-gray-700 pb-2">Password</label>
                    <input type="password" id="password" name="password" autocomplete="current-password"
                        placeholder="Enter Password"
                        class="w-full px-4 py-2 border rounded-lg border-[#FFA09B] focus:outline-none focus:border-[#FCC6FF]"
                        required>
                </div>
                @if ($errors->has('login'))
                    <div class="text-red-500 rounded mb-4">
                        {{ $errors->first('login') }}
                    </div>
                @endif
                <div class="flex items-center justify-between mb-6">
                    <label class="flex items-center">
                        <input type="hidden" name="remember" value="0">
                        <input type="checkbox" name="remember" value="1" class="form-checkbox text-blue-500">
                        <span class="ml-2 text-gray-700">Remember me</span>
                    </label>
                    {{-- <a href="#" class="text-blue-500">Forgot password?</a> --}}
                </div>
                <x-buttonpink>Login</x-buttonpink>
            </form>
        </div>
    </div>
</body>

</html>
