{{-- @extends('layout')

@section('content') --}}

<x-layout>


<a href="/" class="inline-block text-white bg-gray-800 ml-4 mb-4 mt-8 py-2 px-4 rounded-lg transition hover:opacity-80 duration-200"
><i class="fa-solid fa-arrow-left"></i> Back
</a>

<div class="lg:grid lg:grid-cols-3 gap-4 space-y-4 md:space-y-0 mx-4">

    <div class="lg:col-span-2">
        <x-card>
            <div
                class="flex flex-col items-left justify-left "
            >
            <div class="flex flex-col items-center justify-center">

                <img
                    class="w-48 mr-6 mb-6 "
                    src="{{ $listing->logo ? $listing->logo : asset('/images/briefcase.png') }}"
                    alt=""
                />

                <h3 class="text-2xl mb-2">{{ $listing->title }}</h3>
                <div class="text-xl font-bold mb-2">{{ $listing->company }}</div>
                @if ($listing->salary == null)
                <div class="flex">
                    <p class="font-bold my-auto">Salary: </p>
                    <p class="text-lg m-2"> Unspecified</p>
                </div>
                @else
                <div class="text-sm font-bold mb-4"> &#8358; {{ $listing->salary }}</div>

                @endif

                    <x-listing-tags :tagsCsv="$listing->tags" />
                <div class="text-lg my-4 mb-2">
                    <i class="fa-solid fa-location-dot"></i> {{ $listing->location }}
                </div>
            </div>
            <div class="border border-gray-200  mb-6"></div>

            
                <div class="my-4">
                    <h3 class="text-3xl font-bold mb-4 ">
                        Job Description
                    </h3>
                    <div class="text-lg w-full space-y-6">
                        <p class="text-left">
                            {{ $listing->description }}
                        </p>
                    </div>
                </div>
                    <div>
                        <h3 class="text-3xl font-bold mb-4 ">
                            Requirements
                        </h3>
                        <div class=" w-full space-y-6">
                            <x-requirements :requirementCsv="$listing->requirements" />
                        </div>

                        <div class="flex my-4">
                            <h3 class="text-3xl font-bold mb-4 ">
                                Deadline:</h3> 

                                @if ($listing->deadline == null)
                                <p class="text-lg m-2"> Unspecified</p>
                                @else
                                <p class="text-lg m-2">{{$listing->deadline}}</p>
                                @endif
                        </div>

                    </div>
                <div class="mx-auto width w-1/2 space-y-6 mb-6 text-center">
                    <a
                    href="mailto:{{ $listing->email }}"
                    class="block bg-laravel text-white mt-6 py-2 rounded-xl hover:opacity-80 transition duration-200"
                    ><i class="fa-solid fa-envelope"></i>
                    Contact Employer</a>

                    <a
                        href="{{ $listing->website }}"
                        target="_blank"
                        class="block bg-black text-white py-2 rounded-xl hover:opacity-80 transition duration-200"
                        ><i class="fa-solid fa-globe"></i> Visit
                        Website</a >
                </div>
            </div>
        </x-card>
        @auth
            @if(auth()->id() == $listing->user_id || in_array( auth()->user()->role, ['admin', 'super-admin']))
                <x-card class="mt-4 p-2 flex space-x-6">
                    <a href="/listings/{{ $listing->id }}/edit" class="hover:opacity-80 transition duration-200">
                        <i class="fa-solid fa-pencil"></i> Edit
                    </a>
                
                    <form method="POST" action="/listings/{{ $listing->id }}/delete">
                        @csrf
                        @method('DELETE')
                        <button class="text-red-500 hover:opacity-80 transition duration-200">
                            <i class="fa-solid fa-trash"></i> Delete
                        </button>
                    </form>

                    @if(in_array(auth()->user()->role, ['admin', 'super-admin']) && !$listing->is_verified)
                    <form method="POST" action="/listings/{{$listing->id}}/approve" >
                        @csrf
                        @method('PUT')
                        <button class="hover:opacity-80 transition duration-200 text-red-700 font-semibold"> 
                            <span >&#10008;</span><span >Approve</span>
                        </button>
                    </form>

                    @elseif (in_array(auth()->user()->role, ['admin', 'super-admin']) && $listing->is_verified)
                            <button class="hover:opacity-80 transition duration-200 text-green-700 font-semibold"> 
                        <span >&check;</span><span >Approved</span>
                    </button>
                    @endif
                </x-card>


            @endif
        @endauth


    </div>

      {{-- Ads Space --}}
      <div class="mt-6 p-4 bg-gray-100 lg:col-span-1 lg:mt-0">
        Ads space
    </div>
</div>

</x-layout>

{{-- @endsection --}}