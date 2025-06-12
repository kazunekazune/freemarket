<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ItemRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|integer|min:300|max:9999999',
            'condition' => 'required|string',
            'image_path' => 'nullable|string',
            'categories'   => 'required|array',
            'categories.*' => 'exists:categories,id',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => '商品名は必須です',
            'name.max' => '商品名は255文字以内で入力してください',
            'description.required' => '商品の説明は必須です',
            'price.required' => '価格は必須です',
            'price.integer' => '価格は整数で入力してください',
            'price.min' => '価格は300円以上で入力してください',
            'price.max' => '価格は9,999,999円以下で入力してください',
            'image.image' => '画像ファイルを選択してください',
            'image.max' => '画像は2MB以下で選択してください',
        ];
    }
}
