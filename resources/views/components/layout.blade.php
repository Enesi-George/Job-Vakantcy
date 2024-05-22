<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link rel="icon" href="images/favicon.ico" />
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
        <title>JobVakantcy | Find your next career Jobs & Projects</title>
    </head>
    <body class="">
        @include('adspace._top_page')
        @include('components.nav')     
        <hr>

    <x-flash-message/>
    {{-- VIEW OUPUT --}}
    
    <main>    
        {{ $slot }}
    </main>
<footer
class="bottom-0 left-0 w-full flex items-center justify-start font-bold bg-laravel text-white h-24 mt-24 opacity-90 md:justify-center"
>
<p class="ml-2">Copyright &copy; 2024, All Rights reserved</p>

<a
    href="/listings/create"
    class="absolute right-10 bg-black text-white py-2 px-5 rounded-lg transition hover:opacity-90 duration-200"
    >Post Job</a
>
</footer>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const dropdownToggle = document.getElementById("dropdown-toggle");
        const dropdownMenu = document.getElementById("dropdown-menu");
        const body = document.body;

        dropdownToggle.addEventListener("click", function () {
            dropdownMenu.classList.toggle("hidden");
            body.classList.toggle("overflow-hidden");
        });
    });
</script>
</body>
</html>