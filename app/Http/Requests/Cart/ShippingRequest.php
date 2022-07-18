<?php

namespace App\Http\Requests\Cart;

use Illuminate\Foundation\Http\FormRequest;

class ShippingRequest extends FormRequest
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
            'address' => ['required', 'numeric'],
            'shipping' => ['required', 'numeric'],
            'discount' => ['required', 'numeric'],
            'subtotal' => ['required', 'numeric'],
            'tax' => ['required', 'numeric'],
            'total' => ['required', 'numeric'],
        ];
    }
}
