<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <x-application-logo class="block h-9 w-auto fill-current text-gray-800" />
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    @can('view dashboard')
                        <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                            {{ __('Dashboard') }}
                        </x-nav-link>
                    @endcan

                    @can('manage ampera')
                        <x-nav-link :href="route('admin.ampera.dashboard')" :active="request()->routeIs('admin.ampera.dashboard')">
                            {{ __('Pendaftar') }}
                        </x-nav-link>
                        <x-nav-link :href="route('admin.attendance')" :active="request()->routeIs('admin.attendance')">
                            {{ __('Absensi') }}
                        </x-nav-link>
                        <x-nav-link :href="route('admin.scan')" :active="request()->routeIs('admin.scan')">
                            {{ __('Scan QR') }}
                        </x-nav-link>
                        <x-nav-link :href="route('members.index')" :active="request()->routeIs('members.*')">
                            {{ __('Data Panitia') }}
                        </x-nav-link>
                        <x-nav-link :href="route('meetings.index')" :active="request()->routeIs('meetings.*')">
                            {{ __('Manajemen Rapat') }}
                        </x-nav-link>
                    @endcan

                    @can('manage imp')
                        <x-nav-link :href="route('admin.imp.stat')" :active="request()->routeIs('admin.imp.stat')">
                            {{ __('Statistik IMP') }}
                        </x-nav-link>
                        <x-nav-link :href="route('admin.imp.list')" :active="request()->routeIs('admin.imp.list')">
                            {{ __('Daftar Fungsionaris') }}
                        </x-nav-link>
                        <x-nav-link :href="route('divisions.index')" :active="request()->routeIs('divisions.*')">
                            {{ __('Divisi') }}
                        </x-nav-link>
                        <x-nav-link :href="route('programs.index')" :active="request()->routeIs('programs.*')">
                            {{ __('Program Kerja') }}
                        </x-nav-link>
                        <x-nav-link :href="route('socials.index')" :active="request()->routeIs('socials.*')">
                            {{ __('Sosmed') }}
                        </x-nav-link>
                    @endcan

                    @role('super-admin')
                        <x-nav-link :href="route('role.index')" :active="request()->routeIs('role.*')">
                            {{ __('Role Manage') }}
                        </x-nav-link>
                        <x-nav-link :href="route('users.index')" :active="request()->routeIs('users.*')">
                            {{ __('User Manage') }}
                        </x-nav-link>
                        <x-nav-link :href="route('periods.index')" :active="request()->routeIs('periods.*')">
                            {{ __('Periode') }}
                        </x-nav-link>
                        <x-nav-link :href="route('admin.comites.index')" :active="request()->routeIs('admin.comites.*')">
                            {{ __('Kepanitiaan') }}
                        </x-nav-link>
                    @endrole

                    @role('fungsio')
                        <x-nav-link :href="route('fungsio.profile.edit')" :active="request()->routeIs('fungsio.profile.*')">
                            {{ __('Profil') }}
                        </x-nav-link>
                        <x-nav-link :href="route('fungsio.list')" :active="request()->routeIs('fungsio.list')">
                            {{ __('Daftar Fungsionaris') }}
                        </x-nav-link>
                        <x-nav-link :href="route('fungsio.comite.index')" :active="request()->routeIs('fungsio.comite.*')">
                            {{ __('Kepanitiaan') }}
                        </x-nav-link>
                    @endrole

                    @can('manage sisemar')
                        <x-nav-link :href="route('admin.sisemar.index')" :active="request()->routeIs('admin.sisemar.*')">
                            {{ __('Home Si Semar') }}
                        </x-nav-link>
                        <x-nav-link :href="route('admin.sisemar.attendance.scan')"
                            :active="request()->routeIs('admin.sisemar.attendance.scan')">
                            {{ __('Absen Hari H') }}
                        </x-nav-link>
                        <x-nav-link :href="route('admin.sisemar.attendance.recap')"
                            :active="request()->routeIs('admin.sisemar.attendance.recap')">
                            {{ __('Recap Hari H') }}
                        </x-nav-link>
                    @endcan
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button
                            class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                            <div>{{ Auth::user()->name }}</div>

                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')" onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open"
                    class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex"
                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            @can('view dashboard')
                <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                    {{ __('Dashboard') }}
                </x-responsive-nav-link>
            @endcan

            @can('manage ampera')
                <x-responsive-nav-link :href="route('admin.ampera.dashboard')" :active="request()->routeIs('admin.ampera.dashboard')">
                    {{ __('Pendaftar') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.attendance')" :active="request()->routeIs('admin.attendance')">
                    {{ __('Absensi') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.scan')" :active="request()->routeIs('admin.scan')">
                    {{ __('Scan QR') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('members.index')" :active="request()->routeIs('members.*')">
                    {{ __('Data Panitia') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('meetings.index')" :active="request()->routeIs('meetings.*')">
                    {{ __('Manajemen Rapat') }}
                </x-responsive-nav-link>
            @endcan

            @can('manage imp')
                <x-responsive-nav-link :href="route('admin.imp.stat')" :active="request()->routeIs('admin.imp.stat')">
                    {{ __('Statistik IMP') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.imp.list')" :active="request()->routeIs('admin.imp.list')">
                    {{ __('Daftar Fungsionaris') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('divisions.index')" :active="request()->routeIs('divisions.*')">
                    {{ __('Divisi') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('programs.index')" :active="request()->routeIs('programs.*')">
                    {{ __('Program Kerja') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('socials.index')" :active="request()->routeIs('socials.*')">
                    {{ __('Sosmed') }}
                </x-responsive-nav-link>
            @endcan

            @role('super-admin')
                <x-responsive-nav-link :href="route('role.index')" :active="request()->routeIs('role.*')">
                    {{ __('Role Manage') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('users.index')" :active="request()->routeIs('users.*')">
                    {{ __('User Manage') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('periods.index')" :active="request()->routeIs('periods.*')">
                    {{ __('Periode') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.comites.index')" :active="request()->routeIs('admin.comites.*')">
                    {{ __('Kepanitiaan') }}
                </x-responsive-nav-link>
            @endrole

            @role('fungsio')
                <x-responsive-nav-link :href="route('fungsio.profile.edit')" :active="request()->routeIs('fungsio.profile.*')">
                    {{ __('Profil') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('fungsio.list')" :active="request()->routeIs('fungsio.list')">
                    {{ __('Daftar Fungsionaris') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('fungsio.comite.index')" :active="request()->routeIs('fungsio.comite.*')">
                    {{ __('Kepanitiaan') }}
                </x-responsive-nav-link>
            @endrole

            @can('manage sisemar')
                <x-responsive-nav-link :href="route('admin.sisemar.index')" :active="request()->routeIs('admin.sisemar.*')">
                    {{ __('Home Si Semar') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.sisemar.attendance.scan')"
                    :active="request()->routeIs('admin.sisemar.attendance.scan')">
                    {{ __('Absen Hari H') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.sisemar.attendance.recap')"
                    :active="request()->routeIs('admin.sisemar.attendance.recap')">
                    {{ __('Recap Hari H') }}
                </x-responsive-nav-link>
            @endcan
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')" onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>