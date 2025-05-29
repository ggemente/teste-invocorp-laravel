<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Gestão de Livros e Autores')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js']) {{-- --}}
</head>
<body class="font-sans antialiased bg-gray-100 text-gray-800">
<div class="container mx-auto mt-8 mb-12 px-4">
    <header class="mb-8">
        <a href="{{ route('books.index') }}">
            <h1 class="text-4xl font-bold text-center text-blue-700 hover:text-blue-800 transition-colors duration-300">
                Gestão de Livros e Autores
            </h1>
        </a>
        <nav class="mt-6 p-4 bg-white shadow-md rounded-lg flex justify-center space-x-6">
            <a href="{{ route('books.index') }}" class="text-lg font-semibold text-gray-700 hover:text-blue-600 transition-colors duration-300 pb-1 border-b-2 {{ request()->routeIs('books.*') ? 'border-blue-500' : 'border-transparent hover:border-blue-300' }}">Livros</a>
            <a href="{{ route('authors.index') }}" class="text-lg font-semibold text-gray-700 hover:text-blue-600 transition-colors duration-300 pb-1 border-b-2 {{ request()->routeIs('authors.*') ? 'border-blue-500' : 'border-transparent hover:border-blue-300' }}">Autores</a>
        </nav>
    </header>

    <div class="my-6">
        @if(session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 shadow-md rounded-lg" role="alert">
                <p class="font-bold">Sucesso!</p>
                <p>{{ session('success') }}</p>
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 shadow-md rounded-lg" role="alert">
                <p class="font-bold">Erro!</p>
                <p>{{ session('error') }}</p>
            </div>
        @endif

        @if($errors->any())
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 shadow-md rounded-lg" role="alert">
                <p class="font-bold">Oops! Algo deu errado.</p>
                <ul class="mt-2 list-disc list-inside text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>

    <main class="bg-white p-6 sm:p-8 shadow-xl rounded-lg">
        @yield('content')
    </main>

    <footer class="text-center text-gray-500 mt-12 text-sm">
        <p>&copy; {{ date('Y') }} Gestão de Livros e Autores. Todos os direitos reservados.</p>
    </footer>
</div>
</body>
</html>