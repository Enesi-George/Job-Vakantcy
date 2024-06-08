<x-layout>

    @include('partials._hero')
    @include('partials._search')
   
    <div class="relative w-full">

        <div class="md:grid md:grid-cols-3 gap-4 space-y-4 md:space-y-0 mx-4 relative">
            {{-- Listings Container --}}
            <div class="md:col-span-2">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    {{-- Filter the listings to include only those with verified_at --}}
                    @php
                        $verifiedListings = $listings->filter(fn($listing) => $listing->is_verified);
                    @endphp
    
                    @unless (count($verifiedListings) == 0)
                        @foreach($verifiedListings as $index => $listing)
                            {{-- IMPORTING COMPONENT --}}
                            <x-listing-card :listing="$listing" />
    
                            {{-- Insert ads div every 4th card --}}
                            @if (($index + 1) % 4 == 0)
                                <div class="md:col-span-2 md:col-span-1 mt-6 p-4 bg-gray-100">
                                    ads space
                                </div>
                            @endif
                        @endforeach
                    @else
                        <p class="">No job post found</p>
                    @endunless
                </div>
            </div>
        
            {{-- Ads Space --}}
            <div class="mt-6 p-4 bg-gray-100 md:col-span-1 md:mt-0 hidden md:block">
                <div class="w-full h-full border border-1"> ads spacess</div>
            </div>    
                
        </div> 

        {{-- Video Ads --}}
        <div class="w-1/4 h-1/4 my-2 border border-1 fixed bottom-4 right-4 z-50 bg-white p-4 shadow-lg" x-data="{ show: true }" x-show="show">
            <button @click="show = false" class="absolute top-0 right-0 mt-2 mr-2 text-red-500 text-sm hover:opacity-80 font-bold">X</button>
            video ads
            <iframe src="" frameborder="0" class="w-full h-full"> ads</iframe>
        </div>

        {{-- social media networks --}}
        <div class="social-icon-wrapper w-64 " x-data="{ show: true }" x-show="show">
            <button @click="show = false" class="absolute top-0 right-0 mt-2 mr-2 text-red-500 text-sm hover:opacity-80 font-bold">X</button>
            <ul class="space-y-2 mt-6">
                <li class="text-lg">Join us to get update firstly</li>
                <li><a href="#"> <i class="fa-brands fa-whatsapp fa-beat social-icons" style="color: #075E54"></i> Whatsapp</a></li>
                <li><a href="#"> <i class="fa-brands fa-facebook fa-beat-fade social-icons" style="color: #1877F2"></i>Facebook</a></li>
                <li><a href="#"> <i class="fa-brands fa-twitter fa-beat social-icons" style="color: #1DA1F2"></i>X.com</a></li>
            </ul>
        </div>

    </div>

    
    {{-- Uncomment the following line if you want to display pagination links --}}
    {{-- <div class="mt-6 p-4">
        {{ $listings->links() }}
    </div> --}}
</x-layout>
