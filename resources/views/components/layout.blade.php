<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="icon" href="{{asset('images/briefcase.png')}}" />
    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css"
        integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g=="
        crossorigin="anonymous"
        referrerpolicy="no-referrer"
    />
    <script src="//unpkg.com/alpinejs" defer></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        laravel: "#ef3b2d",
                    },
                },
            },
        };
    </script>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;700&display=swap" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <title>JobVakantcy | Find your next career Jobs & Projects</title>
    <style>
        .hidden {
            display: none;
        }

        .spinner .loader {
            border: 8px solid #f3f3f3;
            border-radius: 50%;
            border-top: 8px solid #EF4444;
            width: 60px;
            height: 60px;
            animation: spin 2s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>
</head>
<body x-data>
    <!-- Spinner -->
    <div x-show="$store.loading" class="spinner fixed inset-0 bg-white bg-opacity-75 flex items-center justify-center z-50" style="display: none;">
        <div class="loader"></div>
    </div>
    
    @include('adspace._top_page')
    @include('components.nav')     
    <hr>
        <x-flash-message/>
        <x-validation-error-message/>
        <main class="relative">    
            {{ $slot }}
        </main>
    
        <div class="mt-12 p-4 bg-gray-100 z-0">
            Ads space
        </div>

    <footer
        class="bottom-0 z-10 font-bold bg-laravel text-white px-4 pb-4"
    >
    <div class="left-0 w-full flex  items-center justify-center  opacity-90 md:justify-center"
    >
        <p class="ml-2 mt-5 text-center">Copyright &copy; 2024, All Rights reserved</p>

    </div>
        <div class="mt-2">
            <p class="underline">Advertise with us:</p>
            <p>For Enquiry: jobvakantcy@gmail.com</p>
            <p>Whatsapp: 08185449777</p>
        </div>
    </footer>

    <script src="{{ asset('js/blades.js') }}"></script>
</body>
</html>
