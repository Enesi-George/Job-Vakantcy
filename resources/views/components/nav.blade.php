
<nav class="flex justify-between items-center px-8">
    <a href="/" class="flex pb-1">
        <img class="w-12 md:w-24" src="{{ asset('images/briefcase.png') }}" alt="Logo">
        @if (!Request::is('/'))
            <h1 class="text-3xl md:text-6xl font-bold uppercase text-white my-auto drop-shadow-md">
                <span class="hover-switch">
                    <span class="text-red-500 transition-colors duration-300 ease-in-out job">Job</span>
                    <span class="text-gray-800 transition-colors duration-300 ease-in-out vakantcy">Vakanty</span>
                </span>
            </h1>
            
        @endif
    </a>
    <ul class="flex space-x-6 mr-6 text-lg hidden lg:flex">
        @auth
            <span class="font-bold uppercase hidden md:inline">Welcome {{ auth()->user()->name }}!</span>
            <li>
                <a href="/listings/manage" class="hover:text-laravel transition duration-300"  onclick="showSpinner()">
                    <i class="fa-solid fa-gear"></i> Settings
                </a>
            </li>
            <li>
                <form class="inline" method="POST" action="/logout">
                    @csrf
                    <button type="submit" >
                        <i class="fa-solid fa-door-closed"></i> Logout
                    </button>
                </form>
            </li>
        @else
            <li>
                <a href="/register" class="hover:text-laravel transition duration-300">
                    <i class="fa-solid fa-user-plus"></i> Register
                </a>
            </li>
            <li>
                <a href="/login" class="hover:text-laravel transition  duration-300">
                    <i class="fa-solid fa-arrow-right-to-bracket"></i> Login
                </a>
            </li>
        @endauth
    </ul>

    <!-- Collapsible Dropdown Icon -->
      <div id="dropdown-toggle" class="lg:hidden border border-1 py-2 px-6 rounded-lg cursor-pointer hover:bg-slate-200 hover:border-none hover:text-slate-600 transition duration-300  ">
        <button class="focus:outline-none text-2xl">
            <i class="fa-solid fa-bars"></i>
        </button>
    </div>
</nav>

<!-- Mobile Dropdown Menu -->
<div id="dropdown-menu" class="hidden fixed inset-0 flex justify-end z-50">
    <div class="bg-black opacity-50 w-full" id="drawer-overlay"></div>
    <div class="bg-white w-3/4 max-w-xs p-4 shadow-lg">
        <!-- Close Button -->
        <button id="dropdown-close" class="absolute top-0 right-0 mb-4 mr-4 text-gray-600 hover:text-laravel focus:outline-none transition duration-300">
            <i class="fas fa-times"></i>
        </button>
        <ul class="flex flex-col space-y-4 py-2 px-4">
            @auth
                <span class="font-bold uppercase text-xs">Welcome {{ auth()->user()->name }}!</span>
                <li>
                    <a href="/listings/manage" class="hover:text-laravel transition duration-300">
                        <i class="fa-solid fa-gear"></i> Settings
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
                    <a href="/register" class="hover:text-laravel transition duration-300">
                        <i class="fa-solid fa-user-plus"></i> Register
                    </a>
                </li>
                <li>
                    <a href="/login" class="hover:text-laravel transition duration-300">
                        <i class="fa-solid fa-arrow-right-to-bracket"></i> Login
                    </a> 
                </li>
            @endauth
        </ul>
    </div>
</div>
