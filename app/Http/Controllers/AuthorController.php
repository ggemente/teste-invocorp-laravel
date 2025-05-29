<?php

namespace App\Http\Controllers;

use App\Models\Author;
use Illuminate\Http\Request;

class AuthorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $authors = Author::orderBy('name')->paginate(10);
        return view('authors.index', compact('authors'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('authors.create');
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
        return view('authors.show', compact('author'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Author $author)
    {
        return view('authors.edit', compact('author'));
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