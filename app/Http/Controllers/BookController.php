<?php

namespace App\Http\Controllers;

use App\Http\Requests\BookRequest;
use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{

	public function index(){
		return Book::all();
	}

	public function store(BookRequest $request){

		$book = Book::create($request->validated());
		return redirect($book->path());
	}

	public function update(Book $book, BookRequest $request){
		$book->update($request->validated());
		return redirect($book->path());

	}

	public function destroy(Book $book){
		$book->delete();
		return redirect('/books');
	}
}
