@extends('layouts.app')

@section('title', 'Editar Autor: ' . $author->name)

@section('content')
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-semibold text-gray-700">Editar Autor</h1>
        <a href="{{ route('authors.index') }}" class="text-blue-600 hover:text-blue-800">&larr; Voltar para a lista</a>
    </div>

    <form action="{{ route('authors.update', $author) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-5">
            <label for="name" class="block text-gray-700 text-sm font-bold mb-2">Nome:</label>
            <input type="text" name="name" id="name" value="{{ old('name', $author->name) }}"
                   class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('name') border-red-500 @enderror"
                   required>
            @error('name')
            <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-6">
            <label for="status" class="block text-gray-700 text-sm font-bold mb-2">Status:</label>
            <select name="status" id="status"
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('status') border-red-500 @enderror"
                    required>
                <option value="active" {{ old('status', $author->status) == 'active' ? 'selected' : '' }}>Ativo</option>
                <option value="inactive" {{ old('status', $author->status) == 'inactive' ? 'selected' : '' }}>Inativo</option>
            </select>
            @error('status')
            <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex items-center justify-start mt-8">
            <button type="submit"
                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline transition duration-150 ease-in-out">
                Atualizar Autor
            </button>
            <a href="{{ route('authors.index') }}"
               class="ml-4 inline-block align-baseline font-bold text-sm text-gray-600 hover:text-gray-800">
                Cancelar
            </a>
        </div>
    </form>
@endsection