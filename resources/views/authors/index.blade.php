@extends('layouts.app')

@section('title', 'Lista de Autores')

@section('content')
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-semibold text-gray-700">Lista de Autores</h1>
        <a href="{{ route('authors.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline transition duration-150 ease-in-out">
            Novo Autor
        </a>
    </div>

    <div class="overflow-x-auto bg-white shadow-md rounded-lg">
        <table class="min-w-full">
            <thead class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
            <tr>
                <th class="py-3 px-6 text-left">Nome</th>
                <th class="py-3 px-6 text-left">Status</th>
                <th class="py-3 px-6 text-left">Livros</th>
                <th class="py-3 px-6 text-center">Ações</th>
            </tr>
            </thead>
            <tbody class="text-gray-700 text-sm font-light">
            @forelse ($authors as $author)
                <tr class="border-b border-gray-200 hover:bg-gray-100">
                    <td class="py-3 px-6 text-left whitespace-nowrap">
                        <a href="{{ route('authors.show', $author) }}" class="font-medium text-blue-600 hover:text-blue-800">{{ $author->name }}</a>
                    </td>
                    <td class="py-3 px-6 text-left">
                        @if ($author->status == 'active')
                            <span class="bg-green-200 text-green-700 py-1 px-3 rounded-full text-xs">Ativo</span>
                        @else
                            <span class="bg-red-200 text-red-700 py-1 px-3 rounded-full text-xs">Inativo</span>
                        @endif
                    </td>
                    <td class="py-3 px-6 text-left">{{ $author->books_count ?? $author->books->count() }}</td> {{-- books_count será populado se usar withCount('books') no controller --}}
                    <td class="py-3 px-6 text-center">
                        <div class="flex item-center justify-center space-x-2">
                            <a href="{{ route('authors.show', $author) }}" class="text-gray-600 hover:text-blue-600 p-1 rounded hover:bg-gray-200 transition duration-150" title="Ver">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path d="M10 12a2 2 0 100-4 2 2 0 000 4z" /><path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.022 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" /></svg>
                            </a>
                            <a href="{{ route('authors.edit', $author) }}" class="text-gray-600 hover:text-yellow-600 p-1 rounded hover:bg-gray-200 transition duration-150" title="Editar">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z" /><path fill-rule="evenodd" d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z" clip-rule="evenodd" /></svg>
                            </a>
                            <form action="{{ route('authors.destroy', $author) }}" method="POST" class="inline-block" onsubmit="return confirm('Tem certeza que deseja excluir este autor? {{ $author->books->count() > 0 ? 'AVISO: Este autor possui livros associados. A exclusão pode falhar se não for permitida.' : '' }}');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-gray-600 hover:text-red-600 p-1 rounded hover:bg-gray-200 transition duration-150" title="Excluir">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" /></svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center py-4 text-gray-500">Nenhum autor encontrado.</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-6">
        {{ $authors->links() }}
    </div>
@endsection