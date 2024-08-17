<x-layout>
    @include('partials._hero')
    @include('partials._search')
    
    <div class="lg:grid lg:grid-cols-3 gap-4 space-y-4 md:space-y-0 mx-4">
        {{-- Listings Container --}}
        <div class="lg:col-span-2">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                @php
                    $verifiedListings = $listings->filter(fn($listing) => $listing->is_verified);
                    $nonVerifiedListings = $listings->filter(fn($listing) => !$listing->is_verified);
                @endphp

                @unless (count($verifiedListings) == 0 && (!auth()->user() || in_array(!auth()->user()->role, ['admin', 'super-admin'])))
                    @foreach($verifiedListings as $index => $listing)
                        <x-listing-card :listing="$listing" />

                        @if (($index + 1) % 3 == 0)
                            <div class="md:col-span-2 lg:col-span-1 mt-6 p-4 bg-gray-100">
                                ads space
                            </div>
                        @endif
                    @endforeach

                    @if(auth()->user() && in_array(auth()->user()->role, ['admin', 'super-admin']))
                        @foreach($nonVerifiedListings as $index => $listing)
                            <x-listing-card :listing="$listing" />

                            @if (($index + 1) % 3 == 0)
                                <div class="md:col-span-2 lg:col-span-1 mt-6 p-4 bg-gray-100">
                                    ads space
                                </div>
                            @endif
                        @endforeach
                    @endif
                @else
                    <p>No listings found</p>
                @endunless
            </div>
        
            <div class="mt-6 p-4 bg-gray-100 md:col-span-1 md:mt-0 hidden md:block">
                <div class="w-full h-full border border-1"> ads space</div>
            </div>    
        </div> 

        {{-- Ads Space --}}
      <div class="mt-6 p-4 bg-gray-100 lg:col-span-1 lg:mt-0">
        Ads space
    </div>

        <div class="w-1/4 h-1/4 my-2 border border-1 w-64 h-32 fixed top-0 right-4 z-50 bg-white p-4 shadow-lg" x-data="{ show: true }" x-show="show">
            <button @click="show = false" class=" no-spinner absolute top-0 right-0 mt-2 mr-2 text-red-500 text-sm hover:opacity-80 font-bold">X</button>
            video ads
            <iframe src="" frameborder="0" class="w-full h-full"> ads</iframe>
        </div>

        <div class="fixed bottom-20 right-4 z-50  w-64" x-data="{ show: true }" x-show="show">
            <button @click="show = false" class=" no-spinner absolute top-0 right-0 mt-2 mr-2 text-red-500 text-sm hover:opacity-80 font-bold">X</button>
            <ul class="space-y-2 mt-6">
                <li class="text-lg">Join us to get update firstly</li>
                <li><a href="https://chat.whatsapp.com/Ft66YC4BgCP1Bb76gk0m5c" target="_blank" class="no-spinner"> <i class="fa-brands fa-whatsapp fa-beat social-icons" style="color: #075E54"></i> Whatsapp</a></li>
                <li><a href="#" class="no-spinner"> <i class="fa-brands fa-facebook fa-beat-fade social-icons" style="color: #1877F2"></i>Facebook</a></li>
                <li><a href="#" class="no-spinner"> <i class="fa-brands fa-twitter fa-beat social-icons" style="color: #1DA1F2"></i>X.com</a></li>
            </ul>
        </div>

        <div class="fixed bottom-40 right-4 w-28 z-50">
            <a
            href="/listings/create"
            class=" right-5 bg-black text-white py-4 font-bold px-5 rounded-lg transition hover:opacity-90 duration-200"
            >Post Job
        </a>
        </div>
    </div>
</x-layout>
