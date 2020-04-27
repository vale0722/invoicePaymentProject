<?php

namespace App\Http\Requests\Invoice;

use  Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class InvoiceUpdateRequest extends FormRequest
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
            'reference' => ['required',
            Rule::unique('invoices')->ignoreModel($this->route('invoice'))
            ],
            'title' => 'required|min:3|max:100',
            'stateReceipt' => 'required',
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
            'required' => "El :attribute de la factura es un campo obligadorio",
            'reference.unique' => "La :attribute de la factura ya exíste",
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
            'reference' => "Referencia",
            'title' => "Titulo",
            'client' => 'Cliente',
            'seller' => 'Vendedor'
        ];
    }
}
