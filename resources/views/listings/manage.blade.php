<x-layout>
    <x-card class="p-10">

        <a href="/user/edit">
            <h1 class="text-lg text-left font-bold my-4 uppercase cursor-pointer hover:text-laravel transition duration-300">
                Manage Account
            </h1>
        </a>

        <header>
            <h1 class="text-lg text-left font-bold my-4 uppercase cursor-pointer hover:text-laravel transition duration-300" id="manage-posts-toggle">
                Manage Post
                <i class="fa-solid fa-chevron-down ml-2" id="toggle-icon"></i>
            </h1>
        </header>

        <div id="manage-posts-content" class="hidden">
            <table class="w-full table-auto rounded-sm">
                <tbody>
                    @unless ($listings->isEmpty())
                        @foreach ($listings as $listing)
                            <tr class="border-gray-300">
                                <td class="px-4 py-8 border-t border-b border-gray-300 text-lg">
                                    <a href="show.html">
                                        {{ $listing->title }}
                                    </a>
                                </td>
                                <td class="px-4 py-8 border-t border-b border-gray-300 text-lg">
                                    <a href="/listings/{{ $listing->id }}/edit" class="text-blue-400 px-6 py-2 rounded-xl">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                        Edit
                                    </a>
                                </td>
                                <td class="px-4 py-8 border-t border-b border-gray-300 text-lg">
                                    <form method="POST" action="/listings/{{ $listing->id }}/delete">
                                        @csrf
                                        @method('DELETE')
                                        <button class="text-red-500">
                                            <i class="fa-solid fa-trash"></i>
                                            Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr class="border-grey-300">
                            <td class="px-4 py-8 border-t border-b border-grey-300 text-lg">
                                <p class="text-center">No Listings Found</p>
                            </td>
                        </tr>
                    @endunless
                </tbody>
            </table>
        </div>
    </x-card>
</x-layout>
