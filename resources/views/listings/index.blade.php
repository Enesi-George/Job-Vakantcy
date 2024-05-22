{{-- @extends('layout')

@section('content') --}}
<x-layout>

    @include('partials._hero')
    @include('partials._search')
    
    <div class="lg:grid lg:grid-cols-3 gap-4 space-y-4 md:space-y-0 mx-4">
        {{-- Listings Container --}}
        <div class="lg:col-span-2">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                @unless (count($listings->filter(fn($listing) => $listing->is_verified)) == 0)
                @foreach($listings as $index => $listing)
                    {{-- IMPORTING COMPONENT --}}
                    <x-listing-card :listing="$listing" />

                    {{-- Insert ads div every 4th card --}}
                    @if (($index + 1) % 4 == 0)
                        <div class="md:col-span-2 lg:col-span-1 mt-6 p-4 bg-gray-100">
                            ads space
                        </div>
                    @endif
                @endforeach
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
    
    {{-- Uncomment the following line if you want to display pagination links --}}
    {{-- <div class="mt-6 p-4">
        {{ $listings->links() }}
    </div> --}}
    </x-layout>
    
    {{-- @endsection --}}
    