<nav x-data="{ open: false }" class="bg-white fixed w-full z-50 top-0 start-0 border-b border-gray-200 shadow-sm transition-all duration-300">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex w-full justify-between">
                <div class="shrink-0 flex items-center">
                    <a href="{{ url('/') }}" class="flex items-center space-x-3 rtl:space-x-reverse">
                        <img src="{{ asset('images/logonocap.png') }}" class="h-10 w-10" alt="IMP Logo">
                        <span class="self-center text-xl font-bold whitespace-nowrap text-blue-900 tracking-tight">
                            IMP UNNES
                        </span>
                    </a>
                </div>

                <div class="hidden md:flex space-x-4 items-center">
                    <a href="{{ url('/') }}" 
                       class="inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium leading-5 transition duration-150 ease-in-out {{ request()->is('/') ? 'border-blue-700 text-gray-900' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                        Home
                    </a>
                    
                    <a href="{{ url('/about') }}" 
                       class="inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium leading-5 transition duration-150 ease-in-out {{ request()->is('about') ? 'border-blue-700 text-gray-900' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                        About
                    </a>

                    <a href="{{ url('/activity') }}" 
                       class="inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium leading-5 transition duration-150 ease-in-out {{ request()->is('activity') ? 'border-blue-700 text-gray-900' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                        Activity
                    </a>

                    <a href="{{ url('/sosmed') }}" 
                       class="inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium leading-5 transition duration-150 ease-in-out {{ request()->is('sosmed') ? 'border-blue-700 text-gray-900' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                        Social Media
                    </a>

                    <a href="{{ url('/sisemar') }}" 
                       class="inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium leading-5 transition duration-150 ease-in-out {{ request()->is('sisemar') ? 'border-blue-700 text-gray-900' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                        SI SEMAR
                    </a>

                    <a href="{{ url('/ampera') }}" 
                       class="inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium leading-5 transition duration-150 ease-in-out {{ request()->is('ampera') ? 'border-blue-700 text-gray-900' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                        AMPERA
                    </a>

                    <a href="{{ url('/login') }}" 
                       class="ml-4 inline-flex items-center px-4 py-2 border border-blue-700 text-sm font-semibold rounded-md text-blue-700 bg-white hover:bg-blue-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-700 transition duration-150 ease-in-out">
                        Login
                    </a>

                    <a href="{{ url('/register') }}" 
                       class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-semibold rounded-md text-white bg-blue-700 hover:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-700 transition duration-150 ease-in-out">
                        Sign Up
                    </a>
                </div>
            </div>

            <div class="-me-2 flex items-center md:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <div :class="{'block': open, 'hidden': ! open}" class="hidden md:hidden bg-white border-t border-gray-100">
        <div class="pt-2 pb-3 space-y-1 px-4">
            <a href="{{ url('/') }}" 
               class="block w-full ps-3 pe-4 py-2 border-l-4 text-start text-base font-medium transition duration-150 ease-in-out {{ request()->is('/') ? 'border-blue-700 text-blue-700 bg-blue-50' : 'border-transparent text-gray-600 hover:text-gray-800 hover:bg-gray-50 hover:border-gray-300' }}">
                Home
            </a>

            <a href="{{ url('/about') }}" 
               class="block w-full ps-3 pe-4 py-2 border-l-4 text-start text-base font-medium transition duration-150 ease-in-out {{ request()->is('about') ? 'border-blue-700 text-blue-700 bg-blue-50' : 'border-transparent text-gray-600 hover:text-gray-800 hover:bg-gray-50 hover:border-gray-300' }}">
                About
            </a>

            <a href="{{ url('/activity') }}" 
               class="block w-full ps-3 pe-4 py-2 border-l-4 text-start text-base font-medium transition duration-150 ease-in-out {{ request()->is('activity') ? 'border-blue-700 text-blue-700 bg-blue-50' : 'border-transparent text-gray-600 hover:text-gray-800 hover:bg-gray-50 hover:border-gray-300' }}">
                Activity
            </a>

            <a href="{{ url('/sosmed') }}" 
               class="block w-full ps-3 pe-4 py-2 border-l-4 text-start text-base font-medium transition duration-150 ease-in-out {{ request()->is('sosmed') ? 'border-blue-700 text-blue-700 bg-blue-50' : 'border-transparent text-gray-600 hover:text-gray-800 hover:bg-gray-50 hover:border-gray-300' }}">
                Social Media
            </a>

            <a href="{{ url('/sisemar') }}" 
               class="block w-full ps-3 pe-4 py-2 border-l-4 text-start text-base font-medium transition duration-150 ease-in-out {{ request()->is('sisemar') ? 'border-blue-700 text-blue-700 bg-blue-50' : 'border-transparent text-gray-600 hover:text-gray-800 hover:bg-gray-50 hover:border-gray-300' }}">
                SI SEMAR
            </a>

            <a href="{{ url('/ampera') }}" 
               class="block w-full ps-3 pe-4 py-2 border-l-4 text-start text-base font-medium transition duration-150 ease-in-out {{ request()->is('ampera') ? 'border-blue-700 text-blue-700 bg-blue-50' : 'border-transparent text-gray-600 hover:text-gray-800 hover:bg-gray-50 hover:border-gray-300' }}">
                AMPERA
            </a>

            <a href="{{ url('/login') }}" 
               class="mt-2 block w-full ps-3 pe-4 py-2 border-l-4 text-start text-base font-semibold transition duration-150 ease-in-out border-blue-700 text-blue-700 bg-blue-50 hover:bg-blue-100">
                Login
            </a>

            <a href="{{ url('/register') }}" 
               class="mt-1 block w-full ps-3 pe-4 py-2 border-l-4 text-start text-base font-semibold transition duration-150 ease-in-out border-transparent text-white bg-blue-700 hover:bg-blue-800">
                Sign Up
            </a>
        </div>
    </div>
</nav>
<style>[x-cloak]{display:none !important;}</style>
<script defer src="https://unpkg.com/alpinejs@3.12.0/dist/cdn.min.js"></script>