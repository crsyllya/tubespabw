<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>@yield('title', 'EventEast')</title>
<script src="https://cdn.tailwindcss.com"></script>

<nav class="bg-white shadow-md fixed w-full z-50 top-0 border-b border-gray-200">
  <div class="max-w-screen-xl flex items-center justify-between mx-auto p-4">
    
    <!-- Logo -->
    <a href="{{ url('/') }}" class="flex items-center">
        <span class="text-2xl font-bold text-blue-900">EventEast</span>
    </a>
    
    <!-- Button kanan -->
    <div class="flex items-center space-x-4">
        @auth
            <!-- Jika sudah login -->
            <span class="text-gray-700">{{ Auth::user()->name }}</span>
            <a href="{{ url('/dashboard') }}" 
               class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-blue-700">
                Dashboard
            </a>
            <a href="{{ route('logout') }}" 
               onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
               class="text-gray-700 hover:text-blue-700 text-sm">
                Logout
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                @csrf
            </form>
        @else
            <!-- Jika belum login -->
            <a href="{{ route('auth.login') }}" class="text-gray-700 hover:text-blue-700 text-sm">
                Login
            </a>
            <a href="{{ route('auth.register') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-blue-700">
                Register
            </a>
        @endauth
    </div>
  </div>
</nav>

<!-- spacer -->
<div class="h-16"></div>