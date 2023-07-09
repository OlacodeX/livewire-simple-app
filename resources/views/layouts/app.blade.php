<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Livewire</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css"
        integrity="sha256-h20CPZ0QyXlBuAw7A+KluUYx/3pK+c7lYEpqLTlxjYQ=" crossorigin="anonymous" />
    <link rel="stylesheet" href="{{asset('css/app.css')}}">
    @livewireStyles
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    {{-- The script is in the header tag because we are emmitting a function in one of our livewire views and for it to work, the script needs to run first before that view component.--}}
    @livewireScripts
    {{-- Turbolink script to enable spa mode --}}
    <script src="https://cdn.jsdelivr.net/gh/livewire/turbolinks@v0.1.x/dist/livewire-turbolinks.js" data-turbolinks-eval="false" data-turbo-eval="false"></script>
    {{-- <livewire:scripts /> --}}
</head>

<body class="flex flex-wrap justify-center">
    <div class="flex w-full justify-between px-4 bg-purple-900 text-white">
        <a class="mx-3 py-4" href="/">Home</a>
        <a class="mx-3 py-4" href="/counter">Counter</a>
        @auth
        <livewire:logout />
        @endauth
        @guest
        <div class="py-4">
            <a class="mx-3" href="/login">Login</a>
            <a class="mx-3" href="/register">Register</a>
        </div>
        @endguest
    </div>
    <div class="my-10 w-full flex justify-center">
        {{ $slot }}
    </div>
</body>

</html>