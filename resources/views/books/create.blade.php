@extends('layouts.app')

@section('title', 'Novo Livro')

@section('content')
    <h1 class="text-2xl font-semibold text-gray-700 mb-6">Adicionar Novo Livro</h1>

    <form action="{{ route('books.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-4">
            <label for="title" class="block text-gray-700 text-sm font-bold mb-2">Título:</label>
            <input type="text" name="title" id="title" value="{{ old('title') }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('title') border-red-500 @enderror" required>
            @error('title')
            <p class="text-red-500 text-xs italic">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label for="description" class="block text-gray-700 text-sm font-bold mb-2">Descrição:</label>
            <textarea name="description" id="description" rows="5" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('description') border-red-500 @enderror" required>{{ old('description') }}</textarea>
            @error('description')
            <p class="text-red-500 text-xs italic">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label for="publication_date" class="block text-gray-700 text-sm font-bold mb-2">Data de Publicação:</label>
            <input type="date" name="publication_date" id="publication_date" value="{{ old('publication_date') }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('publication_date') border-red-500 @enderror" required>
            @error('publication_date')
            <p class="text-red-500 text-xs italic">{{ $message }}</p>
            @enderror
        </div>

           <div class="mb-4">
            <label for="cover_image" class="block text-gray-700 text-sm font-bold mb-2">Capa do Livro (JPG, PNG - Máx 2MB):</label>
            <input type="file" name="cover_image" id="cover_image" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('cover_image') border-red-500 @enderror" accept="image/jpeg,image/png,image/jpg">
            @error('cover_image')
            <p class="text-red-500 text-xs italic">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-6">
            <label for="author_id" class="block text-gray-700 text-sm font-bold mb-2">Autor:</label>
            <select name="author_id" id="author_id" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('author_id') border-red-500 @enderror" required>
                <option value="">Selecione um autor</option>
                @foreach ($authors as $author)
                    <option value="{{ $author->id }}" {{ old('author_id') == $author->id ? 'selected' : '' }}>
                        {{ $author->name }}
                    </option>
                @endforeach
            </select>
            @error('author_id')
            <p class="text-red-500 text-xs italic">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex items-center justify-between">
            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                Salvar Livro
            </button>
            <a href="{{ route('books.index') }}" class="inline-block align-baseline font-bold text-sm text-blue-500 hover:text-blue-800">
                Cancelar
            </a>
        </div>
    </form>
@endsection