@extends('layouts.app')

@section('title', 'Editar Livro: ' . $book->title)

@section('content')
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-semibold text-gray-700">Editar Livro</h1>
        <a href="{{ route('books.index') }}" class="text-blue-600 hover:text-blue-800">&larr; Voltar para a lista</a>
    </div>

    <form action="{{ route('books.update', $book) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-5">
            <label for="title" class="block text-gray-700 text-sm font-bold mb-2">Título:</label>
            <input type="text" name="title" id="title" value="{{ old('title', $book->title) }}"
                   class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('title') border-red-500 @enderror"
                   required>
            @error('title')
            <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-5">
            <label for="description" class="block text-gray-700 text-sm font-bold mb-2">Descrição:</label>
            <textarea name="description" id="description" rows="5"
                      class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('description') border-red-500 @enderror"
                      required>{{ old('description', $book->description) }}</textarea>
            @error('description')
            <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-5">
            <label for="cover_image" class="block text-gray-700 text-sm font-bold mb-2">Capa do Livro (JPG, PNG - Máx 2MB):</label>
            <input type="file" name="cover_image" id="cover_image" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('cover_image') border-red-500 @enderror" accept="image/jpeg,image/png,image/jpg">
            @error('cover_image')
            <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
            @enderror
            @if ($book->cover_image_path)
            <div class="mt-2">
                <p class="text-sm text-gray-600">Capa atual:</p>
                <img src="{{ Storage::url($book->cover_image_path) }}" alt="Capa de {{ $book->title }}" class="h-32 w-auto rounded shadow">
            </div>
            @endif
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-5">
            <div>
                <label for="publication_date" class="block text-gray-700 text-sm font-bold mb-2">Data de Publicação:</label>
                <input type="date" name="publication_date" id="publication_date"
                       value="{{ old('publication_date', $book->publication_date->format('Y-m-d')) }}"
                       class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('publication_date') border-red-500 @enderror"
                       required>
                @error('publication_date')
                <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="author_id" class="block text-gray-700 text-sm font-bold mb-2">Autor:</label>
                <select name="author_id" id="author_id"
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('author_id') border-red-500 @enderror"
                        required>
                    <option value="">Selecione um autor</option>
                    @foreach ($authors as $author)
                        <option value="{{ $author->id }}"
                            {{ old('author_id', $book->author_id) == $author->id ? 'selected' : '' }}>
                            {{ $author->name }}
                        </option>
                    @endforeach
                </select>
                @error('author_id')
                <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="flex items-center justify-start mt-8">
            <button type="submit"
                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline transition duration-150 ease-in-out">
                Atualizar Livro
            </button>
            <a href="{{ route('books.index') }}"
               class="ml-4 inline-block align-baseline font-bold text-sm text-gray-600 hover:text-gray-800">
                Cancelar
            </a>
        </div>
    </form>
@endsection