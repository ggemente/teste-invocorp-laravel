<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Author;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Illuminate\Support\Str;
use Inertia\Inertia;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $books = Book::with('author')->latest()->paginate(10)
            ->through(fn ($book) => [
                'id' => $book->id,
                'title' => $book->title,
                'author' => $book->author ? ['name' => $book->author->name] : null,
                'cover_image_path' => $book->cover_image_path,
                'publication_date' => $book->publication_date->format('Y-m-d'),
            ]);

        return Inertia::render('Books/Index', [
            'books' => $books
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $authors = Author::where('status', 'active')->orderBy('name')->get()->map(fn ($author) => [
            'id' => $author->id,
            'name' => $author->name,
        ]);

        return Inertia::render('Books/Create', [
            'authors' => $authors
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'publication_date' => 'required|date',
            'author_id' => 'required|exists:authors,id',
            'cover_image' => 'nullable|image|mimes:png,jpg|max:2048',
        ], [
            'cover_image.mimes' => 'A imagem de capa deve ser um arquivo do tipo: png ou jpg.',
        ]);

        if ($request->hasFile('cover_image')) {
            $image = $request->file('cover_image');

            $allowedMimeTypes = ['image/jpeg', 'image/png'];
            if (!in_array($image->getMimeType(), $allowedMimeTypes)) {
                return back()
                    ->withErrors(['cover_image' => 'O tipo da imagem é inválido. Apenas JPEG e PNG são permitidos.'])
                    ->withInput();
            }

            $filename = Str::uuid() . '.' . $image->getClientOriginalExtension();

            $manager = new ImageManager(
                new \Intervention\Image\Drivers\Gd\Driver()
            );

            $resizedImage = $manager->read($request->file('cover_image'))
                ->resize(200, 200)
                ->toJpeg();

            Storage::disk('public')->put("covers/{$filename}", $resizedImage);

            $validatedData['cover_image_path'] = "covers/{$filename}";
        }

        Book::create($validatedData);

        return redirect()->route('books.index')->with('success', 'Livro criado com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Book $book)
    {
        $book->load('author');
        return Inertia::render('Books/Show', [
            'book' => [
                'id' => $book->id,
                'title' => $book->title,
                'description' => $book->description,
                'publication_date' => $book->publication_date->format('Y-m-d'),
                'cover_image_path' => $book->cover_image_path,
                'author' => $book->author ? [
                    'id' => $book->author->id,
                    'name' => $book->author->name,
                ] : null,
            ]
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Book $book)
    {
        $authors = Author::where('status', 'active')->orderBy('name')->get()->map(fn ($author) => [
            'id' => $author->id,
            'name' => $author->name,
        ]);

        return Inertia::render('Books/Edit', [
            'book' => [
                'id' => $book->id,
                'title' => $book->title,
                'description' => $book->description,
                'publication_date' => $book->publication_date->format('Y-m-d'),
                'author_id' => $book->author_id,
                'cover_image_path' => $book->cover_image_path,
            ],
            'authors' => $authors
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Book $book)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'publication_date' => 'required|date',
            'author_id' => 'required|exists:authors,id',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ], [
            'cover_image.mimes' => 'A imagem de capa deve ser um arquivo do tipo: jpeg, png ou jpg.',
        ]);

        if ($request->hasFile('cover_image')) {
            $image = $request->file('cover_image');

            if ($book->cover_image_path && Storage::disk('public')->exists($book->cover_image_path)) {
                Storage::disk('public')->delete($book->cover_image_path);
            }

            $filename = Str::uuid() . '.' . $image->getClientOriginalExtension();

            $manager = new ImageManager(
                new \Intervention\Image\Drivers\Gd\Driver()
            );

            $resizedImage = $manager->read($request->file('cover_image'))
                ->resize(200, 200)
                ->toJpeg();

            Storage::disk('public')->put("covers/{$filename}", $resizedImage);

            $validatedData['cover_image_path'] = "covers/{$filename}";
        }

        $book->update($validatedData);

        return redirect()->route('books.index')->with('success', 'Livro atualizado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Book $book)
    {
        if ($book->cover_image_path && Storage::disk('public')->exists($book->cover_image_path)) {
            Storage::disk('public')->delete($book->cover_image_path);
        }

        $book->delete();
        return redirect()->route('books.index')->with('success', 'Livro excluído com sucesso!');
    }
}