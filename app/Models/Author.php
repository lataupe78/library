<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
    public $guarded = [];

    protected $dates = [
		'birth_date',
		'death_date'
    ];

    public function setBirthDateAttribute($birth_date){
    	$this->attributes['birth_date'] = Carbon::parse($birth_date);
    }

    public function setDeathDateAttribute($death_date){
    	$this->attributes['death_date'] = Carbon::parse($death_date);
    }
}
