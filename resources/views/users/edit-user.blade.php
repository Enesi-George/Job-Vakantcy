<x-layout>
    <a href="javascript:window.history.back();" class="inline-block text-white bg-gray-800 ml-4 mb-4 mt-8 py-2 px-4 rounded-lg transition hover:opacity-80 duration-200"
    ><i class="fa-solid fa-arrow-left"></i> Back
    </a>
    <x-card class="p-10 rounded max-w-lg mx-auto mt-12">

        <header class="text-center my-5">
            <h2 class="text-2xl font-bold uppercase mb-1">
                Edit Profile
            </h2>
        </header>

        <form action="/user/update" method="post" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="flex ">
                <div class="mb-6 mr-6 ">
                    <label for="name" class="inline-block text-lg mb-2">Name</label>
                    <input
                        type="text"
                        class="border border-gray-200 rounded p-2 w-full"
                        name="name"
                        id="name"
                        value="{{ old('name',  $user->name) }}"
                    />
                    @error('name')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                    <p id="nameError" class="text-red-500 text-xs mt-1" style="display:none;">Name must be in 'John Doe' format.</p>
                </div>
    
                <div class="mb-6 ">
                    <label for="email" class="inline-block text-lg mb-2">Email</label>
                    <input
                        type="email"
                        class="border border-gray-200 rounded p-2 w-full text-slate-400 cursor-not-allowed"
                        name="email"
                        id="email"
                        disabled
                        value="{{ old('email',  $user->email) }}"
                    />
                    @error('email')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="flex justify-center align-center mb-6 w-full">
                <button type="submit" class="bg-gray-800 rounded-lg text-white rounded py-2 w-1/2 hover:opacity-80 duration-200">
                    Update
                </button>
            </div>        
        </form>
        <hr class="mb-4">

        <form action="/user/reset-password" method="post" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <header class="text-left">
                <h2 class="text-lg font-bold uppercase mb-1">
                    Change Password
                </h2>
            </header>

            <div class="flex">
                <div class="mb-6 relative mr-6">
                    <label for="password" class="inline-block text-lg mb-2">Password</label>
                    <input
                        type="password"
                        class="border border-gray-200 rounded p-2 pr-8 w-full"
                        name="password"
                        id="password"
                    />
                    <i class="fa fa-eye absolute right-3 cursor-pointer" id="togglePassword" onclick="togglePasswordVisibility('password')"></i>
                    @error('password')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                    <p id="passwordError" class="text-red-500 text-xs mt-1" style="display:none;">
                        Password must be at least 8 characters, include an uppercase letter, a lowercase letter, a digit, and a special character.
                    </p>
                </div>
    
                <div class="mb-6 relative">
                    <label for="password_confirmation" class="inline-block text-lg mb-2">Confirm Password</label>
                    <input
                        type="password"
                        class="border border-gray-200 rounded p-2 pr-8 w-full"
                        name="password_confirmation"
                        id="password_confirmation"
                    />
                    <i class="fa fa-eye absolute right-3 cursor-pointer" id="togglePasswordConfirmation" onclick="togglePasswordVisibility('password_confirmation')"></i>
                    @error('password_confirmation')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>


            <div class="flex justify-center align-center mb-6 w-full">
                <button type="submit" class="bg-gray-800 rounded-lg text-white rounded py-2 w-1/2 hover:opacity-80 duration-200">
                    Change Password
                </button>
            </div>  
        </form>
        <hr class="mb-4">
        <form action="/user/resend-verify-email" method="get">
            <header class="text-left mb-3">
                <h2 class="text-lg font-bold uppercase ">
                    Account Verification
                </h2>
            </header>            
            <div class="flex justify-center align-center mb-6 w-full">
                <button type="submit" class="bg-gray-800 rounded-lg text-white rounded py-2 w-1/2 hover:opacity-80 duration-200">
                    Click to Verify
                </button>
            </div>
        
        </form>
    </x-card>
</x-layout>
