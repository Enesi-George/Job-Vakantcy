<style>
    /* Adjustments to the dropdown menu styles */
    #dropdown-menu {
        position: fixed;
        top: 0;
        right: -100%; /* Initially hidden off the screen */
        bottom: 0;
        width: 75%; /* Adjust as needed */
        max-width: 300px; /* Adjust as needed */
        background-color: white;
        z-index: 1000;
        transition: right 0.3s ease; /* Animation duration and timing function */
        box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
    }

    /* When the dropdown menu is shown, slide in from the right */
    #dropdown-menu:not(.hidden) {
        right: 0;
    }
</style>



<nav class="flex justify-between items-center px-8">
    <a href="/" class="flex pb-1"><img class="w-24" src="{{ asset('images/briefcase.png') }}" alt="Logo"></a>
    <ul class="flex space-x-6 mr-6 text-lg hidden lg:flex">
        @auth                   
            <span class="font-bold uppercase hidden md:inline">
                Welcome {{ auth()->user()->name }}!
            </span>
            <li>
                <a href="/listings/manage" class="hover:text-laravel">
                    <i class="fa-solid fa-gear"></i> Manage Listings
                </a>
            </li>
            <li>
                <form class="inline" method="POST" action="/logout">
                    @csrf
                    <button type="submit">
                        <i class="fa-solid fa-door-closed"></i> Logout
                    </button>
                </form>
            </li>
        @else
            <li>
                <a href="/register" class="hover:text-laravel">
                    <i class="fa-solid fa-user-plus"></i> Register
                </a>
            </li>
            <li>
                <a href="/login" class="hover:text-laravel">
                    <i class="fa-solid fa-arrow-right-to-bracket"></i> Login
                </a>
            </li>
        @endauth

    </ul>

    {{-- Collapsible Dropdown Icon --}}
    <div class="lg:hidden">
        <button id="dropdown-toggle" class="focus:outline-none">
            <i class="fa-solid fa-bars"></i>
        </button>
    </div>
</nav>

        <!-- Mobile Dropdown Menu -->
        <div id="dropdown-menu" class="hidden md:hidden border border-3 border-black-500">
            <ul class="flex flex-col space-y-4 py-2 px-4 bg-gray-100">
                @auth
                    <span class="font-bold uppercase">Welcome {{ auth()->user()->name }}!</span>
                    <li>
                        <a href="/listings/manage" class="hover:text-laravel">
                            <i class="fa-solid fa-gear"></i> Manage Listings
                        </a>
                    </li>
                    <li>
                        <form class="inline" method="POST" action="/logout">
                            @csrf
                            <button type="submit">
                                <i class="fa-solid fa-door-closed"></i> Logout
                            </button>
                        </form>
                    </li>
                @else
                    <li>
                        <a href="/register" class="hover:text-laravel">
                            <i class="fa-solid fa-user-plus"></i> Register
                        </a>
                    </li>
                    <li>
                        <a href="/login" class="hover:text-laravel">
                            <i class="fa-solid fa-arrow-right-to-bracket"></i> Login
                        </a>
                    </li>
                @endauth
            </ul>
        </div>