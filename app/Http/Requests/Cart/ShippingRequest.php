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
            'name' => ['required', 'string'],
            'company' => ['string', 'nullable'],
            'email' => ['required', 'email'],
            'phone' => ['required', 'string', 'max:20'],
            'zip_code' => ['required', 'string'],
            'neighborhood' => ['required', 'string'],
            'state' => ['required', 'string'],
            'country' => ['required', 'string'],
            'city' => ['required', 'string'],
            'address' => ['required', 'string', 'max:255'],
            'notes' => ['string', 'max:255', 'nullable'],
            'shipping' => ['required', 'numeric'],
            'discount' => ['required', 'numeric'],
            'subtotal' => ['required', 'numeric'],
            'tax' => ['required', 'numeric'],
            'total' => ['required', 'numeric'],
        ];
    }
}
