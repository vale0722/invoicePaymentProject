<?php

namespace App\Http\Requests\Invoice;

use Illuminate\Foundation\Http\FormRequest;

class InvoiceStoreRequest extends FormRequest
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
            'reference' => 'required|min:2|max:50|unique:invoices',
            'title' => 'required|min:3|max:100',
            'client' => 'required|numeric|exists:clients,id',
            'seller' => 'required|numeric|exists:sellers,id',
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
            'reference' => "Referencia",
            'title' => "Titulo",
            'client' => 'Cliente',
            'seller' => 'Vendedor',
            'product' => "Producto",
            'quantity' => "Cantidad"
        ];
    }
}
