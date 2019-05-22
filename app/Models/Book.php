<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class Book extends Model
{
	public $errors;

	public $guarded = [];


	public function path(){
		return '/books/'. $this->id.'-'.Str::slug($this->title);
	}

	public function setAuthorIdAttribute($author){

		if($this->validate($author,[
			'first_name' => 'required',
			'last_name' => 'required',
		])) {

			$this->attributes['author_id'] = Author::firstOrCreate([
				'first_name' => $author['first_name'],
				'last_name' => $author['last_name'],
			])->id;

			return true;
		} else {
			return false;
		}


	}


	private function validate($data, $rules) {
		$validator = Validator::make($data, $rules);
		if($validator->passes()) {
			return true;
		} else {
			$this->errors = $validator->errors();
			return false;
		}
	}

	public function errors() {
		return $this->errors()->all();
	}
}
