@extends('layouts.app')

@section('title', 'Lista de Livros')

@section('content')
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-semibold text-gray-700">Lista de Livros</h1>
        <a href="{{ route('books.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
            Novo Livro
        </a>
    </div>

    <table class="min-w-full bg-white">
        <thead class="bg-gray-800 text-white">
        <tr>
            <th class="w-1/3 text-left py-3 px-4 uppercase font-semibold text-sm">Título</th>
            <th class="w-1/3 text-left py-3 px-4 uppercase font-semibold text-sm">Autor</th>
            <th class="text-left py-3 px-4 uppercase font-semibold text-sm">Data de Publicação</th>
            <th class="text-left py-3 px-4 uppercase font-semibold text-sm">Ações</th>
        </tr>
        </thead>
        <tbody class="text-gray-700">
        @forelse ($books as $book)
            <tr>
                <td class="w-1/3 text-left py-3 px-4">{{ $book->title }}</td>
                <td class="w-1/3 text-left py-3 px-4">{{ $book->author->name }}</td>
                <td class="text-left py-3 px-4">{{ $book->publication_date->format('d/m/Y') }}</td>
                <td class="text-left py-3 px-4">
                    <a href="{{ route('books.show', $book) }}" class="text-blue-600 hover:text-blue-900 mr-2">Ver</a>
                    <a href="{{ route('books.edit', $book) }}" class="text-yellow-600 hover:text-yellow-900 mr-2">Editar</a>
                    <form action="{{ route('books.destroy', $book) }}" method="POST" class="inline-block" onsubmit="return confirm('Tem certeza que deseja excluir este livro?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-600 hover:text-red-900">Excluir</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="4" class="text-center py-4">Nenhum livro encontrado.</td>
            </tr>
        @endforelse
        </tbody>
    </table>
    <div class="mt-6">
        {{ $books->links() }}
    </div>
@endsection