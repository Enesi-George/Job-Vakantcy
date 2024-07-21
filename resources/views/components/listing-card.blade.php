@props(['listing'])

<x-card>
    <div>
        <p class="text-right mx-8">
            <i class="fa-solid fa-clock"></i>
            {{ $listing->updated_at->format('Y-m-d') }}
        </p>        
        <a href="/listings/{{ $listing->id }}" class="block transition ease-in delay-150 hover:-translate-y-1 hover:scale-80 duration-300">
            <div class="flex items-center">
                <img
                class="w-28 h-32 md:w-28 md:h-32 "
                src="{{ $listing->logo ? $listing->logo : asset('/images/briefcase.png') }}"
                alt=""
            />

                <div class="ml-6">
                    <h3 class="text-2xl shrink">
                        {{ $listing->title }}
                    </h3>
                    <div class="text-xl font-bold mb-4">{{ $listing->company }}</div>
    
                    <x-listing-tags :tagsCsv="$listing->tags" class="flex-shrink" />
                        
                    <div class="text-lg mt-4">
                        <i class="fa-solid fa-location-dot"></i> {{$listing->location}}
                    </div>
                </div>
            </div>
        </a>
    </div>
</x-card>
