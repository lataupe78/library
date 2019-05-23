<?php

namespace App\Models;

use App\Models\Reservation;
use App\User;
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

		if(is_array($author) && $this->validate($author,[
			'first_name' => 'required',
			'last_name' => 'required',
		])) {

			$this->attributes['author_id'] = Author::firstOrCreate([
				'first_name' => $author['first_name'],
				'last_name' => $author['last_name'],
			])->id;
		} else {
			$this->attributes['author_id'] = $author;
		}
	}


	public function reservations(){
		return $this->hasMany(Reservation::class, 'book_id');
	}


	public function checkout(User $user){
		$this->reservations()->create([
			'user_id' => $user->id,
			'checked_out_at' => now()
		]);
	}

	public function checkin(User $user){
		$reservation = $this->reservations()
		->where('user_id', $user->id)
		->whereNotNull('checked_out_at')
		->whereNull('checked_in_at')
		->first();


		if( is_null($reservation)){
			throw new \Exception('No Reservation Found');

		}
			$reservation->update([
				'checked_in_at' => now()
			]);
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
