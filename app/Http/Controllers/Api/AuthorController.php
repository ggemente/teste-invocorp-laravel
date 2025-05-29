<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Author;
use Illuminate\Http\Request;
use App\Http\Resources\AuthorResource;
use App\Http\Resources\BookResource;
use Illuminate\Support\Facades\Validator;

class AuthorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return AuthorResource::collection(Author::orderBy('name')->paginate(10));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:authors,name',
            'status' => 'required|in:active,inactive',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $author = Author::create($validator->validated());
        return new AuthorResource($author);
    }

    /**
     * Display the specified resource.
     */
    public function show(Author $author)
    {
        return new AuthorResource($author);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Author $author)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:authors,name,' . $author->id,
            'status' => 'required|in:active,inactive',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $author->update($validator->validated());
        return new AuthorResource($author);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Author $author)
    {
        if ($author->books()->count() > 0) {
            return response()->json(['error' => 'Não é possível excluir o autor, pois ele possui livros associados.'], 409);
        }

        $author->delete();
        return response()->json(null, 204);
    }

    public function booksByAuthor(Author $author)
    {
        return BookResource::collection($author->books()->paginate(10));
    }
}