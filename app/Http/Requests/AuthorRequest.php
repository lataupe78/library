<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AuthorRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'first_name' => 'required',
            'last_name' => 'required',
            'birth_date' => 'sometimes|date|date_format:d-m-Y',
            'death_date' => 'sometimes|date|date_format:d-m-Y',
        ];
    }
}
