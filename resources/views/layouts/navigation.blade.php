<!-- filepath: resources/views/layouts/navigation.blade.php -->
<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex space-x-8">
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('admin.dashboard') }}" class="text-xl font-bold text-gray-800">
                        <img src="{{ asset('https://res.cloudinary.com/dcbryptkx/image/upload/v1765004406/itech-warranty-qr/LogoItech_z57jdx.png') }}" alt="itech Logo" class="inline h-8 w-auto mr-2">
                    </a>
                </div>

                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    <x-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')">
                        {{ __('Dashboard') }}
                    </x-nav-link>

                    <x-nav-link :href="route('admin.products.index')" :active="request()->routeIs('admin.products.*')">
                        {{ __('Produk') }}
                    </x-nav-link>

                    <!-- Warehouse Dropdown -->
                    <div class="hidden sm:flex sm:items-center sm:ml-0">
                        <x-dropdown align="left" width="48">
                            <x-slot name="trigger">
                                <button class="inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium leading-5 transition duration-150 ease-in-out {{ request()->routeIs('admin.warehouse.*') ? 'border-indigo-400 text-gray-900 focus:border-indigo-700' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:text-gray-700 focus:border-gray-300' }}">
                                    <div>Warehouse</div>
                                    <div class="ms-1">
                                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                </button>
                            </x-slot>

                            <x-slot name="content">
                                <x-dropdown-link :href="route('admin.warehouse.received.index')">
                                    Produk Diterima
                                </x-dropdown-link>
                                <x-dropdown-link :href="route('admin.warehouse.issued.index')">
                                    Produk Dikeluarkan
                                </x-dropdown-link>
                            </x-slot>
                        </x-dropdown>
                    </div>

                    <x-nav-link :href="route('admin.warranty.index')" :active="request()->routeIs('admin.warranty.*')">
                        {{ __('Verifikasi Garansi') }}
                    </x-nav-link>

                    <x-nav-link :href="route('admin.qr-code.index')" :active="request()->routeIs('admin.qr-code.*')">
                        {{ __('QR Code') }}
                    </x-nav-link>

                    <x-nav-link :href="route('admin.labels.index')" :active="request()->routeIs('admin.labels.*')">
                        {{ __('Label Produk') }}
                    </x-nav-link>
                </div>
            </div>

            <div class="hidden sm:flex sm:items-center sm:ml-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                            <div>{{ Auth::user()->name }}</div>
                            <div class="ml-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Keluar') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <div class="-mr-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>

            <x-responsive-nav-link :href="route('admin.products.index')" :active="request()->routeIs('admin.products.*')">
                {{ __('Products') }}
            </x-responsive-nav-link>

            <!-- Warehouse Mobile Menu -->
            <div class="border-t border-gray-200 pt-2 pb-2">
                <div class="px-4">
                    <div class="text-xs font-semibold text-gray-400 uppercase tracking-wider">
                        Warehouse
                    </div>
                </div>
                <x-responsive-nav-link :href="route('admin.warehouse.received.index')" :active="request()->routeIs('admin.warehouse.received.*')">
                    {{ __('📥 Product Received') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.warehouse.issued.index')" :active="request()->routeIs('admin.warehouse.issued.*')">
                    {{ __('📤 Product Issued') }}
                </x-responsive-nav-link>
            </div>

            <x-responsive-nav-link :href="route('admin.warranty.index')" :active="request()->routeIs('admin.warranty.*')">
                {{ __('Warranty Verification') }}
            </x-responsive-nav-link>

            <x-responsive-nav-link :href="route('admin.qr-code.index')" :active="request()->routeIs('admin.qr-code.*')">
                {{ __('QR Code') }}
            </x-responsive-nav-link>

            <x-responsive-nav-link :href="route('admin.labels.index')" :active="request()->routeIs('admin.labels.*')">
                {{ __('🏷️ Product Labels') }}
            </x-responsive-nav-link>
        </div>

        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')"
                        onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>