<?php

namespace App\Http\Requests\Invoice\Product;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
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
            'product' => 'required|exists:products,id',
            'quantity' => 'required|min:1|numeric',
        ];
    }

    /**
    * Get the custom attributes for validator errors
    *
    * @return array
    */
    public function attributes()
    {
        return [
            'product' => "Producto",
            'quantity' => "Cantidad"
        ];
    }
}
