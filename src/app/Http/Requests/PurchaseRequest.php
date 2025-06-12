<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PurchaseRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'payment_method' => 'required|in:convenience_store,credit_card',
            // 'address' => 'required|string',
        ];
    }

    public function messages()
    {
        return [
            'payment_method.required' => '支払い方法は必須です。',
            'payment_method.in' => '支払い方法は「コンビニ払い」または「カード払い」を選択してください。',
            //'address.required' => '配送先住所は必須です。',
        ];
    }
}
