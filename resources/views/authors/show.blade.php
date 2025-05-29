@extends('layouts.app')

@section('title', 'Detalhes do Autor: ' . $author->name)

@section('content')
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-3xl font-semibold text-gray-800">{{ $author->name }}</h1>
        <a href="{{ route('authors.index') }}" class="text-blue-600 hover:text-blue-800 transition-colors duration-300">&larr; Voltar para a lista</a>
    </div>

    <div class="bg-gray-50 p-6 rounded-lg shadow mb-8">
        <h2 class="text-xl font-semibold text-gray-700 mb-4">Detalhes do Autor</h2>
        <dl class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-4">
            <div>
                <dt class="text-sm font-medium text-gray-500">Nome</dt>
                <dd class="mt-1 text-lg text-gray-900">{{ $author->name }}</dd>
            </div>
            <div>
                <dt class="text-sm font-medium text-gray-500">Status</dt>
                <dd class="mt-1 text-lg">
                    @if ($author->status == 'active')
                        <span class="bg-green-200 text-green-700 py-1 px-2 rounded-full text-sm">Ativo</span>
                    @else
                        <span class="bg-red-200 text-red-700 py-1 px-2 rounded-full text-sm">Inativo</span>
                    @endif
                </dd>
            </div>
            <div>
                <dt class="text-sm font-medium text-gray-500">Data de Criação</dt>
                <dd class="mt-1 text-gray-900">{{ $author->created_at->format('d/m/Y H:i:s') }}</dd>
            </div>
            <div>
                <dt class="text-sm font-medium text-gray-500">Última Atualização</dt>
                <dd class="mt-1 text-gray-900">{{ $author->updated_at->format('d/m/Y H:i:s') }}</dd>
            </div>
        </dl>
    </div>

    <div class="mb-8">
        <h3 class="text-xl font-semibold text-gray-700 mb-4">Livros de {{ $author->name }}</h3>
        @if($author->books->count() > 0)
            <ul class="list-disc list-inside bg-gray-50 p-4 rounded-lg shadow">
                @foreach($author->books as $book)
                    <li class="text-gray-800 mb-1">
                        <a href="{{ route('books.show', $book) }}" class="text-blue-600 hover:underline">{{ $book->title }}</a>
                        <span class="text-sm text-gray-500"> (Publicado em: {{ $book->publication_date->format('d/m/Y') }})</span>
                    </li>
                @endforeach
            </ul>
        @else
            <p class="text-gray-600 bg-gray-50 p-4 rounded-lg shadow">Este autor ainda não possui livros cadastrados.</p>
        @endif
    </div>

    <div class="mt-8 flex items-center space-x-4">
        <a href="{{ route('authors.edit', $author) }}"
           class="bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline transition duration-150 ease-in-out">
            Editar Autor
        </a>
        <form action="{{ route('authors.destroy', $author) }}" method="POST" onsubmit="return confirm('Tem certeza que deseja excluir este autor? {{ $author->books->count() > 0 ? 'AVISO: Este autor possui livros associados. A exclusão pode falhar se não for permitida.' : '' }}');">
            @csrf
            @method('DELETE')
            <button type="submit"
                    class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline transition duration-150 ease-in-out">
                Excluir Autor
            </button>
        </form>
    </div>
@endsection