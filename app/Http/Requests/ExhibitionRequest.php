<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ExhibitionRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'image' => 'required|mimes:jpeg,png',
            'category' => 'required',
            'condition' => 'required',
            'price' => 'required|integer|min:0',
        ];
    }
}
