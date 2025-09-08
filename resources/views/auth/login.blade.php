@extends('layouts.app')

@section('title', 'Login - Asset Management System')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-gray-100 to-gray-200 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8 bg-white p-8 rounded-xl shadow-lg">
        <div class="text-center">
            <h2 class="text-3xl font-extrabold text-gray-900">Asset Management System</h2>
            <p class="mt-2 text-sm text-gray-600">Sign in to your account</p>
        </div>

        <form class="mt-8 space-y-6" action="{{ route('login') }}" method="POST">
            @csrf
            <div class="space-y-4">
                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">Email Address</label>
                    <input id="email" name="email" type="email" required
                        class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                        placeholder="Enter your email" value="{{ old('email') }}">
                </div>

                <!-- Password -->
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                    <div class="relative">
                        <input id="password" name="password" type="password" required
                            class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                            placeholder="Enter your password">
                        <button type="button" id="togglePassword"
                            class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-500 hover:text-gray-700">
                            <svg id="eyeIcon" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <div>
                <button type="submit"
                    class="w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition">
                    Sign in
                </button>
            </div>
        </form>

        <!-- Demo Credentials -->
        <div class="mt-8 p-4 bg-blue-50 rounded-lg">
            <h3 class="text-sm font-medium text-blue-900 mb-2">Demo Credentials</h3>
            <div class="text-xs text-blue-700 space-y-1">
                <div><strong>Admin:</strong> admin@email.com / admin123</div>
                <div><strong>User:</strong> user1@email.com / user123</div>
                <div><strong>User:</strong> user2@email.com / user123</div>
                <div><strong>User:</strong> user3@email.com / user123</div>
            </div>
        </div>
    </div>
</div>

<!-- Password -->
<script>
    const togglePassword = document.querySelector("#togglePassword");
    const passwordField = document.querySelector("#password");
    const eyeIcon = document.querySelector("#eyeIcon");

    togglePassword.addEventListener("click", () => {
        const type = passwordField.type === "password" ? "text" : "password";
        passwordField.type = type;

        // Change eye icon style when toggled
        if (type === "text") {
            eyeIcon.setAttribute("stroke", "blue");
        } else {
            eyeIcon.setAttribute("stroke", "currentColor");
        }
    });
</script>
@endsection