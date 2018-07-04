<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class CreateOrderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'products' => 'required|array',
            'products.*.id' => 'required|integer|exists:products,id',
            'products.*.category_id' => 'required|integer|exists:categories,id',
            'products.*.quantity' => 'required|integer|min:1',
            'billing' => 'required|array',
            'billing.firstName' => 'required|string|min:2|max:100',
            'billing.lastName' => 'required|string|min:2|max:100',
            'billing.phone' => 'required|min:8|max:15',
            'billing.country' => 'required|string|max:64',
            'billing.city' => 'required|string|max:64',
            'billing.street' => 'required|string|max:64',
            'billing.email' => 'required|email',
            'billing.zipcode' => 'required|max:16',
            'billing.description' => 'max:300',
        ];
    }
}
