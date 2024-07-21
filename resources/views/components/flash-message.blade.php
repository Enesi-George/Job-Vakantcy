@if (session()->has('error'))
<div x-data="{show: true}" x-init="setTimeout(() => show = false, 3000)" x-show="show" class="fixed top-0 left-1/2 transform -translate-x-1/2 rounded-md bg-red-500 text-center text-white px-4 py-3 flex items-center">
    <i class="fas fa-exclamation-circle mr-2"></i>
    <p class="w-full">
        {{ session('error') }}
    </p>
</div>
@elseif (session()->has('message'))
<div x-data="{show: true}" x-init="setTimeout(() => show = false, 3000)" x-show="show" class="fixed top-0 left-1/2 transform -translate-x-1/2 bg-black text-center text-white px-4 py-3 rounded-md flex items-center">
    <i class="fas fa-check-circle mr-2"></i>
    <p class="w-full">
        {{ session('message') }}
    </p>
</div>
@endif

{{-- @if (session()->has('message'))

    <div x-data="{show: true}" x-init="setTimeout(() => show = false, 3000)" x-show="show" class="fixed top-0 left-1/2 transform -translate-x-1/2 bg-laravel text-white px-4 py-3">
    <p class="w-full">
        {{ session('message') }}
    </p>
    </div>
@endif --}}