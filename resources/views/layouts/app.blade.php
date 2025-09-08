<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Asset Management System')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-50 min-h-screen">
    @auth
    <!-- Navigation Bar -->
    <nav class="bg-white shadow-sm border-b">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <h1 class="text-xl font-semibold text-gray-900">Asset Management System</h1>
                    <span class="ml-4 px-2 py-1 text-xs bg-blue-100 text-blue-800 rounded-full">{{ucfirst(auth()->user()->role)}}</span>
                </div>
                <div class="flex items-center space-x-4">
                    <span class="text-gray-700">Hello, {{auth()->user()->name}}</span>
                    <form action="{{route('logout')}}" method="POST" class="inline">
                        @csrf
                        <button class="text-red-600 hover:text-red-800 font-medium" type="submit">Logout</button>
                    </form>
                </div>
            </div>
        </div>
    </nav>
    @endauth

    <!-- main -->
    <main class="@auth py-6 @endauth">
        <div class="@auth max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 @endauth">
            <!-- Flash message -->
            @if(session('success'))
            <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                {{ session('success') }}
            </div>
            @endif

            @if(session('error'))
            <div class="mb-4 bg-red-100 borderr border-red-400 text-red-700 px-4 py-3 rounded">
                {{ session('error') }}
            </div>
            @endif

            @if($errors->any())
            <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                <ul class="list-disc list-inside">
                    @foreach($errors->all() as $error)
                    <li>{{$error}}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            @yield('content')
        </div>
    </main>

</body>

</html>