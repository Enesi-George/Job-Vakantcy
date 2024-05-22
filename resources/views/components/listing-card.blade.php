@props(['listing'])

<x-card>
    <div>
        <p class="text-right mx-8 mb-4">
            <i class="fa-solid fa-clock"></i>
            {{ $listing->updated_at->format('Y-m-d') }}
        </p>        
        <a href="/listings/{{ $listing->id }}" class="block transition ease-in delay-150 hover:-translate-y-1 hover:scale-80 duration-300">
            <div class="flex items-center px-4">
                <div class="flex-shrink-0">
                    <img
                        class="w-24 h-24 md:w-24 md:h-24 rounded-full"
                        src="{{ $listing->logo ? $listing->logo : asset('/images/briefcase.png') }}"
                        alt=""
                    />
                </div>
                <div class="ml-6">
                    <h3 class="text-2xl shrink">
                        {{ $listing->title }}
                    </h3>
                    <div class="text-xl font-bold mb-4">{{ $listing->company }}</div>
    
                    <x-listing-tags :tagsCsv="$listing->tags" />
                        
                    <div class="text-lg mt-4">
                        <i class="fa-solid fa-location-dot"></i> {{$listing->location}}
                    </div>
                </div>
            </div>
        </a>
    </div>
</x-card>
