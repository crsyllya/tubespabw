<footer class="bg-white rounded-lg shadow mt-20">
    <div class="w-full max-w-screen-xl mx-auto p-4 md:py-8">
        
        <div class="sm:flex sm:items-center sm:justify-between">
            <a href="{{ route('layout.index') }}" class="flex items-center mb-4 sm:mb-0 space-x-3 rtl:space-x-reverse">
                <span class="self-center text-2xl font-semibold whitespace-nowrap text-blue-900">EventEast</span>
            </a>

            <ul class="flex flex-wrap items-center mb-6 text-sm font-medium text-gray-500 sm:mb-0">
                <li><a href="#" class="hover:underline me-4 md:me-6">About</a></li>
                <li><a href="#" class="hover:underline me-4 md:me-6">Privacy Policy</a></li>
                <li><a href="#" class="hover:underline">Contact</a></li>
            </ul>
        </div>

        <hr class="my-6 border-gray-200 sm:mx-auto lg:my-8" />

        <span class="block text-sm text-gray-500 sm:text-center">
            © {{ date('Y') }} <a href="{{ route('layout.index') }}" class="hover:underline">EventEast™</a>. All Rights Reserved.
        </span>
    </div>
</footer>
