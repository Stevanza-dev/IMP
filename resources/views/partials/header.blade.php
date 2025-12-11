<nav class="bg-white fixed w-full z-50 top-0 start-0 border-b border-gray-200 shadow-sm transition-all duration-300">
    <div class="max-w-7xl mx-auto flex flex-wrap items-center justify-between p-4">
        <a href="{{ url('/') }}" class="flex items-center space-x-3 rtl:space-x-reverse">
            <img src="{{ asset('images/logonocap.png') }}" class="h-10 w-10" alt="IMP Logo">
            <span class="self-center text-xl font-bold whitespace-nowrap text-blue-900 tracking-tight">
                IMP UNNES
            </span>
        </a>

        <button data-collapse-toggle="navbar-sticky" type="button" class="inline-flex items-center p-2 w-10 h-10 justify-center text-sm text-gray-500 rounded-lg md:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200" aria-controls="navbar-sticky" aria-expanded="false">
            <span class="sr-only">Open main menu</span>
            <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 17 14">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 1h15M1 7h15M1 13h15"/>
            </svg>
        </button>

        <div class="items-center justify-between hidden w-full md:flex md:w-auto md:order-1" id="navbar-sticky">
            <ul class="flex flex-col p-4 md:p-0 mt-4 font-medium border border-gray-100 rounded-lg bg-gray-50 md:space-x-8 rtl:space-x-reverse md:flex-row md:mt-0 md:border-0 md:bg-white">
                <li>
                    <a href="{{ url('/') }}" class="block py-2 px-3 rounded md:p-0 font-bold {{ request()->is('/') ? 'text-white bg-blue-700 md:bg-transparent md:text-blue-700' : 'text-gray-900 hover:bg-gray-100 md:hover:bg-transparent md:hover:text-blue-700 transition' }}" aria-current="page">Home</a>
                </li>
                <li>
                    <a href="{{ url('/about') }}" class="block py-2 px-3 rounded md:p-0 transition {{ request()->is('about') ? 'text-white bg-blue-700 md:bg-transparent md:text-blue-700 font-bold' : 'text-gray-900 hover:bg-gray-100 md:hover:bg-transparent md:hover:text-blue-700' }}">About</a>
                </li>
                <li>
                    <a href="{{ url('/activity') }}" class="block py-2 px-3 rounded md:p-0 transition {{ request()->is('activity') ? 'text-white bg-blue-700 md:bg-transparent md:text-blue-700 font-bold' : 'text-gray-900 hover:bg-gray-100 md:hover:bg-transparent md:hover:text-blue-700' }}">Activity</a>
                </li>
                <li>
                    <a href="{{ url('/sisemar') }}" class="block py-2 px-3 rounded md:p-0 transition {{ request()->is('sisemar') ? 'text-white bg-blue-700 md:bg-transparent md:text-blue-700 font-bold' : 'text-gray-900 hover:bg-gray-100 md:hover:bg-transparent md:hover:text-blue-700' }}">SI SEMAR</a>
                </li>
                <li>
                    <a href="{{ url('/ampera') }}" class="block py-2 px-3 rounded md:p-0 transition {{ request()->is('ampera') ? 'text-white bg-blue-700 md:bg-transparent md:text-blue-700 font-bold' : 'text-gray-900 hover:bg-gray-100 md:hover:bg-transparent md:hover:text-blue-700' }}">AMPERA</a>
                </li>
                <li>
                     <a href="{{ route('login') }}" class="text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 text-center ml-2">Login</a>
                </li>
            </ul>
        </div>
    </div>
</nav>