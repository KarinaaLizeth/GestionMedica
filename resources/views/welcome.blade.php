<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">

    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="{{ asset('css/welcome.css') }}">
</head>
<body class="antialiased">
    <nav class="bg-white dark:bg-gray-900 fixed w-full z-20 top-0 start-0 border-b border-gray-200 dark:border-gray-600">
        <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto p-4">
            <a href="#" class="flex items-center space-x-3 rtl:space-x-reverse">
                <img src="{{ asset('images/logo.png') }}" class="h-8" alt="Health Plus Logo">
                <span class="self-center text-2xl font-semibold whitespace-nowrap dark:text-white">Health Plus</span>
            </a>
            <div class="flex md:order-2 space-x-3 md:space-x-0 rtl:space-x-reverse">
                <a href="{{ route('login') }}" class="text-black hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" style="background-color: #daffef; transition: background-color 0.3s;" onmouseover="this.style.backgroundColor='#247b7b'" onmouseout="this.style.backgroundColor='#daffef'">Iniciar Sesión</a>
                <a href="{{ route('register') }}" class="text-black hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 button-spacing" style="background-color: #daffef; transition: background-color 0.3s;" onmouseover="this.style.backgroundColor='#247b7b'" onmouseout="this.style.backgroundColor='#daffef'">Crear Cuenta</a>
            </div>
        </div>
    </nav>

    <header class="hero-section">
        <div class="content">
            <h1>BIENVENIDO</h1>
        </div>
        <div class="image">
            <img src="{{ asset('images/imagen.png') }}" alt="Health Expert">
        </div>
    </header>
</body>
</html>
