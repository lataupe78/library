<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Book extends Model
{

    public $guarded = [];


    public function path(){
    	return '/books/'. $this->id.'-'.Str::slug($this->title);
    }
}
