<?php

namespace App\Http\Controllers;

use App\Models\Author;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AuthorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $authors = Author::withCount('books')->orderBy('name')->paginate(10)
            ->through(fn ($author) => [
                'id' => $author->id,
                'name' => $author->name,
                'status' => $author->status,
                'books_count' => $author->books_count,
            ]);

        return Inertia::render('Authors/Index', [
            'authors' => $authors
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Authors/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255|unique:authors,name',
            'status' => 'required|in:active,inactive',
        ]);

        Author::create($validatedData);

        return redirect()->route('authors.index')->with('success', 'Autor criado com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Author $author)
    {
        $author->load('books');
        return Inertia::render('Authors/Show', [
            'author' => [
                'id' => $author->id,
                'name' => $author->name,
                'status' => $author->status,
                'created_at' => $author->created_at->toDateTimeString(),
                'updated_at' => $author->updated_at->toDateTimeString(),
                'books' => $author->books->map(fn ($book) => [
                    'id' => $book->id,
                    'title' => $book->title,
                    'publication_date' => $book->publication_date->format('Y-m-d'),
                ]),
            ]
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Author $author)
    {
        return Inertia::render('Authors/Edit', [
            'author' => [
                'id' => $author->id,
                'name' => $author->name,
                'status' => $author->status,
            ]
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Author $author)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255|unique:authors,name,' . $author->id,
            'status' => 'required|in:active,inactive',
        ]);

        $author->update($validatedData);

        return redirect()->route('authors.index')->with('success', 'Autor atualizado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Author $author)
    {
        if ($author->books()->count() > 0) {
            return redirect()->route('authors.index')->with('error', 'Não é possível excluir o autor, pois ele possui livros associados.');
        }

        $author->delete();

        return redirect()->route('authors.index')->with('success', 'Autor excluído com sucesso!');
    }
}