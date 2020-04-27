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
            'quantity' => 'required|min:1',
        ];
    }

    /**
     * Get the custom messages for validator errors
     *
     * @return array
     */
    public function customValidationMessages()
    {
        return [
            'required' => "El :attribute es un campo obligadorio",
            'exists' => 'El :attribute no exíste'
        ];
    }
    
    /**
    * Get the custom attributes for validator errors
    *
    * @return array
    */
    public function customValidationAttributes()
    {
        return [
            'product' => "Producto",
            'quantity' => "Cantidad"
        ];
    }
}