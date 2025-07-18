<nav x-data="{ open: false }" class="wine-navbar border-b" style="background: linear-gradient(90deg, #7b2230 0%, #b85c38 100%);">
    <style>
        .wine-navbar {
            background: linear-gradient(90deg, #7b2230 0%, #b85c38 100%) !important;
            color: #fff !important;
        }
        .wine-navbar a, .wine-navbar .dropdown-link, .wine-navbar .nav-link, .wine-navbar .font-medium {
            color: #fff !important;
        }
        .wine-navbar a:hover, .wine-navbar .dropdown-link:hover, .wine-navbar .nav-link:hover {
            color: #f8e7d1 !important;
        }
        .wine-navbar .wine-logo {
            font-size: 2rem;
            color: #f8e7d1;
            margin-right: 0.5rem;
        }
        .wine-navbar .wine-btn {
            background: #b85c38;
            color: #fff;
            border-radius: 2rem;
            padding: 0.3rem 1.2rem;
            font-weight: bold;
            transition: background 0.2s; hosted online, so it needs to be uploaded to your project's public directory (e.g., public/images/chateau-rouge.jpg).
            Here’s what you should do:
            Save the image as chateau-rouge.jpg in your public/images/ directory.
            Update the image_url for "Chateau Rouge" in RetailerCatalogController.php to:
            Apply to navigation.b...
            Would you like me to update the code to use images/chateau-rouge.jpg as the image path for "Chateau Rouge"? If so, please upload the image to your public/images/ directory, and I’ll handle the code update!
        }
        .wine-navbar .wine-btn:hover {
            background: #7b2230;
            color: #fff;
        }
        .wine-navbar .dropdown-menu {
            background: #fff7f3;
        }
        .cart-icon-container {
            position: relative;
            display: inline-block;
        }
        .cart-count-badge {
            position: absolute;
            top: -8px;
            right: -12px;
            background: #b85c38;
            color: #fff;
            border-radius: 50%;
            padding: 0.25em 0.6em;
            font-size: 1rem;
            font-weight: bold;
            border: 2px solid #fff;
            box-shadow: 0 2px 8px rgba(94,15,15,0.15);
            z-index: 2;
            transition: background 0.2s;
        }
        .cart-icon-container:hover .cart-count-badge {
            background: #7b2230;
        }
        /* Profile photo: 3x size, bolder border */
        .profile-photo-large {
            width: 72px !important;
            height: 72px !important;
            border-width: 6px !important;
            border-color: #c8a97e !important;
            object-fit: cover;
        }
        .profile-photo-placeholder-large {
            width: 72px !important;
            height: 72px !important;
            border-width: 6px !important;
            border-color: #c8a97e !important;
            background: #fff7f3;
            color: #b85c38;
            font-size: 2rem;
            display: flex;
            align-items: center;
            justify-content: center;
        }
    </style>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16 items-center">
            @if(Auth::user() && Auth::user()->hasRole('Retailer'))
                <!-- Retailer Nav: Logo | Centered Links | User -->
                <div class="flex items-center" style="flex:1;">
                    <a href="{{ route('retailer.dashboard') }}" class="flex items-center">
                        <span class="wine-logo"><i class="fas fa-wine-bottle"></i></span>
                    </a>
                </div>
                <div class="flex justify-center items-center gap-5" style="flex:2;">
                    <a href="{{ route('retailer.dashboard') }}" class="d-flex align-items-center fw-bold" style="color:#f8e7d1;">
                        <i class="fas fa-compass me-2"></i> Dashboard
                    </a>
                </div>
                <div class="flex items-center justify-end gap-6" style="flex:1;">
                    <!-- Modern Cart Icon -->
                    @php
                        $cartCount = \App\Models\CartItem::where('user_id', Auth::id())->sum('quantity');
                    @endphp
                    <a href="{{ route('cart.index') }}" class="relative group" style="display:inline-block;">
                        <span class="cart-icon-container">
                            <i class="fas fa-shopping-cart" style="font-size:2.2rem;color:#c8a97e;"></i>
                            <span class="cart-count-badge">{{ $cartCount }}</span>
                        </span>
                    </a>
                    <!-- Profile Dropdown -->
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md wine-btn focus:outline-none transition ease-in-out duration-150">
                                <div class="flex items-center">
                                    @if(Auth::user()?->profile_photo)
                                        <img src="{{ asset('storage/' . Auth::user()->profile_photo) }}?v={{ time() }}"
                                             alt="{{ Auth::user()->name }}"
                                             class="profile-photo-large rounded-full object-cover mr-2 border-2 border-gold">
                                    @else
                                        <div class="profile-photo-placeholder-large rounded-full border-2 border-gold mr-2">
                                            <span class="font-medium">
                                                {{ strtoupper(substr(Auth::user()?->name ?? 'U', 0, 1)) }}
                                            </span>
                                        </div>
                                    @endif
                                    <span class="fw-bold" style="color:#f8e7d1;">{{ Auth::user()?->name }} <span class="text-gold" style="color:#c8a97e;">(Retailer)</span></span>
                                </div>
                                <div class="ms-1">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
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
                                <x-dropdown-link :href="route('logout')"
                                        onclick="event.preventDefault();
                                                    this.closest('form').submit();">
                                    {{ __('Log Out') }}
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                </div>
            @else
                <!-- Default Nav (Admin, etc) -->
                <div class="flex items-center">
                    <!-- Wine Logo -->
                    @if(Auth::user() && Auth::user()->hasRole('Retailer'))
                        <a href="{{ route('retailer.dashboard') }}" class="flex items-center">
                            <span class="wine-logo"><i class="fas fa-wine-bottle"></i></span>
                        </a>
                    @else
                        <a href="{{ route('dashboard') }}" class="flex items-center">
                            <span class="wine-logo"><i class="fas fa-wine-bottle"></i></span>
                        </a>
                    @endif
                    <!-- Navigation Links -->
                    <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                        @if(Auth::user() && Auth::user()->hasRole('Retailer'))
                            <x-nav-link :href="route('retailer.dashboard')" :active="request()->routeIs('retailer.dashboard')">
                                {{ __('Dashboard') }}
                            </x-nav-link>
                            <x-nav-link :href="route('orders.index')" :active="request()->routeIs('orders.index')">
                                {{ __('Orders') }}
                            </x-nav-link>
                            <x-nav-link :href="route('inventory.index')" :active="request()->routeIs('inventory.index')">
                                {{ __('Inventory') }}
                            </x-nav-link>
                            <x-nav-link :href="route('procurement.dashboard')" :active="request()->routeIs('procurement.dashboard')">
                                {{ __('Procurement') }}
                            </x-nav-link>
                            <x-nav-link :href="route('profile.edit')" :active="request()->routeIs('profile.edit')">
                                {{ __('Profile') }}
                            </x-nav-link>
                        @elseif(Auth::user() && Auth::user()->hasRole('Admin'))
                            <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                                {{ __('Dashboard') }}
                            </x-nav-link>
                            <x-nav-link :href="route('procurement.dashboard')" :active="request()->routeIs('procurement.dashboard')">
                                {{ __('Procurement') }}
                            </x-nav-link>
                        @endif
                    </div>
                </div>
                <!-- Settings Dropdown -->
                <div class="hidden sm:flex sm:items-center sm:ms-6">
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md wine-btn focus:outline-none transition ease-in-out duration-150">
                                <div class="flex items-center">
                                    @if(Auth::user()?->profile_photo)
                                        <img src="{{ asset('storage/' . Auth::user()->profile_photo) }}?v={{ time() }}" 
                                             alt="{{ Auth::user()->name }}" 
                                             class="h-8 w-8 rounded-full object-cover mr-2 border-2 border-gray-200">
                                    @else
                                        <div class="h-8 w-8 rounded-full bg-gray-300 flex items-center justify-center mr-2">
                                            <span class="text-gray-600 text-sm font-medium">
                                                {{ strtoupper(substr(Auth::user()?->name ?? 'U', 0, 1)) }}
                                            </span>
                                        </div>
                                    @endif
                                    <span>{{ Auth::user()?->name ?? '' }}</span>
                                </div>
                                <div class="ms-1">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
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
                                <x-dropdown-link :href="route('logout')"
                                        onclick="event.preventDefault();
                                                    this.closest('form').submit();">
                                    {{ __('Log Out') }}
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                </div>
            @endif
            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-white hover:text-gold hover:bg-[#b85c38] focus:outline-none focus:bg-[#b85c38] focus:text-white transition duration-150 ease-in-out">
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
            @if(Auth::user() && Auth::user()->hasRole('Retailer'))
                <x-responsive-nav-link :href="route('retailer.dashboard')" :active="request()->routeIs('retailer.dashboard')">
                    {{ __('Dashboard') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('orders.index')" :active="request()->routeIs('orders.index')">
                    {{ __('Orders') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('inventory.index')" :active="request()->routeIs('inventory.index')">
                    {{ __('Inventory') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('procurement.dashboard')" :active="request()->routeIs('procurement.dashboard')">
                    {{ __('Procurement') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('profile.edit')" :active="request()->routeIs('profile.edit')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>
                @if(Auth::user() && Auth::user()->hasRole('Customer'))
                    <x-responsive-nav-link :href="route('customer.products')" :active="request()->routeIs('customer.products')">
                        {{ __('Products') }}
                    </x-responsive-nav-link>
                @endif
            @elseif(Auth::user() && Auth::user()->hasRole('Admin'))
                <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                    {{ __('Dashboard') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('procurement.dashboard')" :active="request()->routeIs('procurement.dashboard')">
                    {{ __('Procurement') }}
                </x-responsive-nav-link>
            @endif
        </div>
        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gold-200">
            <div class="px-4">
                <div class="flex items-center mb-2">
                    @if(Auth::user()?->profile_photo)
                        <img src="{{ asset('storage/' . Auth::user()->profile_photo) }}?v={{ time() }}" 
                             alt="{{ Auth::user()->name }}" 
                             class="h-10 w-10 rounded-full object-cover mr-3 border-2 border-gray-200">
                    @else
                        <div class="h-10 w-10 rounded-full bg-gray-300 flex items-center justify-center mr-3">
                            <span class="text-gray-600 text-sm font-medium">
                                {{ strtoupper(substr(Auth::user()?->name ?? 'U', 0, 1)) }}
                            </span>
                        </div>
                    @endif
                    <div>
                        <div class="font-medium text-base text-white">{{ Auth::user()?->name ?? '' }}</div>
                        <div class="font-medium text-sm text-gold-200">{{ Auth::user()?->email ?? '' }}</div>
                    </div>
                </div>
            </div>
            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>
                <!-- Authentication -->
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
