<?php

namespace App\Http\Controllers;

use App\Http\Requests\BookRequest;
use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
	public function store(){
		$data = request()->validate([
			'title' => 'required',
			'author' => 'required',
		]);

		$book = Book::create($data);
	}
}
