<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function __construct(){
        $this->middleware('auth:sanctum')->except(['index']);
        $this->middleware('can:isAdmin')->only(['store', 'update', 'destroy']);
    }

    public function index(){
        $books = Book::all();
        return response()->json($books);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'isbn' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'year' => 'required|integer',
        ]);

        $book = Book::create($request->all());

        return response()->json($book, 201);
    }

    public function update(Request $request, Book $book)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'isbn' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'year' => 'required|integer',
        ]);

        $book->update($request->all());

        return response()->json($book);
    }

    public function destroy(Book $book)
    {
        $book->delete();

        return response()->json(null, 204);
    }
}
