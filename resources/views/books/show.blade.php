@extends('layouts.app')

@section('title', 'Detalhes do Livro: ' . $book->title)

@section('content')
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-3xl font-semibold text-gray-800">{{ $book->title }}</h1>
        <a href="{{ route('books.index') }}" class="text-blue-600 hover:text-blue-800 transition-colors duration-300">&larr; Voltar para a lista</a>
    </div>

    <div class="bg-gray-50 p-6 rounded-lg shadow">
        <div class="mb-6 pb-6 border-b border-gray-200">
              @if ($book->cover_image_path)
            <div class="md:w-1/3 mb-4 md:mb-0 flex justify-center md:justify-start">
                <img src="{{ Storage::url($book->cover_image_path) }}" alt="Capa de {{ $book->title }}" class="w-48 h-auto object-cover rounded-lg shadow-md">
            </div>
            @else
            <div class="md:w-1/3 mb-4 md:mb-0 flex justify-center items-center">
                <div class="w-48 h-64 bg-gray-200 flex items-center justify-center rounded-lg text-gray-500">
                    Sem capa
                </div>
            </div>
            @endif
            <h2 class="text-xl font-semibold text-gray-700 mb-2">Detalhes do Livro</h2>
            <dl class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-4">
                <div>
                    <dt class="text-sm font-medium text-gray-500">Título</dt>
                    <dd class="mt-1 text-lg text-gray-900">{{ $book->title }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Autor</dt>
                    <dd class="mt-1 text-lg text-gray-900">{{ $book->author->name }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Data de Publicação</dt>
                    <dd class="mt-1 text-lg text-gray-900">{{ $book->publication_date->format('d/m/Y') }}</dd>
                </div>
            </dl>
        </div>

        <div>
            <h3 class="text-lg font-medium text-gray-700 mb-2">Descrição</h3>
            <p class="text-gray-700 leading-relaxed whitespace-pre-wrap">{{ $book->description }}</p>
        </div>
    </div>

    <div class="mt-8 flex items-center space-x-4">
        <a href="{{ route('books.edit', $book) }}"
           class="bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline transition duration-150 ease-in-out">
            Editar
        </a>
        <form action="{{ route('books.destroy', $book) }}" method="POST" onsubmit="return confirm('Tem certeza que deseja excluir este livro?');">
            @csrf
            @method('DELETE')
            <button type="submit"
                    class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline transition duration-150 ease-in-out">
                Excluir
            </button>
        </form>
    </div>
@endsection