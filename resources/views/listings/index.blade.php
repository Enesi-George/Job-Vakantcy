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

                @unless (count($verifiedListings) == 0 && (!auth()->user() || !auth()->user()->role === 'admin'))
                    @foreach($verifiedListings as $index => $listing)
                        <x-listing-card :listing="$listing" />

                        @if (($index + 1) % 4 == 0)
                            <div class="md:col-span-2 lg:col-span-1 mt-6 p-4 bg-gray-100">
                                ads space
                            </div>
                        @endif
                    @endforeach

                    @if(auth()->user() && auth()->user()->role === 'admin')
                        @foreach($nonVerifiedListings as $index => $listing)
                            <x-listing-card :listing="$listing" />

                            @if (($index + 1) % 4 == 0)
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
        </div>
    
        {{-- Ads Space --}}
        <div class="mt-6 p-4 bg-gray-100 lg:col-span-1 lg:mt-0">
            ads space
        </div>
    </div>
</x-layout>